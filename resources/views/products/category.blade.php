@extends('layouts.app')

@section('title', $category . ' - The Bench | EINEVA Labs')
@section('description', 'Browse ' . $category . ' at The Bench, the EINEVA Labs equipment store.')

@section('content')
<style>
    .store-hero {
        text-align: center;
        padding: 3rem 1rem;
        background: linear-gradient(180deg, rgba(239, 68, 68, 0.05) 0%, transparent 100%);
        border-radius: var(--radius-lg);
        margin-bottom: 3rem;
        border: 1px solid var(--color-border);
    }
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 2rem;
    }
    .product-card {
        background: var(--color-bg-card);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-md);
        overflow: hidden;
        transition: transform var(--dur) var(--ease), box-shadow var(--dur) var(--ease);
        display: flex;
        flex-direction: column;
        text-decoration: none;
    }
    .product-card:hover,
    .product-card:focus-visible {
        transform: translateY(-4px);
        box-shadow: var(--shadow-card);
        border-color: var(--color-border-hover);
    }
    .product-image {
        height: 240px;
        background: var(--color-bg-sunken);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }
    .product-image img {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
        filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.3));
    }
    .product-image .no-image {
        font-family: var(--font-mono);
        color: var(--color-text-muted);
        font-size: 0.85rem;
    }
    .product-content {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        flex: 1;
    }
    .product-category {
        font-family: var(--font-heading);
        font-size: 0.75rem;
        text-transform: uppercase;
        color: var(--color-red);
        letter-spacing: 0.05em;
        margin-bottom: 0.5rem;
    }
    .product-title {
        font-family: var(--font-heading);
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: var(--color-heading);
    }
    .product-price {
        font-family: var(--font-mono);
        font-size: 1.1rem;
        color: var(--color-text);
        margin-bottom: 1rem;
    }
    .product-price--request {
        color: var(--color-text-dim);
        font-size: 0.95rem;
        font-style: italic;
    }
    .product-footer {
        margin-top: auto;
        padding-top: 1rem;
        border-top: 1px solid var(--color-border);
    }
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--color-text-muted);
        text-decoration: none;
        margin-bottom: 2rem;
        transition: color var(--dur) var(--ease);
    }
    .back-link:hover {
        color: var(--color-red);
    }
</style>

<a href="{{ route('products.index') }}" class="back-link">&larr; Back to The Bench</a>

<div class="store-hero">
    <h1 class="page-title">{{ $category }}</h1>
    <p class="page-sub">
        Showing {{ $products->total() }} {{ Str::plural('item', $products->total()) }} in this category.
    </p>
</div>

<div class="product-grid">
    @forelse($products as $product)
        <a href="{{ route('products.show', $product->slug) }}" class="product-card">
            <div class="product-image">
                @if($product->image_url)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy">
                @else
                    <span class="no-image">No image available</span>
                @endif
            </div>
            <div class="product-content">
                <p class="product-category">{{ $product->category }}</p>
                <h2 class="product-title">{{ $product->name }}</h2>

                @if($product->isPurchasable())
                    <p class="product-price">${{ $product->formatted_price }}</p>
                @else
                    {{-- A null price means "on request", not free. --}}
                    <p class="product-price product-price--request">Price on request</p>
                @endif

                <div class="product-footer">
                    <span class="btn btn-secondary" style="width: 100%;">View Details</span>
                </div>
            </div>
        </a>
    @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 4rem; background: var(--color-bg-card); border-radius: var(--radius-md); border: 1px dashed var(--color-border);">
            <p style="color: var(--color-text-dim); font-family: var(--font-mono);">Nothing in {{ $category }} yet.</p>
        </div>
    @endforelse
</div>

@if($products->hasPages())
    <div class="mt-5">{{ $products->links() }}</div>
@endif
@endsection
