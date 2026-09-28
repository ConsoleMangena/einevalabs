<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Product::orderBy('category')->get()->groupBy('category');

        return view('products.index', compact('categories'));
    }

    public function category($category)
    {
        $products = Product::where('category', $category)->latest()->get();
        if ($products->isEmpty()) {
            abort(404);
        }

        return view('products.category', compact('products', 'category'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        return view('products.show', compact('product'));
    }

    public function addToCart(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        $cart = Session::get('cart', []);

        if (isset($cart[$slug])) {
            $cart[$slug]['quantity']++;
        } else {
            $cart[$slug] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'slug' => $slug,
            ];
        }

        Session::put('cart', $cart);

        return redirect()->back()->with('success', 'Added ' . $product->name . ' to cart.');
    }

    public function cart()
    {
        $cart = Session::get('cart', []);

        return view('products.cart', compact('cart'));
    }

    public function removeFromCart(Request $request, $slug)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$slug])) {
            unset($cart[$slug]);
            Session::put('cart', $cart);
        }

        return redirect()->route('products.cart')->with('success', 'Removed from cart.');
    }

    public function checkout()
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('products.cart')->with('error', 'Your cart is empty.');
        }

        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $integrationKey = config('services.pesepay.integration_key');
        $encryptionKey = config('services.pesepay.encryption_key');

        try {
            require_once __DIR__ . '/PesepayMock.php';
            
            $pesepay = new \Codevirtus\Payments\Pesepay($integrationKey, $encryptionKey);
            $pesepay->resultUrl = route('checkout.webhook');
            $pesepay->returnUrl = route('checkout.success');

            $merchantRef = "ORDER-" . time();
            $transaction = new \Codevirtus\Payments\Transaction($total, 'USD', 'EINEVA Labs Store Checkout', $merchantRef);

            $response = $pesepay->initiateTransaction($transaction);

            if ($response instanceof \Codevirtus\Payments\ErrorResponse) {
                return redirect()->route('products.cart')->with('error', 'Payment gateway error: ' . $response->message());
            }

            if ($response->success() && $response->redirectUrl()) {
                Session::put('pending_order', $cart);
                Session::put('pending_order_total', $total);
                Session::forget('cart');
                return redirect()->away($response->redirectUrl());
            }

            return redirect()->route('products.cart')->with('error', 'Payment initiation failed.');
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error("Pesepay Checkout Error: " . $e->getMessage());
            return redirect()->route('products.cart')->with('error', 'Payment service unavailable.');
        }
    }

    public function checkoutSuccess(Request $request)
    {
        $total = Session::get('pending_order_total', 0);
        Session::forget('pending_order');
        Session::forget('pending_order_total');
        
        return view('products.checkout', compact('total'));
    }

    public function checkoutWebhook(Request $request)
    {
        return response()->json(['status' => 'ok']);
    }
}
