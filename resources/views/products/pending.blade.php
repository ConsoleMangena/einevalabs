@extends('layouts.app')

@section('title', ($failed ?? false ? 'Payment not completed' : 'Confirming your payment') . ' - EINEVA Marketplace | EINEVA Labs')
@section('description', $failed ?? false ? 'The payment provider reported that the payment was not completed.' : 'We are confirming your payment with the provider.')
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
{{--
    Shown when the customer comes back from the gateway but the order has not
    been confirmed. This is the honest state: the payment provider has not told
    us it settled, so we do not claim it did. The webhook will settle the order
    automatically, and the order reference is given so the customer can quote
    it if they need to.
--}}
<div class="checkout-container">
    <div style="text-align: center; padding: 3.5rem 2rem; background: var(--color-bg-card); border-radius: var(--radius-lg); border: 1px solid var(--color-border);">
        <div style="width: 72px; height: 72px; border: 2px solid {{ ($failed ?? false) ? 'var(--color-red)' : 'var(--color-text-dim)' }}; color: {{ ($failed ?? false) ? 'var(--color-red)' : 'var(--color-text-dim)' }}; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
            @if($failed ?? false)
                <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="12" r="9"></circle>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                </svg>
            @else
                <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="12" r="9"></circle>
                    <polyline points="12 7 12 12 15 14"></polyline>
                </svg>
            @endif
        </div>

        <h1 style="margin-bottom: 0.5rem; font-size: 1.75rem; font-family: var(--font-heading);">
            {{ ($failed ?? false) ? 'Payment not completed' : 'Confirming your payment' }}
        </h1>

        @if($failed ?? false)
            <p style="color: var(--color-text-dim); margin-bottom: 1.5rem; line-height: 1.6;">
                The payment provider reported that this payment was not completed, so nothing has been charged.
                You can try again, or get in touch if the money has left your account and we have not seen it.
            </p>
        @else
            <p style="color: var(--color-text-dim); margin-bottom: 1.5rem; line-height: 1.6;">
                Your bank or mobile-money provider is still confirming this payment. This page updates automatically
                once it settles, and we will email a receipt to
                <strong>{{ $order->customer_email ?: 'the address you supplied' }}</strong>.
            </p>

            <p style="color: var(--color-text-dim); font-size: 0.85rem; margin-bottom: 2rem;">
                Nothing has been lost. If the payment did go through it will be applied to this order automatically.
            </p>
        @endif

        <p style="font-family: var(--font-mono); font-size: 0.8rem; color: var(--color-text-muted); margin-bottom: 2rem;">
            Order {{ $order->ulid }}
            @if($referenceNumber)
                <br>Payment reference {{ $referenceNumber }}
            @endif
        </p>

        <div style="display: flex; flex-direction: column; gap: 0.75rem; max-width: 320px; margin: 0 auto;">
            @unless($failed ?? false)
                <a href="{{ route('checkout.return') }}" class="btn btn-primary" data-no-loader>Check again</a>
            @endunless
            <a href="{{ ($failed ?? false) ? route('products.cart') : route('products.index') }}" class="btn" style="border: 1px solid var(--color-border); background: transparent;" data-no-loader>
                {{ ($failed ?? false) ? 'Back to your cart' : 'Back to the store' }}
            </a>
        </div>

        <p style="margin-top: 2rem; font-size: 0.8rem; color: var(--color-text-muted);">
            Still not resolved after a few minutes?
            <a href="{{ route('contact') }}" style="color: var(--color-red);">Contact us</a> and quote the order reference above.
        </p>
    </div>
</div>
@endsection
