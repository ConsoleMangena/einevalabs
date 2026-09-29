<?php

namespace Tests\Feature;

use App\Filament\Resources\ContactSubmissionResource\Pages\ListContactSubmissions;
use App\Filament\Resources\ContactSubmissionResource\Pages\ViewContactSubmission;
use App\Filament\Resources\OrderResource\Pages\ListOrders;
use App\Filament\Resources\OrderResource\Pages\ViewOrder;
use App\Filament\Resources\PostResource\Pages\CreatePost;
use App\Filament\Resources\PostResource\Pages\EditPost;
use App\Filament\Resources\PostResource\Pages\ListPosts;
use App\Filament\Resources\PostResource\Pages\ViewPost;
use App\Filament\Resources\ProductResource\Pages\EditProduct;
use App\Filament\Resources\ProductResource\Pages\ListProducts;
use App\Filament\Resources\SubscriberResource\Pages\ListSubscribers;
use App\Models\ContactSubmission;
use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use App\Models\Subscriber;
use App\Models\User;
use App\Services\Pesepay\ErrorResponse;
use App\Services\Pesepay\Pesepay;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * The admin pages are actually rendered.
 *
 * Gate tests prove who may reach a resource; they say nothing about whether
 * the page builds. ViewPost and ViewOrder were rebuilt on Filament's infolist
 * API, and every one of those classes raises at render time for a bad field
 * name or a component that does not exist - a 500 an authorization test will
 * never see. This walks each page with a real record.
 */
class AdminPagesRenderTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($this->admin);

        Filament::setCurrentPanel(Filament::getPanel('admin'));
    }

    public function test_the_post_pages_render(): void
    {
        $post = Post::factory()->create();

        Livewire::test(ListPosts::class)->assertSuccessful();
        Livewire::test(CreatePost::class)->assertSuccessful();
        Livewire::test(EditPost::class, ['record' => $post->getRouteKey()])->assertSuccessful();
        Livewire::test(ViewPost::class, ['record' => $post->getRouteKey()])->assertSuccessful();
    }

    public function test_the_view_post_page_shows_the_article(): void
    {
        $post = Post::factory()->create([
            'title' => 'Threat modelling for payment gateways',
            'content' => '## Heading\n\nSome body copy.',
        ]);

        Livewire::test(ViewPost::class, ['record' => $post->getRouteKey()])
            ->assertSuccessful()
            ->assertSee('Threat modelling for payment gateways');
    }

    public function test_the_order_pages_render(): void
    {
        $order = Order::factory()->create();

        Livewire::test(ListOrders::class)->assertSuccessful();
        Livewire::test(ViewOrder::class, ['record' => $order->getRouteKey()])->assertSuccessful();
    }

    public function test_the_view_order_page_shows_the_reference_and_items(): void
    {
        // The infolist reads the order items relation, so an order with no
        // lines must still render.
        $order = Order::factory()->create([
            'reference_number' => 'REF-RENDER-1',
            'customer_email' => 'ada@example.com',
        ]);

        Livewire::test(ViewOrder::class, ['record' => $order->getRouteKey()])
            ->assertSuccessful()
            ->assertSee('REF-RENDER-1');
    }

    public function test_the_product_pages_render(): void
    {
        $product = Product::factory()->create();

        Livewire::test(ListProducts::class)->assertSuccessful();
        Livewire::test(EditProduct::class, ['record' => $product->getRouteKey()])->assertSuccessful();
    }

    public function test_the_subscriber_and_contact_pages_render(): void
    {
        $submission = ContactSubmission::factory()->create();
        Subscriber::factory()->create();

        Livewire::test(ListSubscribers::class)->assertSuccessful();
        Livewire::test(ListContactSubmissions::class)->assertSuccessful();
        Livewire::test(ViewContactSubmission::class, ['record' => $submission->getRouteKey()])
            ->assertSuccessful();
    }

    public function test_the_list_pages_survive_an_empty_table(): void
    {
        // An empty result set takes a different render path in Filament and is
        // where "property on null" errors hide.
        Livewire::test(ListPosts::class)->assertSuccessful();
        Livewire::test(ListProducts::class)->assertSuccessful();
        Livewire::test(ListOrders::class)->assertSuccessful();
        Livewire::test(ListSubscribers::class)->assertSuccessful();
        Livewire::test(ListContactSubmissions::class)->assertSuccessful();
    }

    public function test_reconcile_settles_pending_orders_against_the_gateway(): void
    {
        Order::factory()->pending()->create(['reference_number' => 'REF-A']);
        Order::factory()->pending()->create(['reference_number' => 'REF-B']);

        $this->swap(Pesepay::class, new FakePesepay(checkStatus: 'SUCCESS'));

        Livewire::test(ListOrders::class)
            ->callAction('reconcile')
            ->assertHasNoActionErrors();

        $this->assertSame(0, Order::query()->where('status', Order::STATUS_PENDING)->count());
        $this->assertSame(2, Order::query()->where('status', Order::STATUS_PAID)->count());
    }

    public function test_reconcile_survives_an_unreachable_gateway(): void
    {
        // The time-boxed loop must not turn a gateway outage into a failed page.
        Order::factory()->pending()->create(['reference_number' => 'REF-A']);

        $this->swap(Pesepay::class, new FakePesepay(
            checkResult: new ErrorResponse('Connection timed out.'),
        ));

        Livewire::test(ListOrders::class)
            ->callAction('reconcile')
            ->assertHasNoActionErrors();

        $this->assertSame(1, Order::query()->where('status', Order::STATUS_PENDING)->count());
    }
}
