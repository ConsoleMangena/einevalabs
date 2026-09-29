<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Services\CheckoutService;
use App\Services\Pesepay\ErrorResponse;
use App\Services\Pesepay\Pesepay;
use App\Services\Pesepay\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use RuntimeException;
use Tests\TestCase;

/**
 * The order lifecycle is the part of this app where a logic error costs real
 * money, so it is tested directly rather than only through the HTTP layer.
 */
class CheckoutServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_reprices_the_basket_from_the_database(): void
    {
        $product = Product::factory()->create(['slug' => 'bench', 'price' => 120.00]);

        $order = app(CheckoutService::class)->createOrderFromCart([
            'bench' => ['quantity' => 2],
        ]);

        $this->assertSame(240.00, (float) $order->total);
        $this->assertCount(1, $order->items()->get());
        $this->assertSame('pending', $order->status);
    }

    public function test_it_ignores_a_tampered_session_price(): void
    {
        // The session cart only ever holds slug + quantity. A client that
        // injects its own price must not be able to influence the charge.
        $product = Product::factory()->create(['slug' => 'bench', 'price' => 120.00]);

        $order = app(CheckoutService::class)->createOrderFromCart([
            'bench' => ['quantity' => 1, 'price' => 1.00, 'line_total' => 1.00],
        ]);

        $this->assertSame(120.00, (float) $order->total);
    }

    public function test_it_refuses_an_empty_cart(): void
    {
        $this->expectException(RuntimeException::class);

        app(CheckoutService::class)->createOrderFromCart([]);
    }

    public function test_it_refuses_to_silently_drop_an_unavailable_item(): void
    {
        // Two items in the basket, one of which has no price. Creating a
        // partial order would charge the customer less than the total they
        // were shown and ship an order missing a line.
        Product::factory()->create(['slug' => 'available', 'price' => 50.00]);
        Product::factory()->onRequest()->create(['slug' => 'quote-only']);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessageMatches('/no longer available/i');

        app(CheckoutService::class)->createOrderFromCart([
            'available' => ['quantity' => 1],
            'quote-only' => ['quantity' => 1],
        ]);
    }

    public function test_it_caps_the_quantity_of_a_single_line(): void
    {
        Product::factory()->create(['slug' => 'bench', 'price' => 10.00]);

        $order = app(CheckoutService::class)->createOrderFromCart([
            'bench' => ['quantity' => 9999],
        ]);

        $this->assertSame(
            CheckoutService::MAX_QUANTITY_PER_LINE * 10.00,
            (float) $order->total
        );
    }

    public function test_a_pending_gateway_answer_leaves_the_order_pending(): void
    {
        // The bug this guards: every non-SUCCESS answer used to be recorded as
        // a failure, so a customer whose mobile-money confirmation was merely
        // slow was told their payment had been rejected and the order was
        // closed out from under them.
        $order = Order::factory()->pending()->create();

        $settled = app(CheckoutService::class)->applyGatewayResponse($order, $this->response('PENDING'));

        $this->assertFalse($settled);
        $this->assertTrue($order->refresh()->isPending());
        $this->assertNull($order->failed_at);
    }

    public function test_an_unknown_gateway_status_does_not_fail_the_order(): void
    {
        $order = Order::factory()->pending()->create();

        app(CheckoutService::class)->applyGatewayResponse($order, $this->response('SOMETHING_NEW'));

        $this->assertTrue($order->refresh()->isPending());
    }

    public function test_a_failed_gateway_status_fails_the_order(): void
    {
        $order = Order::factory()->pending()->create();

        $settled = app(CheckoutService::class)->applyGatewayResponse($order, $this->response('FAILED'));

        $this->assertFalse($settled);
        $this->assertSame(Order::STATUS_FAILED, $order->refresh()->status);
    }

    public function test_a_success_response_marks_the_order_paid(): void
    {
        $order = Order::factory()->pending()->create();

        $settled = app(CheckoutService::class)->applyGatewayResponse($order, $this->response('SUCCESS'));

        $this->assertTrue($settled);
        $this->assertTrue($order->refresh()->isPaid());
        $this->assertNotNull($order->paid_at);
    }

    public function test_settlement_is_idempotent(): void
    {
        // The return URL, the webhook and a manual reconciliation can all fire
        // for one payment. paid_at must record the first settlement only.
        $order = Order::factory()->pending()->create();
        $service = app(CheckoutService::class);

        $service->applyGatewayResponse($order, $this->response('SUCCESS'));
        $firstPaidAt = $order->refresh()->paid_at;

        $this->assertTrue($service->applyGatewayResponse($order, $this->response('SUCCESS')));

        $this->assertTrue($firstPaidAt->equalTo($order->refresh()->paid_at));
    }

    public function test_a_late_failure_cannot_walk_back_a_paid_order(): void
    {
        $order = Order::factory()->paid()->create();

        app(CheckoutService::class)->applyGatewayResponse($order, $this->response('FAILED'));

        $this->assertTrue($order->refresh()->isPaid());
    }

    public function test_an_order_without_a_gateway_reference_is_failed_not_paid(): void
    {
        $order = Order::factory()->pending()->create(['reference_number' => null]);

        $this->assertFalse(app(CheckoutService::class)->settle($order));
        $this->assertSame(Order::STATUS_FAILED, $order->refresh()->status);
    }

    public function test_a_gateway_outage_leaves_the_order_pending(): void
    {
        // An unreachable gateway is not evidence the customer did not pay.
        $this->swap(Pesepay::class, new FakePesepay(
            checkResult: new ErrorResponse('Connection timed out.'),
        ));

        $order = Order::factory()->pending()->create();

        $this->assertFalse(app(CheckoutService::class)->settle($order));
        $this->assertTrue($order->refresh()->isPending());
    }

    public function test_a_successful_poll_settles_a_pending_order(): void
    {
        $this->swap(Pesepay::class, new FakePesepay(
            checkResult: $this->response('SUCCESS'),
        ));

        $order = Order::factory()->pending()->create();

        $this->assertTrue(app(CheckoutService::class)->settle($order));
        $this->assertTrue($order->refresh()->isPaid());
    }

    private function response(string $status): Response
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
