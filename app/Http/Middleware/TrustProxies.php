<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Middleware\TrustProxies as BaseTrustProxies;
use Illuminate\Http\Request;

/**
 * Configures trusted proxies from config() at request time.
 *
 * The framework's own TrustProxies is configured from bootstrap/app.php, but
 * that file runs before the config repository is bound, so it can only use
 * env() - and env() returns null once `php artisan config:cache` has been run
 * and the .env file is no longer loaded. The result is that proxy trust and
 * the https scheme are silently dropped on exactly the cached production
 * deployment that needs them: url() emits http:// links and the payment
 * gateway is handed an http:// result URL it will refuse to redirect back to.
 *
 * Reading the value here, inside handle(), keeps it working both with and
 * without a cached config.
 */
class TrustProxies extends BaseTrustProxies
{
    /**
     * Deliberately narrower than the framework default: X-Forwarded-Prefix is
     * not forwarded by the cPanel setup this app targets, and trusting a
     * header nobody sets only widens the surface for header spoofing.
     */
    protected $headers = Request::HEADER_X_FORWARDED_FOR
        | Request::HEADER_X_FORWARDED_HOST
        | Request::HEADER_X_FORWARDED_PORT
        | Request::HEADER_X_FORWARDED_PROTO
        | Request::HEADER_X_FORWARDED_AWS_ELB;

    public function handle(Request $request, Closure $next)
    {
        /*
         * '*' is the correct default for a single-tenant cPanel host. Pin
         * TRUSTED_PROXIES in .env to the proxy's address if the site is ever
         * placed behind an intermediary that is not under your control:
         * trusting every hop lets a client spoof X-Forwarded-For and defeat
         * the IP-keyed rate limiters on contact, newsletter and checkout.
         */
        $this->proxies = config('app.trusted_proxies') ?: '*';

        return parent::handle($request, $next);
    }
}
