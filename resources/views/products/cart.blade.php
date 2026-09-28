@extends('layouts.app')

@section('title', 'Cart - The Bench | EINEVA Labs')
@section('description', 'Your selected items from The Bench store')

@section('content')
<style>
    .cart-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 3rem 1.5rem;
    }
    .cart-item {
        display: grid;
        grid-template-columns: 120px 1fr 100px;
        gap: 1.5rem;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid var(--color-border);
        margin-bottom: 1rem;
    }
    .cart-item-image {
        width: 120px;
        height: 120px;
        border-radius: var(--radius-sm);
        object-fit: cover;
        background: var(--color-bg-sunken);
    }
    .cart-item-details h4 {
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
    }
    .cart-summary {
        background: var(--color-bg-card);
        padding: 2rem;
        border-radius: var(--radius-md);
        margin-top: 3rem;
    }
    .cart-summary h3 {
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
</style>

<div class="cart-container">
    @if(empty($cart))
        <div style="text-align: center; color: var(--color-text-dim); padding: 3rem;">
            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="display: block; margin: 0 auto 1rem;">
                <circle cx="9" cy="21" r="1"></circle>
                <circle cx="20" cy="21" r="1"></circle>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg>
            <p>Your cart is empty</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary" style="margin-top: 1rem;">Continue Shopping</a>
        </div>
    @else
        <div style="margin-bottom: 2rem;">
            @foreach($cart as $item)
                <div class="cart-item">
                    <img src="{{ $item['image_url'] ?? asset('assets/logo/einevalabs.png') }}" alt="{{ $item['name'] }}" class="cart-item-image">
                    <div class="cart-item-details">
                        <h4>{{ $item['name'] }}</h4>
                        <p>#{{ $item['slug'] }}</p>
                        <p style="margin-top: 0.5rem; font-family: var(--font-mono); font-size: 0.9rem;">Qty: {{ $item['quantity'] }}</p>
                    </div>
                    <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 1rem;">
                        <span class="cart-item-price">${{ number_format($item['price'], 2) }}</span>
                        <form action="{{ route('products.removeFromCart', $item['slug']) }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" style="background: none; border: none; color: var(--color-red, #ef4444); cursor: pointer; display: flex; align-items: center; font-size: 0.85rem;" aria-label="Remove item" title="Remove">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 0.25rem;"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                Remove
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="cart-summary">
            <h3>Order Summary</h3>
            @php
                $totalItems = 0;
                $total = 0;
                foreach($cart as $item) {
                    $totalItems += $item['quantity'];
                    $total += $item['price'] * $item['quantity'];
                }
            @endphp
            <p style="font-family: var(--font-mono);">Items: {{ $totalItems }}</p>
            <p style="font-family: var(--font-mono);">Subtotal: ${{ number_format($total, 2) }}</p>
            <p class="cart-summary-total">Total: ${{ number_format($total, 2) }}</p>
            <div style="display: flex; flex-direction: column; gap: 1rem; margin-top: 1.5rem;">
                <a href="{{ route('checkout') }}" class="btn btn-primary" style="text-align: center;">Proceed to Checkout</a>
                <a href="{{ route('products.index') }}" class="btn" style="text-align: center; border: 1px solid var(--color-border); background: transparent;">Continue Shopping</a>
            </div>
        </div>
    @endif
</div>
@endsection