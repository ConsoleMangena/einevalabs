@extends('layouts.app')

@section('title', 'The Bench - EINEVA Labs')
@section('description', 'Hardened workstations, secured handsets, lab prototyping hardware, and EINEVA Labs apparel and accessories for security engineers.')

@section('content')
<style>
    .store-hero {
        text-align: center;
        padding: 4rem 1rem;
        background: linear-gradient(180deg, rgba(239, 68, 68, 0.05) 0%, transparent 100%);
        border-radius: var(--radius-lg);
        margin-bottom: 3rem;
        border: 1px solid var(--color-border);
    }
    .category-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 1.5rem;
    }
    .category-card {
        flex: 1 1 240px;
        max-width: 300px;
        background: var(--color-bg-card);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-md);
        padding: 2rem 1.5rem;
        text-align: center;
        transition: transform var(--dur) var(--ease), box-shadow var(--dur) var(--ease), border-color var(--dur) var(--ease);
        text-decoration: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .category-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-card);
        border-color: var(--color-red-border);
    }
    .category-preview {
        width: 120px;
        height: 120px;
        margin-bottom: 1.5rem;
        border-radius: var(--radius-sm);
        background: var(--color-bg-sunken);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
        border: 1px solid var(--color-border-hover);
    }
    .category-preview img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        filter: drop-shadow(0 5px 15px rgba(0,0,0,0.2));
    }
    .category-name {
        font-family: var(--font-heading);
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--color-heading);
        margin-bottom: 0.5rem;
    }
    .category-count {
        font-family: var(--font-mono);
        font-size: 0.85rem;
        color: var(--color-red);
        background: var(--color-red-dim);
        padding: 0.2rem 0.6rem;
        border-radius: 4px;
    }
</style>

<div class="store-hero">
    <h1 class="page-title">The Bench</h1>
    <p class="page-sub">Gear we build on and trust in our own lab. Hardened workstations, secured handsets, prototyping hardware, and apparel for security engineers.</p>
</div>

<div class="category-grid">
    @forelse($categories as $categoryName => $products)
        @php
            $previewProduct = $products->first(fn($p) => $p->image_url || !empty($p->images));
            $previewUrl = $previewProduct ? ($previewProduct->image_url ?? $previewProduct->images[0]) : null;
        @endphp
        <a href="{{ route('products.category', $categoryName) }}" class="category-card">
            <div class="category-preview">
                @if($previewUrl)
                    <img src="{{ $previewUrl }}" alt="{{ $categoryName }}">
                @else
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--color-text-muted);"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                @endif
            </div>
            <div class="category-name">{{ $categoryName }}</div>
            @php
                $catDesc = match($categoryName) {
                    'Workstations' => 'Hardened laptops for field and lab use.',
                    'Comms' => 'Secured handsets for sensitive conversations.',
                    'Apparel & Accessories' => 'EINEVA Labs apparel, drinkware, and desk gear.',
                    'Lab Hardware' => 'Prototyping boards and network gear.',
                    default => 'Explore items in this category.'
                };
            @endphp
            <div style="font-size: 0.85rem; color: var(--color-text-dim); margin-bottom: 1rem;">{{ $catDesc }}</div>
            <div class="category-count">{{ $products->count() }} {{ Str::plural('item', $products->count()) }}</div>
        </a>
    @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 4rem; background: var(--color-bg-card); border-radius: var(--radius-md); border: 1px dashed var(--color-border);">
            <p style="color: var(--color-text-dim); font-family: var(--font-mono);">[ NO CATEGORIES FOUND ]</p>
        </div>
    @endforelse
</div>
@endsection
