<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StorefrontTest extends TestCase
{
    use RefreshDatabase;

    /*
     |----------------------------------------------------------------------
     | Image URL accessors
     |----------------------------------------------------------------------
     |
     | Product::getImageUrlAttribute() resolves the stored path to a public URL.
     | An earlier version read $this->image_url inside its own body, which
     | re-entered the accessor: Eloquent calls get{StudlyKey}Attribute() when
     | it sees a get mutator, so every product page and cart render that
     | touched an image died with a stack overflow. These tests exist to make
     | that impossible to reintroduce unnoticed.
     |
     */

    public function test_it_resolves_a_stored_product_image_path_to_a_public_url(): void
    {
        $product = Product::factory()->create(['image_url' => 'products/laptop.png']);

        $this->assertSame(asset('storage/products/laptop.png'), $product->image_url);
    }

    public function test_it_leaves_an_absolute_product_image_url_alone(): void
    {
        $product = Product::factory()->create(['image_url' => 'https://cdn.example.com/a.png']);

        $this->assertSame('https://cdn.example.com/a.png', $product->image_url);
    }

    public function test_a_product_with_no_image_resolves_to_null(): void
    {
        $product = Product::factory()->withoutImage()->create();

        $this->assertNull($product->image_url);
        $this->assertSame([], $product->gallery_urls);
    }

    public function test_it_resolves_every_product_gallery_image(): void
    {
        $product = Product::factory()->create([
            'image_url' => null,
            'images' => ['products/a.png', 'products/b.png'],
        ]);

        $this->assertSame([
            asset('storage/products/a.png'),
            asset('storage/products/b.png'),
        ], $product->gallery_urls);
    }

    public function test_it_resolves_a_stored_post_cover_image(): void
    {
        $post = Post::factory()->create(['image' => 'posts/cover.jpg']);

        $this->assertSame(asset('storage/posts/cover.jpg'), $post->image_url);
    }

    public function test_a_product_page_renders_with_an_image(): void
    {
        $product = Product::factory()->create(['image_url' => 'products/laptop.png']);

        $this->get(route('products.show', $product->slug))
            ->assertOk()
            ->assertSee(asset('storage/products/laptop.png'), false);
    }

    /*
     |----------------------------------------------------------------------
     | Storefront pages
     |----------------------------------------------------------------------
     */

    public function test_the_store_index_lists_categories(): void
    {
        Product::factory()->create(['category' => 'Workstations']);
        Product::factory()->create(['category' => 'Comms']);

        $this->get(route('products.index'))
            ->assertOk()
            ->assertSee('Workstations')
            ->assertSee('Comms');
    }

    public function test_the_store_index_says_so_when_it_is_empty(): void
    {
        $this->get(route('products.index'))
            ->assertOk()
            ->assertSee('being stocked');
    }

    public function test_a_category_page_paginates_and_404s_when_empty(): void
    {
        Product::factory()->count(30)->create(['category' => 'Lab Hardware']);

        $this->get(route('products.category', 'Lab Hardware'))
            ->assertOk();

        $this->get(route('products.category', 'Nothing Here'))
            ->assertNotFound();
    }

    /*
     |----------------------------------------------------------------------
     | Cart
     |----------------------------------------------------------------------
     */

    public function test_adding_to_cart_requires_post(): void
    {
        $product = Product::factory()->create();

        // Previously answered GET, so it fired from an <img> src or a link
        // prefetcher with no CSRF token and no intent.
        $this->get(route('products.addToCart', $product->slug))->assertMethodNotAllowed();

        $this->post(route('products.addToCart', $product->slug))->assertRedirect();

        $this->assertSame(1, session('cart')[$product->slug]['quantity']);
    }

    public function test_adding_to_cart_stores_only_the_slug_and_quantity(): void
    {
        $product = Product::factory()->create(['price' => 99.00]);

        $this->post(route('products.addToCart', $product->slug));

        // The session must not be able to dictate a price.
        $this->assertSame(['quantity' => 1], session('cart')[$product->slug]);
    }

    public function test_an_on_request_product_cannot_be_added_to_the_cart(): void
    {
        $product = Product::factory()->onRequest()->create();

        $this->post(route('products.addToCart', $product->slug))
            ->assertSessionHas('error');

        $this->assertNull(session('cart'));
    }

    public function test_the_cart_page_shows_the_live_price(): void
    {
        $product = Product::factory()->create(['name' => 'Hardened Laptop', 'price' => 1200.00]);

        $this->withSession(['cart' => [$product->slug => ['quantity' => 2]]])
            ->get(route('products.cart'))
            ->assertOk()
            ->assertSee('Hardened Laptop')
            ->assertSee('2,400.00');
    }

    public function test_the_cart_drops_lines_whose_product_disappeared(): void
    {
        Product::factory()->create(['price' => 50.00]);

        $this->withSession(['cart' => ['ghost-product' => ['quantity' => 1]]])
            ->get(route('products.cart'))
            ->assertOk();
    }

    public function test_the_social_share_card_is_a_raster_image(): void
    {
        // Facebook, LinkedIn, Slack and X do not render SVG og:images, so an
        // SVG share card means every shared link previews as a blank box.
        $response = $this->get(route('home'))->assertOk();

        $response->assertSee('og-share.png', false);
        $response->assertDontSee('assets/images/og-share.svg', false);
        $response->assertSee('property="og:image:width" content="1200"', false);
        $response->assertSee('property="og:image:type" content="image/png"', false);
    }

    public function test_the_share_card_asset_actually_exists(): void
    {
        // The meta tag is not enough: a 404 on the image leaves the preview
        // blank just as surely as an SVG does.
        $path = public_path('assets/images/og-share.png');

        $this->assertFileExists($path);

        $size = getimagesize($path);

        $this->assertSame(1200, $size[0]);
        $this->assertSame(630, $size[1]);
        $this->assertSame('image/png', $size['mime']);
    }
}
