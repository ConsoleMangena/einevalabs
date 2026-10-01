<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * The admin login form only works if Livewire's JavaScript loads.
 *
 * Filament renders the login form as a <form method="post"> carrying
 * wire:submit="authenticate", and filament.admin.auth.login only accepts GET.
 * If Livewire's JS never boots, the browser does not intercept that submit,
 * falls back to a native form POST, and the user gets a 405 Method Not Allowed
 * on /admin/login instead of a sign-in attempt.
 *
 * That failure was caused by config('livewire.asset_url'), which Livewire uses
 * as the complete <script src> verbatim rather than as a directory to append
 * the filename to - so 'asset_url' => '/vendor' emitted src="/vendor", a
 * directory. These assert the emitted src points at a JavaScript file that
 * actually exists, which is what the browser needs in order to boot Livewire.
 */
class LivewireAssetTest extends TestCase
{
    private function scriptSrc(): string
    {
        $response = $this->get('/admin/login')->assertSuccessful();

        $html = $response->getContent();

        // The Livewire bundle is the one script carrying data-update-uri; that
        // attribute is Livewire's, so it identifies the tag unambiguously
        // among the admin panel's other assets.
        $this->assertMatchesRegularExpression(
            '/<script[^>]*\ssrc="([^"]+)"[^>]*data-update-uri/',
            $html,
            'The admin login page rendered no Livewire script tag.',
        );

        preg_match('/<script[^>]*\ssrc="([^"]+)"[^>]*data-update-uri/', $html, $matches);

        return html_entity_decode($matches[1]);
    }

    public function test_the_livewire_script_points_at_javascript_and_not_a_directory(): void
    {
        $path = parse_url($this->scriptSrc(), PHP_URL_PATH);

        $this->assertIsString($path);
        $this->assertStringEndsWith('.js', $path, "The Livewire script src resolved to {$path}, which is not a JavaScript file.");
    }

    public function test_the_livewire_script_is_an_existing_file_on_disk(): void
    {
        $path = ltrim((string) parse_url($this->scriptSrc(), PHP_URL_PATH), '/');

        // assertFileExists alone is not enough: public/vendor exists as a
        // directory, so the broken src passes that check while still serving no
        // JavaScript to the browser.
        $absolute = public_path($path);

        $this->assertFileExists($absolute);
        $this->assertFalse(
            is_dir($absolute),
            "{$path} is a directory, so the browser gets no JavaScript from it.",
        );
    }

    public function test_the_livewire_script_is_a_static_asset_and_not_a_route(): void
    {
        /*
         * A directory src does not necessarily fail on every server, which is
         * why this shipped broken rather than erroring in development. The file
         * has to be served straight off disk by the web server, so no route may
         * claim its URI - if one does, PHP is answering a request the browser
         * believes is for a static file.
         */
        $path = ltrim((string) parse_url($this->scriptSrc(), PHP_URL_PATH), '/');

        $routes = collect($this->app['router']->getRoutes())
            ->reject(fn ($route) => in_array('GET', $route->methods(), true) === false)
            ->filter(fn ($route) => $route->uri() === $path);

        $this->assertCount(
            0,
            $routes,
            "A route claims {$path}, which must be served as a static file instead.",
        );
    }
}
