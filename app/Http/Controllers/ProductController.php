<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use App\Models\Product;
use App\Services\CheckoutService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use RuntimeException;

class ProductController extends Controller
{
    public function __construct(private readonly CheckoutService $checkout) {}

    public function index(): View
    {
        // Count in the database rather than loading every product to group it
        // in PHP; only one representative image per category is needed for the
        // preview tile.
        $categories = Product::query()
            ->select('category')
            ->selectRaw('COUNT(*) as aggregate')
            ->groupBy('category')
            ->orderBy('category')
            ->pluck('aggregate', 'category');

        return view('products.index', [
            'categories' => $categories,
            'previews' => $this->categoryPreviewImages($categories->keys()),
        ]);
    }

    public function category(string $category): View
    {
        $products = Product::query()
            ->where('category', $category)
            ->latest('id')
            ->paginate(24)
            ->withQueryString();

        if ($products->isEmpty()) {
            abort(404);
        }

        return view('products.category', compact('products', 'category'));
    }

    public function show(string $slug): View
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        return view('products.show', compact('product'));
    }

    /**
     * Add a line to the session cart.
     *
     * POST only. This used to also answer GET, which made it reachable from an
     * <img> tag or a link prefetcher without a CSRF token, and it incremented
     * the quantity with no upper bound.
     */
    public function addToCart(Request $request, string $slug): RedirectResponse
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        if (! $product->isPurchasable()) {
            return back()->with('error', $product->name.' is currently available on request only.');
        }

        $cart = $this->cartFromSession();

        $quantity = (int) ($cart[$slug]['quantity'] ?? 0) + 1;

        if ($quantity > CheckoutService::MAX_QUANTITY_PER_LINE) {
            return back()->with('error', sprintf(
                'You can order at most %d of %s.',
                CheckoutService::MAX_QUANTITY_PER_LINE,
                $product->name
            ));
        }

        // The session stores the slug and the quantity only. Name, price and
        // image are re-read from the database at render and at checkout so a
        // client cannot dictate them and a price change is picked up.
        $cart[$slug] = ['quantity' => $quantity];

        $request->session()->put('cart', $cart);

        return back()->with('success', 'Added '.$product->name.' to cart.');
    }

    public function cart(): View
    {
        $cart = $this->cartFromSession();
        $items = $this->hydrateCart($cart);

        return view('products.cart', [
            'items' => $items,
            'total' => $this->cartTotal($items),
        ]);
    }

    public function removeFromCart(Request $request, string $slug): RedirectResponse
    {
        $cart = $this->cartFromSession();
        unset($cart[$slug]);

        $request->session()->put('cart', $cart);

        return redirect()->route('products.cart')->with('success', 'Removed from cart.');
    }

    /**
     * Create the order and hand off to the gateway.
     *
     * POST only: this mutates state, spends a gateway reference number, and
     * clears the cart. As a GET it fired on link prefetch, and a double visit
     * produced two live payments against one basket.
     */
    public function checkout(CheckoutRequest $request): RedirectResponse
    {
        $cart = $this->cartFromSession();

        if ($cart === []) {
            return redirect()->route('products.cart')->with('error', 'Your cart is empty.');
        }

        try {
            $order = $this->checkout->createOrderFromCart(
                $cart,
                $request->user()?->id,
                $request->string('customer_name')->toString() ?: 'Guest',
                $request->string('customer_email')->toString(),
            );
        } catch (RuntimeException $e) {
            return redirect()->route('products.cart')->with('error', $e->getMessage());
        }

        try {
            $redirectUrl = $this->checkout->initiateGatewayPayment($order);
        } catch (RuntimeException $e) {
            // Misconfiguration, not a user error: log loudly, tell them to retry.
            Log::error('Pesepay client could not be constructed.', [
                'order_ulid' => $order->ulid,
                'error' => $e->getMessage(),
            ]);

            $order->markFailed('Payment provider is not configured.');

            return redirect()->route('products.cart')
                ->with('error', 'Payments are temporarily unavailable. Please try again shortly.');
        }

        if ($redirectUrl === null) {
            return redirect()->route('products.cart')
                ->with('error', 'We could not reach the payment provider. Your card has not been charged.');
        }

        $request->session()->put('checkout_order_ulid', $order->ulid);
        $request->session()->forget('cart');

        return redirect()->away($redirectUrl);
    }

    /**
     * Landing page after the customer returns from the gateway.
     *
     * The gateway does not tell us the outcome here, so the order is looked up
     * from the session and then verified against the gateway. Only a verified
     * settlement renders a success page; anything else is stated as such.
     */
    public function checkoutSuccess(Request $request): View|RedirectResponse
    {
        /*
         * get(), not pull(). The pending page tells the customer to hit
         * "Check again", and a browser refresh of the return URL is the
         * normal way people re-check a slow mobile-money confirmation. Pulling
         * the reference destroyed it on the first load, so every one of those
         * refreshes fell through to "we could not find a recent order" and told
         * a paying customer their order had vanished.
         */
        $ulid = $request->session()->get('checkout_order_ulid');

        if (! is_string($ulid) || $ulid === '') {
            return redirect()->route('products.cart')
                ->with('error', 'We could not find a recent order for this session.');
        }

        $order = Order::where('ulid', $ulid)->first();

        if (! $order) {
            $request->session()->forget('checkout_order_ulid');

            return redirect()->route('products.cart')
                ->with('error', 'We could not find a recent order for this session.');
        }

        try {
            $paid = $this->checkout->settle($order);
        } catch (RuntimeException $e) {
            Log::error('Pesepay client could not be constructed on return.', [
                'order_ulid' => $order->ulid,
                'error' => $e->getMessage(),
            ]);

            $paid = false;
        }

        if ($paid) {
            $request->session()->forget('checkout_order_ulid');
        }

        if (! $paid && $order->isPending()) {
            /*
             * The customer may simply have been redirected before the gateway
             * finished settling. Say so rather than claiming a payment
             * succeeded, and let the webhook confirm it.
             */
            return view('products.pending', [
                'order' => $order,
                'referenceNumber' => $order->reference_number,
            ]);
        }

        if (! $paid) {
            // The gateway gave a terminal rejection. Do not render the success
            // page for it, and do not keep inviting the customer to re-check.
            $request->session()->forget('checkout_order_ulid');

            return view('products.pending', [
                'order' => $order,
                'referenceNumber' => $order->reference_number,
                'failed' => true,
            ]);
        }

        return view('products.checkout', [
            'order' => $order,
            'total' => (float) $order->total,
        ]);
    }

    /**
     * Gateway callback. pesePay POSTs an encrypted result here; the payload is
     * confirmed with check-payment before an order is marked paid, so an
     * unauthenticated caller cannot settle an order by posting to this URL.
     */
    public function checkoutWebhook(Request $request): JsonResponse
    {
        $reference = $request->input('referenceNumber')
            ?? $request->header('x-pesepay-reference-number');

        if (! is_string($reference) || $reference === '') {
            // Fall back to settling anything still pending for this session is
            // not possible here - webhooks are server-to-server. Accept the
            // ping so the gateway stops retrying, but record nothing.
            Log::warning('Pesepay webhook received without a reference number.');

            return response()->json(['status' => 'ignored']);
        }

        $order = Order::where('reference_number', $reference)->first();

        if (! $order) {
            Log::warning('Pesepay webhook for an unknown reference number.', [
                'reference_number' => $reference,
            ]);

            return response()->json(['status' => 'unknown_reference']);
        }

        try {
            $this->checkout->settle($order);
        } catch (RuntimeException $e) {
            Log::error('Pesepay webhook could not be processed.', [
                'order_ulid' => $order->ulid,
                'error' => $e->getMessage(),
            ]);

            return response()->json(['status' => 'error'], 500);
        }

        return response()->json(['status' => $order->fresh()->isPaid() ? 'paid' : 'pending']);
    }

    /**
     * @return array<string, array{quantity: int}>
     */
    private function cartFromSession(): array
    {
        $cart = request()->session()->get('cart', []);

        return is_array($cart) ? $cart : [];
    }

    /**
     * Attach the live product record to each cart line.
     *
     * Lines whose product has since been deleted are dropped rather than
     * rendered from a stale session snapshot.
     *
     * @param  array<string, array{quantity: int}>  $cart
     * @return Collection<int, array{product: Product, quantity: int, line_total: float}>
     */
    private function hydrateCart(array $cart): Collection
    {
        if ($cart === []) {
            return collect();
        }

        return Product::whereIn('slug', array_keys($cart))
            ->get()
            ->map(fn (Product $product) => [
                'product' => $product,
                'quantity' => max(1, (int) ($cart[$product->slug]['quantity'] ?? 1)),
                'line_total' => round((float) $product->price * max(1, (int) ($cart[$product->slug]['quantity'] ?? 1)), 2),
            ])
            ->filter(fn (array $line) => $line['product']->isPurchasable())
            ->values();
    }

    /**
     * @param  Collection<int, array{product: Product, quantity: int, line_total: float}>  $items
     */
    private function cartTotal(Collection $items): float
    {
        return round((float) $items->sum('line_total'), 2);
    }

    /**
     * One image per category for the store landing page tiles.
     *
     * @param  Collection<int, string>  $categories
     * @return array<string, string>
     */
    private function categoryPreviewImages(Collection $categories): array
    {
        if ($categories->isEmpty()) {
            return [];
        }

        $previews = [];

        foreach (Product::whereIn('category', $categories)->get() as $product) {
            $url = $product->image_url ?? ($product->gallery_urls[0] ?? null);

            if ($url !== null && ! isset($previews[$product->category])) {
                $previews[$product->category] = $url;
            }
        }

        return $previews;
    }
}
