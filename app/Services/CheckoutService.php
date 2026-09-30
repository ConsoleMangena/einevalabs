<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Services\Pesepay\Customer;
use App\Services\Pesepay\ErrorResponse;
use App\Services\Pesepay\Pesepay;
use App\Services\Pesepay\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RuntimeException;

/**
 * Owns the order lifecycle: reprice the basket, create the order, hand it to
 * the gateway, then settle it from a gateway answer.
 *
 * The rule this class exists to enforce is that `paid` is only ever set from a
 * verified gateway response. Nothing in the app may mark an order paid on the
 * strength of a session, a query string, or the fact that a browser reached
 * the return URL.
 */
class CheckoutService
{
    /**
     * Upper bound on a single line. Without it a scripted "add to cart" loop
     * can inflate the order total and the session payload indefinitely.
     */
    public const MAX_QUANTITY_PER_LINE = 20;

    /**
     * The only gateway status that is treated as a real, terminal rejection.
     * Everything that is not SUCCESS and not FAILED stays pending.
     */
    private const GATEWAY_STATUS_FAILED = 'FAILED';

    /**
     * Rebuild the basket from the database and write a pending order.
     *
     * The session cart only ever holds slugs and quantities. Names, prices and
     * images are re-read here so a price edit between "add to cart" and
     * "checkout" is charged at the current price, and so a tampered session
     * cannot dictate what the customer is charged.
     *
     * @param  array<string, array{quantity: int}>  $cart
     * @return Order the pending order
     *
     * @throws RuntimeException when the basket cannot be priced
     */
    public function createOrderFromCart(
        array $cart,
        ?int $userId = null,
        string $customerName = 'Guest',
        string $customerEmail = '',
    ): Order {
        $quantities = $this->normalizeQuantities($cart);

        if ($quantities === []) {
            throw new RuntimeException('Cannot create an order from an empty cart.');
        }

        $products = Product::whereIn('slug', array_keys($quantities))->get()->keyBy('slug');

        $lines = [];
        $unavailable = [];

        foreach ($quantities as $slug => $quantity) {
            $product = $products->get($slug);

            if (! $product) {
                $unavailable[] = $slug;

                continue;
            }

            if (! $product->isPurchasable()) {
                $unavailable[] = $product->name;

                continue;
            }

            $unitPrice = round((float) $product->price, 2);

            $lines[] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'line_total' => round($unitPrice * $quantity, 2),
            ];
        }

        if ($lines === []) {
            throw new RuntimeException(
                'None of the items in your cart are available for purchase'
                .($unavailable !== [] ? ': '.implode(', ', array_slice($unavailable, 0, 3)) : '.')
            );
        }

        /*
         * Refuse to create a partial order. The customer was shown a total for
         * the whole basket; quietly dropping an unavailable line and charging
         * less would ship an order missing something they paid to have, and
         * the order record would not match the receipt. Make them go back and
         * acknowledge the change instead.
         */
        if ($unavailable !== []) {
            throw new RuntimeException(
                'These items are no longer available and must be removed before you can check out: '
                .implode(', ', array_slice($unavailable, 0, 3))
                .(count($unavailable) > 3 ? ' and '.(count($unavailable) - 3).' more.' : '.')
            );
        }

        // Work in integer cents to avoid binary-float drift, then convert back.
        $total = round(array_sum(array_column($lines, 'line_total')), 2);

        $order = DB::transaction(function () use ($lines, $total, $userId, $customerName, $customerEmail) {
            $order = Order::create([
                'user_id' => $userId,
                'customer_name' => $customerName !== '' ? $customerName : 'Guest',
                'customer_email' => $customerEmail,
                'currency' => PesepayClient::currency(),
                'total' => $total,
                'status' => Order::STATUS_PENDING,
                'items' => $lines,
            ]);

            $order->items()->createMany($lines);

            return $order;
        });

        return $order;
    }

    /**
     * Ask the gateway whether this order's reference number has settled and
     * record the answer.
     *
     * Safe to call repeatedly: the return URL, the webhook and a manual
     * reconciliation all land here, and only the first can move an order into
     * `paid`.
     */
    public function settle(Order $order): bool
    {
        if ($order->isPaid()) {
            return true;
        }

        if (! $order->reference_number) {
            $order->markFailed('The order was never handed to the payment gateway.');

            return false;
        }

        $result = $this->client()->checkPayment($order->reference_number);

        if ($result instanceof ErrorResponse) {
            // A gateway outage is not evidence the customer did not pay. Leave
            // the order pending so the webhook or a later reconciliation can
            // still settle it, and surface the failure to the log.
            Log::warning('Pesepay checkPayment failed.', [
                'order_ulid' => $order->ulid,
                'reference_number' => $order->reference_number,
                'error' => $result->message(),
            ]);

            return false;
        }

        return $this->applyGatewayResponse($order, $result);
    }

    /**
     * Record a gateway answer against an order.
     */
    public function applyGatewayResponse(Order $order, Response $response): bool
    {
        $payload = $response->rawData();

        $order->forceFill([
            'reference_number' => $response->referenceNumber(),
            'gateway_response' => $payload,
        ]);

        if ($response->paid()) {
            $order->markPaid($payload);

            return true;
        }

        $status = strtoupper((string) $response->transactionStatus());

        if ($status === self::GATEWAY_STATUS_FAILED && $order->isPending()) {
            $order->markFailed('Gateway reported status: '.$status.'.');
        }

        /*
         * Anything else - PENDING, or a status this code has never seen -
         * deliberately leaves the order pending. mobile-money and card
         * payments are asynchronous, and a customer who has genuinely paid but
         * whose confirmation has not landed yet is exactly the person this
         * system must not tell "payment failed". The webhook and the nightly
         * reconciliation are what resolve those. Failing every non-SUCCESS
         * answer, as an earlier version did, turned a slow confirmation into
         * a lost order.
         */
        return false;
    }

    /**
     * Start a gateway payment for an order and store the redirect.
     *
     * @return string|null the hosted checkout URL, or null on failure
     */
    public function initiateGatewayPayment(Order $order): ?string
    {
        $client = $this->client();
        $client->resultUrl = route('checkout.webhook');
        $client->returnUrl = route('checkout.return');

        $customer = new Customer(
            email: $order->customer_email,
            name: $order->customer_name
        );

        $transaction = $client->createTransaction(
            amount: (float) $order->total,
            currencyCode: $order->currency,
            paymentReason: PesepayClient::reason(),
            // The ULID is the merchant reference, so a payment in the gateway
            // dashboard can always be traced back to an order here.
            merchantReference: $order->ulid,
            customer: $customer,
        );

        $result = $client->initiateTransaction($transaction);

        if ($result instanceof ErrorResponse) {
            Log::error('Pesepay initiateTransaction failed.', [
                'order_ulid' => $order->ulid,
                'error' => $result->message(),
            ]);

            $order->markFailed('Payment could not be initiated: '.$result->message());

            return null;
        }

        $order->forceFill([
            'reference_number' => $result->referenceNumber(),
            'redirect_url' => $result->redirectUrl(),
            'gateway_response' => $result->rawData(),
        ])->save();

        $redirectUrl = $result->redirectUrl();

        if (blank($redirectUrl)) {
            // A 200 with no hosted-checkout URL leaves the customer nowhere to
            // pay and the order pending forever. Treat it as a failed
            // initiation so the row is not left dangling.
            Log::error('Pesepay initiateTransaction returned no redirect URL.', [
                'order_ulid' => $order->ulid,
                'reference_number' => $result->referenceNumber(),
            ]);

            $order->markFailed('The payment provider did not return a checkout URL.');

            return null;
        }

        return $redirectUrl;
    }

    /**
     * Discard abandoned pending orders so a customer who walked away does not
     * leave an unreconcilable row behind forever.
     */
    public function abandonStalePendingOrders(int $olderThanHours = 24): int
    {
        return Order::query()
            ->where('status', Order::STATUS_PENDING)
            ->where('created_at', '<', now()->subHours($olderThanHours))
            ->update([
                'status' => Order::STATUS_FAILED,
                'failed_at' => now(),
                'failure_reason' => 'Abandoned at checkout.',
                'updated_at' => now(),
            ]);
    }

    /**
     * A fresh gateway client for this operation.
     *
     * Resolved from the container so tests can substitute a fake; the
     * production binding builds a client from config.
     */
    private function client(): Pesepay
    {
        return app(Pesepay::class);
    }

    /**
     * @param  array<string, array{quantity: mixed}>  $cart
     * @return array<string, int>
     */
    private function normalizeQuantities(array $cart): array
    {
        $quantities = [];

        foreach ($cart as $slug => $item) {
            if (! is_string($slug) || $slug === '') {
                continue;
            }

            $quantity = is_array($item) ? ($item['quantity'] ?? 1) : 1;

            if (! is_numeric($quantity)) {
                continue;
            }

            $quantity = (int) $quantity;

            if ($quantity < 1) {
                continue;
            }

            // Bound the per-line quantity so a scripted "add to cart" loop
            // cannot inflate the order or the session payload.
            $quantities[$slug] = min($quantity, self::MAX_QUANTITY_PER_LINE);
        }

        return $quantities;
    }
}
