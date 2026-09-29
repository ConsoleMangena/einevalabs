<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\TrustProxies;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\ThrottleRequests;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        /*
         | The `throttle` alias was dropped from the default middleware set in
         | Laravel 11. Named limiters registered with RateLimiter::for() are
         | still resolved by ThrottleRequests, so the alias only has to be
         | re-registered for ->middleware('throttle:contact') in routes/web.php
         | to resolve.
         */
        $middleware->alias([
            'throttle' => ThrottleRequests::class,
        ]);

        /*
         | The gateway callback is server-to-server and cannot hold a CSRF
         | token, so excluding it is correct. ValidateCsrfToken trims the
         | leading slash and matches against the decoded path, so the bare
         | "checkout/webhook" below does match POST /checkout/webhook.
         |
         | The route is public and CSRF-exempt by necessity - it is
         | authenticated instead by re-confirming every reference number with
         | check-payment before an order is marked paid.
         */
        $middleware->validateCsrfTokens(except: [
            'checkout/webhook',
        ]);

        /*
         | cPanel hosts the app behind a proxy or CDN, so the request that
         | reaches PHP reports the proxy's scheme and address. Without trusted
         | proxies, url() and route() emit http:// links and the payment
         | gateway is handed an http:// result URL it will refuse to redirect
         | back to.
         |
         | The framework's TrustProxies is swapped for a subclass that reads
         | the setting from config at request time, because this file runs
         | before the config repository is bound - env() is the only thing
         | available here, and it returns null after `php artisan config:cache`
         | has run. See App\Http\Middleware\TrustProxies and config/app.php.
         */
        $middleware->replace(
            TrustProxies::class,
            App\Http\Middleware\TrustProxies::class,
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
