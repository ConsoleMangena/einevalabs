@extends('layouts.app')

@section('title', $product->name . ' - EINEVA Marketplace | EINEVA Labs')
@section('description', \Illuminate\Support\Str::limit($product->description, 150))

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
        filter: drop-shadow(0 15px 30px rgba(0, 0, 0, 0.4));
    }
    .detail-image .no-image {
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
    }
    .detail-price--request {
        font-size: 1.25rem;
        color: var(--color-text-dim);
        font-style: italic;
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

    /* Thumbnails are real <button>s so they are focusable and operable with
       the keyboard; a click-only <div> was not. */
    .thumbnail-row {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
        flex-wrap: wrap;
    }
    .thumbnail {
        width: 80px;
        height: 80px;
        border: 1px solid var(--color-border);
        border-radius: var(--radius-sm);
        cursor: pointer;
        background: var(--color-bg-sunken);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem;
        transition: border-color var(--dur) var(--ease);
    }
    .thumbnail img {
        max-width: 100%;
        max-height: 100%;
    }
    .thumbnail[aria-current="true"] {
        border-color: var(--color-red);
    }
    .thumbnail:focus-visible {
        outline: 2px solid var(--color-red);
        outline-offset: 2px;
    }
</style>

@php
    $gallery = array_values(array_filter(array_merge(
        $product->image_url ? [$product->image_url] : [],
        $product->gallery_urls
    )));
@endphp

<div class="product-detail">
    <a href="{{ route('products.index') }}" class="back-link">&larr; Back to EINEVA Marketplace</a>

    <div class="detail-grid">
        <div class="detail-gallery">
            <div class="detail-image">
                @if($gallery)
                    <img src="{{ $gallery[0] }}" alt="{{ $product->name }}" id="mainImage">
                @else
                    <span class="no-image">No image available</span>
                @endif
            </div>

            @if(count($gallery) > 1)
                <div class="thumbnail-row" role="group" aria-label="Product images">
                    @foreach($gallery as $index => $image)
                        {{--
                            The URL travels in a data- attribute and is read by
                            the script below. It used to be interpolated straight
                            into an onclick="...src='{{ $img }}'" string, which
                            puts an admin-supplied value inside a JavaScript
                            literal. Blade's escaping is correct for an HTML
                            attribute value, so reading it back off the dataset
                            keeps the URL out of any script context.
                        --}}
                        <button type="button"
                                class="thumbnail"
                                data-gallery-image="{{ $image }}"
                                data-gallery-alt="{{ $product->name }}"
                                aria-current="{{ $index === 0 ? 'true' : 'false' }}">
                            <img src="{{ $image }}" alt="" loading="lazy">
                        </button>
                    @endforeach
                </div>

                <script>
                    (function () {
                        var main = document.getElementById('mainImage');
                        var thumbs = document.querySelectorAll('.thumbnail[data-gallery-image]');
                        if (!main || !thumbs.length) return;

                        thumbs.forEach(function (thumb) {
                            thumb.addEventListener('click', function () {
                                main.src = thumb.dataset.galleryImage;
                                main.alt = thumb.dataset.galleryAlt;

                                thumbs.forEach(function (other) {
                                    other.setAttribute('aria-current', 'false');
                                });
                                thumb.setAttribute('aria-current', 'true');
                            });
                        });
                    })();
                </script>
            @endif
        </div>

        <div class="detail-info">
            <span class="detail-category">{{ $product->category }}</span>
            <h1>{{ $product->name }}</h1>

            @if($product->isPurchasable())
                <p class="detail-price">${{ $product->formatted_price }}</p>
            @else
                <p class="detail-price detail-price--request">Price on request</p>
            @endif

            <div class="detail-desc">{!! $product->description !!}</div>

            @if(is_array($product->specs) && count($product->specs) > 0)
                <h2 style="font-family: var(--font-heading); margin-bottom: 1rem; font-size: 1.25rem;">Technical Specifications</h2>
                <table class="specs-table">
                    <caption class="sr-only">Technical specifications for {{ $product->name }}</caption>
                    <tbody>
                        @foreach($product->specs as $key => $value)
                            <tr>
                                <th scope="row">{{ $key }}</th>
                                <td>{{ is_scalar($value) ? $value : json_encode($value) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
                @if($product->isPurchasable())
                    <form action="{{ route('products.addToCart', $product->slug) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                    </form>
                @else
                    {{-- No price means no cart: the button would create an order that cannot be priced. --}}
                    <p style="font-size: 0.9rem; color: var(--color-text-dim);">
                        This item is available on request.
                    </p>
                @endif

                <a href="{{ route('contact') }}?subject={{ rawurlencode('Inquiry about '.$product->name) }}" class="btn btn-outline">
                    Request a Quote
                </a>
            </div>

            <p style="margin-top: 1rem; font-size: 0.85rem; color: var(--color-text-muted); font-family: var(--font-mono);">
                * Availability and final pricing subject to stock. We will contact you within 24h.
            </p>
        </div>
    </div>
</div>
@endsection
