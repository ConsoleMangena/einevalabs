<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublicPagesRenderTest extends TestCase
{
    public function test_home_page_renders_with_correct_copy(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Securing Africa\'s Digital Future', false);
        $response->assertSee('Africa\'s dedicated cybersecurity research laboratory', false);
    }

    public function test_ethics_page_renders(): void
    {
        $response = $this->get('/ethics');

        $response->assertStatus(200);
    }
}
