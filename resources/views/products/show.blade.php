@extends('layouts.app')

@section('title', $product->name . ' - The Bench | EINEVA Labs')
@section('description', \Illuminate\Support\Str::limit($product->description, 150))

@php
    if (!is_array($product->specs)) $product->specs = [];
    if (!is_array($product->images)) $product->images = [];
@endphp

@section('content')
<style>
    .product-detail {
        padding: 2rem 0;
    }
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: start;
    }
    @media (max-width: 991px) {
        .detail-grid {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
    }
    .detail-image {
        background: var(--color-bg-sunken);
        border-radius: var(--radius-lg);
        border: 1px solid var(--color-border);
        padding: 3rem;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 400px;
    }
    .detail-image img {
        max-width: 100%;
        max-height: 500px;
        filter: drop-shadow(0 15px 30px rgba(0,0,0,0.4));
    }
    .detail-image.placeholder {
        font-family: var(--font-mono);
        color: var(--color-text-muted);
        font-size: 1rem;
    }
    .detail-info h1 {
        font-family: var(--font-heading);
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
    }
    .detail-category {
        font-family: var(--font-heading);
        font-size: 0.85rem;
        color: var(--color-red);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 1rem;
        display: block;
    }
    .detail-price {
        font-family: var(--font-mono);
        font-size: 2rem;
        color: var(--color-text);
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .detail-desc {
        color: var(--color-text-dim);
        font-size: 1.1rem;
        line-height: 1.7;
        margin-bottom: 2.5rem;
    }
    .specs-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 2.5rem;
    }
    .specs-table th, .specs-table td {
        padding: 1rem 0;
        border-bottom: 1px solid var(--color-border);
        text-align: left;
    }
    .specs-table th {
        color: var(--color-text-muted);
        font-weight: 500;
        width: 30%;
    }
    .specs-table td {
        font-family: var(--font-mono);
        color: var(--color-text);
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

<div class="product-detail">
    <a href="{{ route('products.index') }}" class="back-link">&larr; Back to The Bench</a>

    <div class="detail-grid">
        <div class="detail-gallery">
            <div class="detail-image {{ !$product->image_url && empty($product->images) ? 'placeholder' : '' }}">
                @if($product->image_url || !empty($product->images))
                    @php $mainImage = $product->image_url ?? $product->images[0]; @endphp
                    <img src="{{ $mainImage }}" alt="{{ $product->name }}" id="mainImage">
                @else
                    [ IMAGE RENDERING... ]
                @endif
            </div>

            @if(!empty($product->images) || ($product->image_url && !empty($product->images)))
            <div class="thumbnail-row" style="display: flex; gap: 1rem; margin-top: 1.5rem; flex-wrap: wrap;">
                @if($product->image_url)
                    <div class="thumbnail active" onclick="document.getElementById('mainImage').src='{{ $product->image_url }}'" style="width: 80px; height: 80px; border: 1px solid var(--color-red); border-radius: var(--radius-sm); cursor: pointer; background: var(--color-bg-sunken); display: flex; align-items: center; justify-content: center; padding: 0.5rem; transition: border-color var(--dur) var(--ease);">
                        <img src="{{ $product->image_url }}" style="max-width: 100%; max-height: 100%;">
                    </div>
                @endif
                @if(!empty($product->images))
                    @foreach($product->images as $img)
                        <div class="thumbnail {{ (!$product->image_url && $loop->first) ? 'active' : '' }}" onclick="document.getElementById('mainImage').src='{{ $img }}'" style="width: 80px; height: 80px; border: 1px solid {{ (!$product->image_url && $loop->first) ? 'var(--color-red)' : 'var(--color-border)' }}; border-radius: var(--radius-sm); cursor: pointer; background: var(--color-bg-sunken); display: flex; align-items: center; justify-content: center; padding: 0.5rem; transition: border-color var(--dur) var(--ease);">
                            <img src="{{ $img }}" style="max-width: 100%; max-height: 100%;">
                        </div>
                    @endforeach
                @endif
            </div>
            <script>
                document.querySelectorAll('.thumbnail').forEach(t => {
                    t.addEventListener('click', function() {
                        document.querySelectorAll('.thumbnail').forEach(th => th.style.borderColor = 'var(--color-border)');
                        this.style.borderColor = 'var(--color-red)';
                    });
                });
            </script>
            @endif
        </div>

        <div class="detail-info">
            <span class="detail-category">{{ $product->category }}</span>
            <h1>{{ $product->name }}</h1>
            <div class="detail-price">${{ number_format($product->price, 2) }}</div>

            <div class="detail-desc">
                {{ $product->description }}
            </div>

            @if(is_array($product->specs) && count($product->specs) > 0)
                <h3 style="font-family: var(--font-heading); margin-bottom: 1rem; font-size: 1.25rem;">Technical Specifications</h3>
                <table class="specs-table">
                    <tbody>
                        @foreach($product->specs as $key => $value)
                            <tr>
                                <th>{{ $key }}</th>
                                <td>{{ $value }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <div style="display: flex; gap: 1rem; align-items: center;">
                <form action="{{ route('products.addToCart', $product->slug) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="flex: 1;">Add to Cart</button>
                </form>
                <a href="{{ route('contact') }}?subject=Inquiry about {{ urlencode($product->name) }}" class="btn btn-outline" style="flex: 1;">Request a Quote</a>
            </div>
            <p style="margin-top: 1rem; font-size: 0.85rem; color: var(--color-text-muted); font-family: var(--font-mono);">* Availability and final pricing subject to stock. We will contact you within 24h.</p>
        </div>
    </div>
</div>
@endsection
