<?php

namespace App\Providers;

use App\Models\ContactSubmission;
use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use App\Models\Subscriber;
use App\Policies\ContactSubmissionPolicy;
use App\Policies\OrderPolicy;
use App\Policies\PostPolicy;
use App\Policies\ProductPolicy;
use App\Policies\SubscriberPolicy;
use App\Services\Pesepay\Pesepay;
use App\Services\PesepayClient;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        /*
         | Filament resource policies are declared explicitly rather than left
         | to Laravel's App\Models\X -> App\Policies\XPolicy auto-discovery, so
         | a renamed or relocated model fails loudly at boot instead of quietly
         | losing its authorization checks.
         */
        $policies = [
            Post::class => PostPolicy::class,
            Product::class => ProductPolicy::class,
            Subscriber::class => SubscriberPolicy::class,
            ContactSubmission::class => ContactSubmissionPolicy::class,
            Order::class => OrderPolicy::class,
        ];

        foreach ($policies as $model => $policy) {
            Gate::policy($model, $policy);
        }

        /*
         | Resolved through the container rather than via a static
         | PesepayClient::make() call so the gateway can be replaced in a test.
         | Binding (not singleton) gives every resolution a fresh client, which
         | matters because initiateGatewayPayment writes per-order result and
         | return URLs onto the instance.
         */
        $this->app->bind(
            Pesepay::class,
            fn () => PesepayClient::make()
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        $this->registerRateLimiters();
        $this->forceHttpsInProduction();
        $this->configurePagination();
    }

    /**
     * The site ships Bootstrap 5 and no Tailwind, and Laravel's default
     * paginator view is the Tailwind one. Without this switch the blog renders
     * unstyled pagination.
     */
    private function configurePagination(): void
    {
        Paginator::useBootstrapFive();
    }

    /**
     * Trusted proxies are configured in bootstrap/app.php via the middleware
     * builder; this only pins the scheme so generated absolute URLs (canonical
     * tags, the gateway result/return URLs) are https in production.
     *
     * The flag is read through config() because env() returns null once
     * `php artisan config:cache` has run, which would drop the https pin in
     * production and hand the gateway an http:// return URL.
     */
    private function forceHttpsInProduction(): void
    {
        if (app()->isProduction() && (bool) config('app.force_https', true)) {
            URL::forceScheme('https');
        }
    }

    /**
     * Without these, the contact form and the newsletter endpoint are an open
     * relay for filling the database and burning the third-party mail quota,
     * and checkout can be driven in a loop.
     */
    private function registerRateLimiters(): void
    {
        RateLimiter::for('contact', fn (Request $request) => Limit::perMinute(5)
            ->by($request->ip())
            ->response(fn () => back()->with('error', 'Too many messages sent. Please try again shortly.')));

        RateLimiter::for('newsletter', fn (Request $request) => Limit::perMinute(5)
            ->by($request->ip())
            ->response(fn () => back()->with('error', 'Too many subscribe attempts. Please try again shortly.')));

        // A shopper clicking "add to cart" repeatedly should not be blocked,
        // but a script looping the endpoint should be.
        RateLimiter::for('add-to-cart', fn (Request $request) => Limit::perMinute(30)
            ->by($request->ip()));

        // Each hit creates a real gateway reference number, so this is the one
        // endpoint where being tight is correct.
        RateLimiter::for('checkout', fn (Request $request) => Limit::perMinute(5)
            ->by($request->ip())
            ->response(fn () => back()->with('error', 'Too many checkout attempts. Please wait a moment.')));

        RateLimiter::for('api', fn (Request $request) => Limit::perMinute(60)
            ->by($request->user()?->id ?: $request->ip()));
    }
}
