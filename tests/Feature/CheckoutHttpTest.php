<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Services\Pesepay\ErrorResponse;
use App\Services\Pesepay\Pesepay;
use App\Services\Pesepay\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * The HTTP surface of checkout.
 *
 * CheckoutServiceTest proves the order lifecycle in isolation. This file
 * proves the wiring around it: that the routes, session, redirects and views
 * cannot be used to obtain a paid order, or to lose one.
 */
class CheckoutHttpTest extends TestCase
{
    use RefreshDatabase;

    private const GATEWAY_URL = 'https://checkout.pesepay.com/hosted/abc123';

    /*
     |----------------------------------------------------------------------
     | Initiating a payment
     |----------------------------------------------------------------------
     */

    public function test_checkout_creates_a_pending_order_and_hands_off_to_the_gateway(): void
    {
        Product::factory()->create(['slug' => 'bench', 'price' => 120.00]);

        $this->swap(Pesepay::class, new FakePesepay(
            initiateResult: $this->initiateResponse(),
        ));

        $this->withSession(['cart' => ['bench' => ['quantity' => 2]]])
            ->post(route('checkout'), [
                'customer_email' => 'ada@example.com',
                'customer_name' => 'Ada Lovelace',
            ])
            ->assertRedirect(self::GATEWAY_URL);

        $order = Order::firstOrFail();

        $this->assertTrue($order->isPending(), 'A new order must never start out paid.');
        $this->assertSame(240.00, (float) $order->total);
        $this->assertSame('ada@example.com', $order->customer_email);
        $this->assertSame('Ada Lovelace', $order->customer_name);
        $this->assertSame('REF-1234', $order->reference_number);
    }

    public function test_checkout_clears_the_cart_and_remembers_the_order_for_the_return_leg(): void
    {
        Product::factory()->create(['slug' => 'bench', 'price' => 120.00]);

        $this->swap(Pesepay::class, new FakePesepay(initiateResult: $this->initiateResponse()));

        $this->withSession(['cart' => ['bench' => ['quantity' => 1]]])
            ->post(route('checkout'), ['customer_email' => 'ada@example.com'])
            ->assertRedirect(self::GATEWAY_URL)
            ->assertSessionMissing('cart')
            ->assertSessionHas('checkout_order_ulid', Order::firstOrFail()->ulid);
    }

    public function test_checkout_is_not_reachable_by_get(): void
    {
        // As a GET this spent a gateway reference number and produced a live
        // payment on every link prefetch and double click.
        Product::factory()->create(['slug' => 'bench', 'price' => 120.00]);

        $this->withSession(['cart' => ['bench' => ['quantity' => 1]]])
            ->get(route('checkout'))
            ->assertStatus(405);

        $this->assertSame(0, Order::query()->count());
    }

    public function test_checkout_requires_an_email_address(): void
    {
        Product::factory()->create(['slug' => 'bench', 'price' => 120.00]);

        $this->withSession(['cart' => ['bench' => ['quantity' => 1]]])
            ->post(route('checkout'), ['customer_email' => 'not-an-email'])
            ->assertSessionHasErrors('customer_email');

        $this->assertSame(0, Order::query()->count());
    }

    public function test_an_empty_cart_cannot_be_checked_out(): void
    {
        $this->post(route('checkout'), ['customer_email' => 'ada@example.com'])
            ->assertRedirect(route('products.cart'))
            ->assertSessionHas('error');

        $this->assertSame(0, Order::query()->count());
    }

    public function test_a_gateway_that_will_not_initiate_fails_the_order_instead_of_hanging(): void
    {
        Product::factory()->create(['slug' => 'bench', 'price' => 120.00]);

        $this->swap(Pesepay::class, new FakePesepay(
            initiateResult: new ErrorResponse('Insufficient merchant balance.'),
        ));

        $this->withSession(['cart' => ['bench' => ['quantity' => 1]]])
            ->post(route('checkout'), ['customer_email' => 'ada@example.com'])
            ->assertRedirect(route('products.cart'))
            ->assertSessionHas('error');

        $order = Order::firstOrFail();

        $this->assertTrue($order->isFailed());
        $this->assertFalse($order->isPaid());
    }

    /*
     |----------------------------------------------------------------------
     | Returning from the gateway
     |----------------------------------------------------------------------
     */

    public function test_the_return_page_confirms_a_payment_only_after_the_gateway_agrees(): void
    {
        $order = $this->placeOrder();

        $this->swap(Pesepay::class, new FakePesepay(checkResult: $this->checkResponse('SUCCESS')));

        $this->withSession(['checkout_order_ulid' => $order->ulid])
            ->get(route('checkout.return'))
            ->assertOk()
            ->assertViewIs('products.checkout')
            ->assertSee('REF-1234');

        $this->assertTrue($order->refresh()->isPaid());
    }

    public function test_the_return_page_does_not_claim_success_while_the_payment_is_still_pending(): void
    {
        // The most damaging lie this app could tell: a customer whose
        // confirmation has not landed yet must not be shown a receipt.
        $order = $this->placeOrder();

        $this->swap(Pesepay::class, new FakePesepay(checkResult: $this->checkResponse('PENDING')));

        $this->withSession(['checkout_order_ulid' => $order->ulid])
            ->get(route('checkout.return'))
            ->assertOk()
            ->assertViewIs('products.pending')
            ->assertViewMissing('products.checkout');

        $this->assertTrue($order->refresh()->isPending());
        $this->assertFalse($order->refresh()->isPaid());
    }

    public function test_a_refresh_of_the_return_page_still_finds_the_order(): void
    {
        // The return URL gets refreshed constantly on mobile-money payments.
        // Reading the reference out of the session instead of pulling it means
        // the second visit behaves the same as the first.
        $order = $this->placeOrder();

        $this->swap(Pesepay::class, new FakePesepay(checkResult: $this->checkResponse('PENDING')));

        $this->withSession(['checkout_order_ulid' => $order->ulid]);

        $this->get(route('checkout.return'))->assertViewIs('products.pending');
        $this->get(route('checkout.return'))->assertViewIs('products.pending');
    }

    public function test_the_return_page_redirects_when_the_session_has_no_order(): void
    {
        $this->get(route('checkout.return'))
            ->assertRedirect(route('products.cart'))
            ->assertSessionHas('error');
    }

    public function test_the_return_page_will_not_render_a_success_page_for_a_terminal_rejection(): void
    {
        $order = $this->placeOrder();

        $this->swap(Pesepay::class, new FakePesepay(checkResult: $this->checkResponse('FAILED')));

        $this->withSession(['checkout_order_ulid' => $order->ulid])
            ->get(route('checkout.return'))
            ->assertOk()
            ->assertViewIs('products.pending')
            ->assertViewHas('failed', true);

        $this->assertTrue($order->refresh()->isFailed());
    }

    /*
     |----------------------------------------------------------------------
     | Webhook
     |----------------------------------------------------------------------
     */

    public function test_the_webhook_settles_a_known_reference(): void
    {
        $order = Order::factory()->pending()->create(['reference_number' => 'REF-1234']);

        $this->swap(Pesepay::class, new FakePesepay(checkResult: $this->checkResponse('SUCCESS')));

        $this->postJson(route('checkout.webhook'), ['referenceNumber' => 'REF-1234'])
            ->assertOk()
            ->assertJson(['status' => 'paid']);

        $this->assertTrue($order->refresh()->isPaid());
    }

    public function test_the_webhook_reads_the_reference_from_the_header_too(): void
    {
        $order = Order::factory()->pending()->create(['reference_number' => 'REF-1234']);

        $this->swap(Pesepay::class, new FakePesepay(checkResult: $this->checkResponse('SUCCESS')));

        $this->post(route('checkout.webhook'), [], [
            'x-pesepay-reference-number' => 'REF-1234',
        ])->assertOk()->assertJson(['status' => 'paid']);

        $this->assertTrue($order->refresh()->isPaid());
    }

    public function test_the_webhook_cannot_settle_an_unknown_reference(): void
    {
        $this->swap(Pesepay::class, new FakePesepay(checkResult: $this->checkResponse('SUCCESS')));

        $this->postJson(route('checkout.webhook'), ['referenceNumber' => 'REF-NOPE'])
            ->assertOk()
            ->assertJson(['status' => 'unknown_reference']);
    }

    public function test_a_webhook_without_a_reference_is_acknowledged_and_records_nothing(): void
    {
        // Answering 4xx would make the gateway retry forever; the submission is
        // simply unusable.
        $this->postJson(route('checkout.webhook'))
            ->assertOk()
            ->assertJson(['status' => 'ignored']);

        $this->assertSame(0, Order::query()->where('status', Order::STATUS_PAID)->count());
    }

    public function test_the_webhook_keeps_an_order_pending_when_the_gateway_is_unreachable(): void
    {
        $order = Order::factory()->pending()->create(['reference_number' => 'REF-1234']);

        $this->swap(Pesepay::class, new FakePesepay(
            checkResult: new ErrorResponse('Connection timed out.'),
        ));

        $this->postJson(route('checkout.webhook'), ['referenceNumber' => 'REF-1234'])
            ->assertOk()
            ->assertJson(['status' => 'pending']);

        $this->assertTrue($order->refresh()->isPending());
    }

    /*
     |----------------------------------------------------------------------
     | Helpers
     |----------------------------------------------------------------------
     */

    /**
     * Run a real checkout and hand back the pending order it produced.
     */
    private function placeOrder(): Order
    {
        Product::factory()->create(['slug' => 'bench', 'price' => 120.00]);

        $this->swap(Pesepay::class, new FakePesepay(initiateResult: $this->initiateResponse()));

        $this->withSession(['cart' => ['bench' => ['quantity' => 1]]])
            ->post(route('checkout'), ['customer_email' => 'ada@example.com'])
            ->assertRedirect(self::GATEWAY_URL);

        return Order::firstOrFail();
    }

    private function initiateResponse(): Response
    {
        return new Response(
            referenceNumber: 'REF-1234',
            pollUrl: 'https://api.pesepay.com/poll/REF-1234',
            redirectUrl: self::GATEWAY_URL,
            paid: false,
            data: [
                'referenceNumber' => 'REF-1234',
                'transactionStatus' => 'INITIATED',
            ],
        );
    }

    private function checkResponse(string $status): Response
    {
        return new Response(
            referenceNumber: 'REF-1234',
            pollUrl: 'https://api.pesepay.com/poll/REF-1234',
            redirectUrl: null,
            paid: $status === 'SUCCESS',
            data: [
                'referenceNumber' => 'REF-1234',
                'transactionStatus' => $status,
            ],
        );
    }
}
