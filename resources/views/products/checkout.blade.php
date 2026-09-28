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
    @if(isset($total) && $total > 0)
        <div class="success-card" style="text-align: center; padding: 4rem 2rem; background: var(--color-bg-card); border-radius: var(--radius-lg); border: 1px solid var(--color-border); box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2); animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;">
            <div class="success-icon" style="width: 80px; height: 80px; background: rgba(34, 197, 94, 0.1); border: 2px solid #22c55e; color: #22c55e; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; box-shadow: 0 0 20px rgba(34, 197, 94, 0.2);">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </div>
            
            <h2 style="margin-bottom: 0.5rem; font-size: 2rem; background: linear-gradient(90deg, #fff, #a1a1aa); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Payment Successful</h2>
            <p style="color: var(--color-text-dim); margin-bottom: 2rem; font-size: 1.1rem;">Thank you for your purchase via Pesepay.</p>
            
            <div class="checkout-total" style="display: inline-block; padding: 1rem 2rem; background: rgba(255, 255, 255, 0.03); border-radius: var(--radius-sm); border: 1px solid var(--color-border); margin: 0 auto 2rem; border-top: 1px solid var(--color-border);">
                <span style="font-size: 0.9rem; color: var(--color-text-dim); text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 0.25rem;">Total Paid</span>
                <span style="font-size: 1.75rem; color: #fff;">${{ number_format($total, 2) }}</span>
            </div>
            
            <p style="color: var(--color-text-dim); line-height: 1.6; max-width: 400px; margin: 0 auto 2rem;">
                Your order is confirmed. Our team will contact you within the next 24 hours regarding delivery tracking and installation details.
            </p>

            <a href="{{ route('products.index') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Return to Catalogue
            </a>
        </div>
        
        <style>
            @keyframes fadeUp {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
        </style>
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