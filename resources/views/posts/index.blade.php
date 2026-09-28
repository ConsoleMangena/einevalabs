@extends('layouts.app')

@section('content')
<style>
    .blog-container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 4rem 2rem;
        font-family: var(--font-body);
    }
    .blog-header {
        text-align: center;
        margin-bottom: 4rem;
    }
    .blog-title {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
        color: inherit;
    }
    .blog-subtitle {
        font-size: 1.2rem;
        color: #64748b;
    }
    .posts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2.5rem;
    }
    .post-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 10px 15px -3px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        border: 1px solid #f1f5f9;
        overflow: hidden;
        padding: 0;
    }
    .post-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.1);
    }
    .post-card-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        display: block;
    }
    .post-card-body {
        padding: 2rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .post-date {
        font-size: 0.875rem;
        color: #94a3b8;
        margin-bottom: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .post-heading {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 1rem;
        line-height: 1.3;
    }
    .post-excerpt {
        color: #475569;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        flex-grow: 1;
    }
    .read-more {
        color: #3b82f6;
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
        <p class="blog-subtitle">Discover the latest insights, stories, and news.</p>
    </div>

    <div class="posts-grid">
        @forelse($posts as $post)
            <a href="{{ route('posts.show', $post->slug) }}" class="post-card">
                <img src="{{ $post->image }}" alt="{{ $post->title }}" class="post-card-image">
                <div class="post-card-body">
                    <div class="post-date">{{ $post->created_at->format('M d, Y') }}</div>
                    <h2 class="post-heading">{{ $post->title }}</h2>
                    <p class="post-excerpt">{{ $post->excerpt ?? Str::limit($post->content, 120) }}</p>
                    <div class="read-more">
                        Read Article 
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </div>
                </div>
            </a>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; color: #64748b; padding: 4rem;">
                <h3>No posts yet. Check back soon!</h3>
            </div>
        @endforelse
    </div>
    
    <div style="margin-top: 3rem;">
        {{ $posts->links() }}
    </div>
</div>
@endsection
