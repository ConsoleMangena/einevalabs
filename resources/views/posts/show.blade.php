@extends('layouts.app')

@section('content')
<style>
    .article-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 5rem 2rem;
        font-family: var(--font-body);
    }
    .back-link {
        display: inline-flex;
        align-items: center;
        color: #64748b;
        text-decoration: none;
        font-weight: 500;
        margin-bottom: 3rem;
        transition: color 0.2s;
    }
    .back-link:hover {
        color: #0f172a;
    }
    .back-link svg {
        width: 20px;
        height: 20px;
        margin-right: 8px;
    }
    .article-header {
        margin-bottom: 4rem;
        text-align: center;
    }
.article-image {
        width: 100%;
        border-radius: 16px;
        margin-bottom: 2rem;
        object-fit: cover;
        height: 400px;
        background: var(--color-bg-card, #f1f5f9);
    }
    .article-title {
        font-size: 3.5rem;
        font-weight: 800;
        color: inherit;
        line-height: 1.2;
        margin-bottom: 1.5rem;
    }
    .article-content {
        font-size: 1.125rem;
        color: inherit;
        opacity: 0.9;
        line-height: 1.8;
    }
    .article-content p {
        margin-bottom: 1.5rem;
    }
    .article-content h2 {
        font-size: 2rem;
        color: inherit;
        margin-top: 3rem;
        margin-bottom: 1.5rem;
        font-weight: 700;
    }
    .article-content h3 {
        font-size: 1.5rem;
        color: inherit;
        margin-top: 2.5rem;
        margin-bottom: 1rem;
        font-weight: 700;
    }
    .article-content h4 {
        font-size: 1.25rem;
        color: inherit;
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-weight: 600;
    }
    .article-content ul, .article-content ol {
        margin-bottom: 1.5rem;
        padding-left: 1.5rem;
    }
    .article-content li {
        margin-bottom: 0.5rem;
    }
    .article-content code {
        background: var(--color-bg-card, #f1f5f9);
        padding: 0.2rem 0.4rem;
        border-radius: 4px;
        font-size: 0.9em;
        font-family: 'Courier New', monospace;
    }
    .article-content pre {
        background: var(--color-bg-card, #0f172a);
        color: #e2e8f0;
        padding: 1.5rem;
        border-radius: 8px;
        overflow-x: auto;
        margin-bottom: 1.5rem;
    }
    .article-content pre code {
        background: none;
        padding: 0;
        color: inherit;
    }
    .article-content blockquote {
        border-left: 4px solid #3b82f6;
        padding-left: 1.5rem;
        margin: 2rem 0;
        font-style: italic;
        color: var(--color-text-dim, #64748b);
    }
    .article-content strong {
        font-weight: 700;
    }
    .article-content a {
        color: #3b82f6;
        text-decoration: underline;
    }
    .article-content a:hover {
        color: #2563eb;
    }
    .article-content hr {
        border: none;
        border-top: 1px solid var(--color-border, #e2e8f0);
        margin: 2rem 0;
    }
</style>

<div class="article-container">
    <a href="{{ route('posts.index') }}" class="back-link">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Back to Blog
    </a>
    
    <header class="article-header">
        @if($post->image)
            <img src="{{ $post->image }}" alt="{{ $post->title }}" class="article-image">
        @endif
        <span class="article-date">{{ $post->created_at->format('F d, Y') }}</span>
        <h1 class="article-title">{{ $post->title }}</h1>
    </header>

    <div class="article-content">
        {!! $post->content !!}
    </div>
</div>
@endsection
