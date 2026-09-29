<?php

namespace Tests\Feature;

use App\Models\ContactSubmission;
use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use App\Models\Subscriber;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class AdminAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_non_admin_cannot_reach_the_panel(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->actingAs($user)->get('/admin')->assertForbidden();
    }

    public function test_a_guest_cannot_reach_the_panel(): void
    {
        $this->get('/admin')->assertRedirect();
    }

    public function test_an_admin_can_reach_the_panel(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $this->actingAs($user)->get('/admin')->assertSuccessful();
    }

    public function test_can_access_panel_reflects_the_flag(): void
    {
        $this->assertFalse(User::factory()->create(['is_admin' => false])->canAccessPanel(
            Filament::getPanel('admin')
        ));

        $this->assertTrue(User::factory()->create(['is_admin' => true])->canAccessPanel(
            Filament::getPanel('admin')
        ));
    }

    /*
     |----------------------------------------------------------------------
     | Per-resource policies
     |----------------------------------------------------------------------
     |
     | These are asserted directly against the Gate because Filament resolves
     | the abilities the same way. The single-argument signatures these
     | policies used to have raised an ArgumentCountError on the first View or
     | Edit click, so each ability is called with the model it will be called
     | with in production.
     |
     */

    public function test_post_abilities_resolve_with_a_model_argument(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $post = Post::factory()->create();

        $this->assertTrue(Gate::forUser($admin)->allows('viewAny', Post::class));
        $this->assertTrue(Gate::forUser($admin)->allows('view', $post));
        $this->assertTrue(Gate::forUser($admin)->allows('create', Post::class));
        $this->assertTrue(Gate::forUser($admin)->allows('update', $post));
        $this->assertTrue(Gate::forUser($admin)->allows('delete', $post));
        $this->assertTrue(Gate::forUser($admin)->allows('deleteAny', Post::class));
    }

    public function test_a_non_admin_is_denied_every_post_ability(): void
    {
        $user = User::factory()->create(['is_admin' => false]);
        $post = Post::factory()->create();

        $this->assertFalse(Gate::forUser($user)->allows('viewAny', Post::class));
        $this->assertFalse(Gate::forUser($user)->allows('view', $post));
        $this->assertFalse(Gate::forUser($user)->allows('update', $post));
        $this->assertFalse(Gate::forUser($user)->allows('delete', $post));
    }

    public function test_orders_cannot_be_deleted_even_by_an_admin(): void
    {
        // An order is a financial record; bulk delete was available because
        // OrderPolicy had no deleteAny() hook at all.
        $admin = User::factory()->create(['is_admin' => true]);
        $order = Order::factory()->create();

        $this->assertFalse(Gate::forUser($admin)->allows('deleteAny', Order::class));
        $this->assertFalse(Gate::forUser($admin)->allows('delete', $order));
        $this->assertTrue(Gate::forUser($admin)->allows('view', $order));
    }

    public function test_subscribers_cannot_be_created(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->assertFalse(Gate::forUser($admin)->allows('create', Subscriber::class));
    }

    public function test_contact_submissions_are_read_only(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $submission = ContactSubmission::factory()->create();

        $this->assertTrue(Gate::forUser($admin)->allows('view', $submission));
        $this->assertFalse(Gate::forUser($admin)->allows('create', ContactSubmission::class));
        $this->assertFalse(Gate::forUser($admin)->allows('update', $submission));
        $this->assertFalse(Gate::forUser($admin)->allows('delete', $submission));
    }

    public function test_product_abilities_are_available_to_an_admin(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $product = Product::factory()->create();

        $this->assertTrue(Gate::forUser($admin)->allows('create', Product::class));
        $this->assertTrue(Gate::forUser($admin)->allows('update', $product));
    }
}
