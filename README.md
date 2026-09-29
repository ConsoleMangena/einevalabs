# EINEVA Labs

Marketing site, blog and storefront for EINEVA Labs, with a Filament admin panel
and a pesePay-integrated checkout.

- **Framework:** Laravel 13.33
- **Admin panel:** Filament 3.3 (`/admin`)
- **PHP:** 8.3
- **Frontend:** pre-built static assets in `public/assets` — no bundler step

## Requirements

- PHP 8.3+ with `curl`, `openssl`, `mbstring`, `pdo_mysql`, `gd`
- MySQL 8 (or MariaDB 10.6+)
- Composer 2
- A pesePay sandbox account for checkout, and a Web3Forms access key for
  contact/newsletter notifications

## Local setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

Frontend assets are committed to `public/assets`, so there is no `npm run build`
step. Edit the CSS in `public/assets/styles.css` directly.

Run the test suite and the formatter:

```bash
php artisan test          # full suite
vendor/bin/pint           # format
vendor/bin/pint --test    # check only, non-zero exit on violations
```

Tests run against an in-memory SQLite database and never contact pesePay,
Web3Forms or Google — the gateway is substituted with `tests/Feature/FakePesepay.php`.

## Creating the first admin

The seeder creates an administrator from `ADMIN_EMAIL` / `ADMIN_NAME` /
`ADMIN_PASSWORD`. It is idempotent: an existing admin is never re-created and
its password is never reset, so re-running the seeder is safe.

```bash
php artisan db:seed
```

After the first login, change the password and set `ADMIN_PASSWORD=` (or remove
it) so the plaintext value is not left sitting in `.env`. Non-admins are refused
at the panel gate, not just hidden from the UI.

To promote an existing user:

```bash
php artisan tinker
>>> App\Models\User::where('email', 'you@example.com')->update(['is_admin' => true]);
```

## Configuration

Everything is driven by `.env`; see `.env.example` for the annotated list. The
settings that are easy to get wrong:

| Variable | Notes |
| --- | --- |
| `APP_ENV=production` | Also set `APP_DEBUG=false` before going live. |
| `APP_URL` | Must be the real HTTPS origin. Used to build the gateway return/webhook URLs. |
| `APP_FORCE_HTTPS` | Redirects to HTTPS. Leave on behind a proxy. |
| `TRUSTED_PROXIES` | `*` behind Cloudflare/cPanel proxy, or comma-separated proxy IPs. Getting this wrong breaks `Request::ip()`, which the form rate limiters key on. |
| `QUEUE_CONNECTION=database` | Contact and newsletter notifications are queued; a worker is required. |
| `SESSION_DRIVER=database` | |
| `SESSION_ENCRYPT=true` | Cookie contents are encrypted; the queue worker and web process must share `APP_KEY`. |
| `PESEPAY_*` | Integration/encryption keys, sandbox flag, currency, and the merchant reference shown to the customer. |
| `WEB3FORMS_ACCESS_KEY` | Left empty, notifications are logged and skipped instead of failing the form. |
| `ADMIN_*` | Only read by the seeder. |

## Payments

The rule the checkout is built around: **an order is only marked paid from a
verified gateway response.** A session, a query string, or the fact that a
browser reached the return URL is never sufficient.

- `POST /checkout` reprices the basket from the database, writes a `pending`
  order, and redirects to the hosted gateway.
- `GET /checkout/return` polls the gateway before rendering anything. A verified
  success shows the receipt; anything still in flight shows a "we are waiting on
  your bank" page and keeps the reference so a refresh still works.
- `POST /checkout/webhook` is the gateway callback (CSRF-exempt). It looks the
  order up by reference and re-verifies it, so an unauthenticated caller cannot
  settle an order by posting to the URL.
- `PENDING` and unknown statuses leave the order pending. Only an explicit
  `FAILED` is treated as terminal. A gateway outage is never recorded as "the
  customer did not pay".
- Item name, quantity and unit price are snapshotted onto the order at checkout
  and are never re-read from the catalogue afterwards, so later price edits
  cannot rewrite a historical receipt.

An order that is still pending after 24 hours is marked failed by
`orders:abandon-stale`.

### Reconciling payments

If a settlement is missed, **Admin → Orders → Reconcile pending** re-checks
pending orders oldest-first. The action is time-boxed to about 20 seconds and
chunked, so it cannot exceed PHP's `max_execution_time`; run it repeatedly until
the notification reports no remaining orders.

## Background work

Two things must run on a schedule or they silently never happen:

```bash
php artisan schedule:run          # every minute, via cron
php artisan queue:work            # long-running, for queued notifications
```

The schedule runs:

- `orders:abandon-stale --hours=24`, hourly
- `PruneOldContactSubmissions(days: 180)`, daily at 03:10

## Deploying to cPanel

1. Upload the repository and run `composer install --no-dev --optimize-autoloader`.
2. Copy `.env.example` to `.env` and fill it in. Set `APP_ENV=production`,
   `APP_DEBUG=false`, the real `APP_URL`, and the database credentials cPanel
   issued.
3. Point the domain's document root at `public/`. The project root must not be
   web-accessible.
4. Run the deploy commands:

   ```bash
   php artisan migrate --force
   php artisan db:seed
   php artisan storage:link
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

   `storage:link` is required: product and post images are served from
   `storage/app/public`. Without it every image 404s.
5. Add cron entries in cPanel, one line each:

   ```
   * * * * * /usr/local/bin/php /home/USER/domain/artisan schedule:run >> /dev/null 2>&1
   ```

   The queue needs a persistent process. Either supervise
   `php artisan queue:work` with a process manager, or use a cPanel queue
   daemon if one is available — the contact and newsletter forms depend on it.
6. Re-run `config:cache` after **any** `.env` change. With a cached config, `.env`
   edits are ignored.

## Operational notes

- **Never edit `paid_at` by hand.** The webhook and the return page can both
  fire for the same payment; `markPaid()` is idempotent precisely so the
  settlement timestamp does not drift on every reload.
- Rotating `APP_KEY` invalidates sessions and encrypted cookies, and breaks any
  queued job serialized with the old key. Drain the queue first.
- `.env` and any Web3Forms/pesePay credentials are not in version control.
  Secrets that were previously committed should still be rotated in their
  provider dashboards; removing them from the working tree does not remove them
  from git history.
