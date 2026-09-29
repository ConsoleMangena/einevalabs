@extends('layouts.app')

@section('title', 'Order confirmed - The Bench | EINEVA Labs')
@section('description', 'Your order has been received and payment confirmed.')
@section('robots')
  <meta name="robots" content="noindex, nofollow">
@endsection

@section('content')
<style>
    .checkout-container {
        max-width: 600px;
        margin: 0 auto;
        padding: 3rem 1.5rem;
    }
</style>

<div class="checkout-container">
    <div class="success-card" style="text-align: center; padding: 4rem 2rem; background: var(--color-bg-card); border-radius: var(--radius-lg); border: 1px solid var(--color-border);">
        <div class="success-icon" style="width: 80px; height: 80px; background: rgba(34, 197, 94, 0.1); border: 2px solid #22c55e; color: #22c55e; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
        </div>

        <h1 style="margin-bottom: 0.5rem; font-size: 2rem; font-family: var(--font-heading);">Payment confirmed</h1>
        <p style="color: var(--color-text-dim); margin-bottom: 2rem; font-size: 1.1rem;">
            Your payment was verified with our payment provider. Thank you.
        </p>

        <div class="checkout-total" style="display: inline-block; padding: 1rem 2rem; background: rgba(127, 127, 127, 0.06); border-radius: var(--radius-sm); border: 1px solid var(--color-border); margin: 0 auto 2rem;">
            <span style="font-size: 0.9rem; color: var(--color-text-dim); text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 0.25rem;">Total paid</span>
            <span style="font-size: 1.75rem; font-family: var(--font-mono);">{{ $order->currency }} {{ $order->formatted_total }}</span>
        </div>

        <dl style="max-width: 420px; margin: 0 auto 2rem; text-align: left; display: grid; grid-template-columns: auto 1fr; gap: 0.5rem 1rem; font-size: 0.9rem;">
            <dt style="color: var(--color-text-dim);">Order reference</dt>
            <dd style="margin: 0; font-family: var(--font-mono); word-break: break-all;">{{ $order->ulid }}</dd>

            @if($order->reference_number)
                {{-- The reference the gateway knows the payment by. This is the
                     one a customer quotes to their bank or to our support team,
                     so it belongs on the receipt. --}}
                <dt style="color: var(--color-text-dim);">Payment reference</dt>
                <dd style="margin: 0; font-family: var(--font-mono); word-break: break-all;">{{ $order->reference_number }}</dd>
            @endif

            <dt style="color: var(--color-text-dim);">Items</dt>
            <dd style="margin: 0;">
                {{--
                    Order::$items is a JSON snapshot cast to 'array', so each
                    line is an array, not a model. Property access here raised
                    "attempt to read property on array" and rendered an empty
                    list, which on a receipt looks exactly like a zero-item
                    order.
                --}}
                @foreach($order->items ?? [] as $item)
                    <div>
                        {{ (int) ($item['quantity'] ?? 0) }} &times; {{ $item['name'] ?? 'Item' }}
                        &mdash; {{ $order->currency }} {{ number_format((float) ($item['line_total'] ?? 0), 2) }}
                    </div>
                @endforeach
            </dd>
        </dl>

        <p style="color: var(--color-text-dim); line-height: 1.6; max-width: 400px; margin: 0 auto 2rem;">
            Our team will contact you within the next 24 hours regarding delivery tracking and installation details.
        </p>

        <a href="{{ route('products.index') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 0.5rem;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Return to Catalogue
        </a>
    </div>
</div>
@endsection
