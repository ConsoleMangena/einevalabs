<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostPublishingTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_blog_index_shows_only_published_posts(): void
    {
        Post::factory()->create(['title' => 'Live Post']);
        Post::factory()->draft()->create(['title' => 'Hidden Draft']);

        $this->get(route('posts.index'))
            ->assertOk()
            ->assertSee('Live Post')
            ->assertDontSee('Hidden Draft');
    }

    public function test_a_scheduled_post_stays_hidden_until_its_date(): void
    {
        $post = Post::factory()->scheduled()->create(['title' => 'Future Post']);

        $this->assertFalse($post->isPublished());

        $this->get(route('posts.index'))->assertDontSee('Future Post');
        $this->get(route('posts.show', $post->slug))->assertNotFound();
    }

    public function test_a_draft_404s_at_its_public_url(): void
    {
        // The bug: the public controller returned any post by slug, so saving
        // a draft in the admin published it instantly at /blog/<slug>.
        $post = Post::factory()->draft()->create();

        $this->get(route('posts.show', $post->slug))->assertNotFound();
    }

    public function test_a_published_post_renders(): void
    {
        $post = Post::factory()->create(['title' => 'Pen Test Guide']);

        $this->get(route('posts.show', $post->slug))
            ->assertOk()
            ->assertSee('Pen Test Guide');
    }

    public function test_markdown_is_rendered_and_escaped(): void
    {
        $post = Post::factory()->create([
            'title' => 'Script Injection',
            'content' => "# Heading\n\nSome <script>alert('xss')</script> text.",
        ]);

        $response = $this->get(route('posts.show', $post->slug));

        $response->assertOk();
        // The heading becomes real markup...
        $response->assertSee('<h1>Heading</h1>', false);
        // ...but the script tag must not survive into the page.
        $response->assertDontSee('<script>alert', false);
    }

    public function test_a_javascript_link_in_markdown_is_not_usable(): void
    {
        $post = Post::factory()->create([
            'content' => '[click me](javascript:alert(1))',
        ]);

        $response = $this->get(route('posts.show', $post->slug));

        $response->assertOk();
        $response->assertDontSee('href="javascript:', false);
    }

    public function test_a_post_with_no_cover_image_renders_a_placeholder(): void
    {
        // A null cover previously rendered a broken <img> whose alt text was
        // all a visitor saw.
        $post = Post::factory()->create(['image' => null]);

        $this->get(route('posts.index'))->assertOk();
        $this->get(route('posts.show', $post->slug))->assertOk();
    }
}
