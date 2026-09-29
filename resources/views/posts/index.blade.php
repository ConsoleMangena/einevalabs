@extends('layouts.app')

@section('title', 'Blog - EINEVA Labs')
@section('description', 'Cybersecurity research, threat intelligence and security engineering writing from EINEVA Labs.')

@section('content')
<style>
    /* Every colour below is a theme variable. The previous version hardcoded
       light-mode hex values (#ffffff cards, #0f172a headings), so the blog was
       the one part of the site that ignored the light/dark toggle. */
    .blog-container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 4rem 2rem;
    }
    .blog-header {
        text-align: center;
        margin-bottom: 4rem;
    }
    .blog-title {
        font-size: 3rem;
        font-weight: 800;
        color: var(--color-heading);
        margin-bottom: 1rem;
    }
    @media (max-width: 575px) {
        .blog-title { font-size: 2.25rem; }
        .blog-container { padding: 2.5rem 1.25rem; }
    }
    .blog-subtitle {
        font-size: 1.1rem;
        color: var(--color-text-dim);
    }
    .posts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2.5rem;
    }
    .post-card {
        background: var(--color-bg-card);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-md, 16px);
        box-shadow: var(--shadow-card);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        text-decoration: none;
        color: var(--color-text);
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    .post-card:hover,
    .post-card:focus-visible {
        transform: translateY(-6px);
        border-color: var(--color-border-hover);
    }
    .post-card-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        display: block;
    }
    .post-card-image--placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--color-bg-sunken);
        color: var(--color-text-muted);
    }
    .post-card-body {
        padding: 2rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .post-date {
        font-size: 0.85rem;
        color: var(--color-text-muted);
        margin-bottom: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .post-heading {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--color-heading);
        margin-bottom: 1rem;
        line-height: 1.3;
    }
    .post-excerpt {
        color: var(--color-text-dim);
        line-height: 1.6;
        margin-bottom: 1.5rem;
        flex-grow: 1;
    }
    .read-more {
        color: var(--color-red);
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        margin-top: auto;
    }
    .read-more svg {
        width: 16px;
        height: 16px;
        margin-left: 4px;
        transition: transform 0.2s;
    }
    .post-card:hover .read-more svg {
        transform: translateX(4px);
    }
</style>

<div class="blog-container">
    <div class="blog-header">
        <h1 class="blog-title">Our Blog</h1>
        <p class="blog-subtitle">Cybersecurity research, threat intelligence and field notes.</p>
    </div>

    <div class="posts-grid">
        @forelse($posts as $post)
            <a href="{{ route('posts.show', $post->slug) }}" class="post-card">
                @if($post->image_url)
                    <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="post-card-image" loading="lazy">
                @else
                    {{-- A null cover rendered a broken <img> with alt text showing. --}}
                    <div class="post-card-image post-card-image--placeholder" aria-hidden="true">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                    </div>
                @endif
                <div class="post-card-body">
                    <p class="post-date">
                        <time datetime="{{ $post->published_at->toIso8601String() }}">{{ $post->published_at->format('M d, Y') }}</time>
                    </p>
                    <h2 class="post-heading">{{ $post->title }}</h2>
                    <p class="post-excerpt">{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 140) }}</p>
                    <span class="read-more">
                        Read Article
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </span>
                </div>
            </a>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; color: var(--color-text-dim); padding: 4rem; border: 1px dashed var(--color-border); border-radius: var(--radius-md);">
                <h3 style="color: var(--color-heading);">No posts published yet.</h3>
                <p>Check back soon for our latest research.</p>
            </div>
        @endforelse
    </div>

    @if($posts->hasPages())
        <div class="mt-5 d-flex justify-content-center">{{ $posts->links() }}</div>
    @endif
</div>
@endsection
