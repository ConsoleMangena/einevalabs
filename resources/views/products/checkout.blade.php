@extends('layouts.app')

@section('title', 'Checkout - The Bench | EINEVA Labs')
@section('description', 'Checkout page for your order')

@section('content')
<style>
    .checkout-container {
        max-width: 600px;
        margin: 0 auto;
        padding: 3rem 1.5rem;
    }
    .checkout-card {
        background: var(--color-bg-card);
        padding: 2rem;
        border-radius: var(--radius-md);
        margin-bottom: 1rem;
    }
    .checkout-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--color-border);
    }
    .checkout-total {
        font-family: var(--font-mono);
        font-size: 1.25rem;
        font-weight: 700;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid var(--color-border);
    }
</style>

<div class="checkout-container">
    <h2 class="mb-4">Order Summary</h2>
    
    @if(isset($total) && $total > 0)
        
        <div class="checkout-card">
            <p class="checkout-total" style="border: none; padding: 0; margin: 0;">Total Paid: ${{ number_format($total, 2) }}</p>
        </div>
        
        <p style="margin-top: 2rem; color: var(--color-text-dim);">
            Thank you for your order! Your payment was successful via Pesepay. We will contact you within 24 hours regarding shipping details.
        </p>
    @else
        <div style="text-align: center; color: var(--color-text-dim); padding: 3rem;">
            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="display: block; margin: 0 auto 1rem;">
                <circle cx="9" cy="21" r="1"></circle>
                <circle cx="20" cy="21" r="1"></circle>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg>
            <p>Your cart is empty</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary" style="margin-top: 1rem;">Continue Shopping</a>
        </div>
    @endif
</div>
@endsection