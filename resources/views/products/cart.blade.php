@extends('layouts.app')

@section('title', 'Cart - EINEVA Marketplace | EINEVA Labs')
@section('description', 'Your selected items from EINEVA Marketplace store')
@section('robots')
  <meta name="robots" content="noindex, nofollow">
@endsection

@section('content')
<style>
    .cart-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 3rem 1.5rem;
    }
    .cart-item {
        display: grid;
        grid-template-columns: 120px 1fr auto;
        gap: 1.5rem;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid var(--color-border);
        margin-bottom: 1rem;
    }
    @media (max-width: 575px) {
        .cart-item {
            grid-template-columns: 80px 1fr;
        }
        .cart-item__actions {
            grid-column: 1 / -1;
            align-items: flex-start !important;
        }
    }
    .cart-item-image {
        width: 120px;
        height: 120px;
        border-radius: var(--radius-sm);
        object-fit: contain;
        background: var(--color-bg-sunken);
    }
    .cart-item-details h3 {
        font-family: var(--font-heading);
        font-size: 1rem;
        margin-bottom: 0.25rem;
    }
    .cart-item-details p {
        font-size: 0.85rem;
        color: var(--color-text-dim);
        margin: 0;
    }
    .cart-item-price {
        font-family: var(--font-mono);
        font-weight: 700;
        white-space: nowrap;
    }
    .cart-summary {
        background: var(--color-bg-card);
        padding: 2rem;
        border-radius: var(--radius-md);
        margin-top: 3rem;
    }
    .cart-summary h2 {
        font-family: var(--font-heading);
        margin-bottom: 1rem;
    }
    .cart-summary p {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
        font-size: 1rem;
    }
    .cart-summary-total {
        font-size: 1.25rem;
        font-weight: 700;
        border-top: 1px solid var(--color-border);
        padding-top: 1rem;
        margin-top: 1rem;
    }
    .cart-empty {
        text-align: center;
        color: var(--color-text-dim);
        padding: 3rem;
    }
    .cart-empty svg {
        color: var(--color-icon);
    }
</style>

<div class="cart-container">
    @if($items->isEmpty())
        <div class="cart-empty">
            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="display: block; margin: 0 auto 1rem;" aria-hidden="true">
                <circle cx="9" cy="21" r="1"></circle>
                <circle cx="20" cy="21" r="1"></circle>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg>
            <p>Your cart is empty.</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary" style="margin-top: 1rem;">Continue Shopping</a>
        </div>
    @else
        <h1 class="page-title" style="margin-bottom: 2rem;">Your Cart</h1>

        <div>
            @foreach($items as $line)
                @php $product = $line['product']; @endphp
                <div class="cart-item">
                    <img src="{{ $product->image_url ?? asset('assets/logo/einevalabs.png') }}" alt="" class="cart-item-image" loading="lazy" width="120" height="120">
                    <div class="cart-item-details">
                        <h3>
                            <a href="{{ route('products.show', $product->slug) }}" style="color: inherit; text-decoration: none;">{{ $product->name }}</a>
                        </h3>
                        <p>{{ $product->category }}</p>
                        <p style="margin-top: 0.5rem; font-family: var(--font-mono); font-size: 0.9rem;">
                            ${{ $product->formatted_price }} each &times; {{ $line['quantity'] }}
                        </p>
                    </div>
                    <div class="cart-item__actions" style="display: flex; flex-direction: column; align-items: flex-end; gap: 1rem;">
                        <span class="cart-item-price">${{ number_format($line['line_total'], 2) }}</span>
                        <form action="{{ route('products.removeFromCart', $product->slug) }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" style="background: none; border: none; color: var(--color-red, #ef4444); cursor: pointer; display: flex; align-items: center; font-size: 0.85rem;" aria-label="Remove {{ $product->name }} from cart" title="Remove">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 0.25rem;" aria-hidden="true"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                Remove
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="cart-summary">
            <h2>Order Summary</h2>
            <p style="font-family: var(--font-mono);">Items: {{ $items->sum('quantity') }}</p>
            <p style="font-family: var(--font-mono);">Subtotal: ${{ number_format($total, 2) }}</p>
            <p class="cart-summary-total">Total: ${{ number_format($total, 2) }}</p>

            <div style="display: flex; flex-direction: column; gap: 1rem; margin-top: 1.5rem;">
                {{--
                    Checkout creates a real order and spends a gateway reference
                    number, so it is a POST behind CSRF protection. It used to be
                    a link to a GET, which a link prefetcher could fire on its
                    own and start a payment nobody asked for.
                --}}
                <form action="{{ route('checkout') }}" method="POST">
                    @csrf
                    <div class="field" style="margin-bottom: 1rem;">
                        <label for="customer_email" style="display: block; font-size: 0.85rem; color: var(--color-text-dim); margin-bottom: 0.35rem;">Email for your receipt</label>
                        <input type="email" id="customer_email" name="customer_email" value="{{ old('customer_email', auth()->user()?->email) }}" placeholder="you@example.com" required
                               style="width: 100%; border: 1px solid var(--color-border); padding: 0.6rem 1rem; border-radius: var(--radius-sm); background: var(--color-bg); color: inherit; font-family: inherit; font-size: 0.95rem;">
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%; text-align: center;">Proceed to Checkout</button>
                </form>
                <a href="{{ route('products.index') }}" class="btn" style="text-align: center; border: 1px solid var(--color-border); background: transparent;">Continue Shopping</a>
            </div>
        </div>
    @endif
</div>
@endsection
