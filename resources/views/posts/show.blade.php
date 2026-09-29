@extends('layouts.app')

@section('title', ($post->title ?? 'Post') . ' - EINEVA Labs')
@section('description', \Illuminate\Support\Str::limit($post->excerpt ?? strip_tags($post->content), 150))
@section('og_title', $post->title)
@section('og_description', \Illuminate\Support\Str::limit($post->excerpt ?? strip_tags($post->content), 200))
@if($post->image_url)
@section('og_image', $post->image_url)
@section('og_image_type', 'image/jpeg')
@endif

@section('content')
<style>
    /* Theme variables throughout: this page previously hardcoded light-mode
       hex colours and was unreadable in the dark theme. */
    .article-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 5rem 2rem;
    }
    .back-link {
        display: inline-flex;
        align-items: center;
        color: var(--color-text-muted);
        text-decoration: none;
        font-weight: 500;
        margin-bottom: 3rem;
        transition: color 0.2s;
    }
    .back-link:hover {
        color: var(--color-heading);
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
        border-radius: var(--radius-md, 16px);
        margin-bottom: 2rem;
        object-fit: cover;
        height: 400px;
        background: var(--color-bg-card);
    }
    .article-title {
        font-size: 3rem;
        font-weight: 800;
        color: var(--color-heading);
        line-height: 1.2;
        margin-bottom: 1.5rem;
    }
    @media (max-width: 575px) {
        .article-title { font-size: 2rem; }
        .article-container { padding: 2.5rem 1.25rem; }
    }
    .article-date {
        display: block;
        font-size: 0.85rem;
        color: var(--color-text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 1.25rem;
    }
    .article-content {
        font-size: 1.0625rem;
        color: var(--color-text);
        line-height: 1.8;
    }
    .article-content p { margin-bottom: 1.5rem; }
    .article-content h2 {
        font-size: 2rem;
        color: var(--color-heading);
        margin-top: 3rem;
        margin-bottom: 1.5rem;
        font-weight: 700;
    }
    .article-content h3 {
        font-size: 1.5rem;
        color: var(--color-heading);
        margin-top: 2.5rem;
        margin-bottom: 1rem;
        font-weight: 700;
    }
    .article-content h4 {
        font-size: 1.25rem;
        color: var(--color-heading);
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-weight: 600;
    }
    .article-content ul, .article-content ol {
        margin-bottom: 1.5rem;
        padding-left: 1.5rem;
    }
    .article-content li { margin-bottom: 0.5rem; }
    .article-content a {
        color: var(--color-red);
        text-decoration: underline;
    }
    /* Code blocks keep a dark surface in both themes: they are code, and a
       light block with syntax text is not what a reader expects. */
    .article-content code {
        background: var(--color-bg-sunken);
        padding: 0.2rem 0.4rem;
        border-radius: 4px;
        font-size: 0.9em;
        font-family: var(--font-mono);
    }
    .article-content pre {
        background: #0f172a;
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
        border-left: 4px solid var(--color-red);
        padding-left: 1.5rem;
        margin: 2rem 0;
        font-style: italic;
        color: var(--color-text-dim);
    }
    .article-content table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 1.5rem;
    }
    .article-content th, .article-content td {
        border: 1px solid var(--color-border);
        padding: 0.75rem 1rem;
        text-align: left;
    }
    .article-content th {
        background: var(--color-bg-sunken);
        color: var(--color-heading);
    }
    .article-content hr {
        border: none;
        border-top: 1px solid var(--color-border);
        margin: 2rem 0;
    }
    .article-content img {
        max-width: 100%;
        border-radius: var(--radius-sm);
    }
</style>

<div class="article-container">
    <a href="{{ route('posts.index') }}" class="back-link">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Back to Blog
    </a>

    <article>
        <header class="article-header">
            @if($post->image_url)
                <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="article-image">
            @endif
            <time class="article-date" datetime="{{ $post->published_at->toIso8601String() }}">
                {{ $post->published_at->format('F d, Y') }}
            </time>
            <h1 class="article-title">{{ $post->title }}</h1>
        </header>

        {{--
            Rendered unescaped because it is the output of the CommonMark
            converter, which runs with html_input=escape and
            allow_unsafe_links=false, so no raw tag or javascript: URL can
            reach this string. The parser is the security boundary here.
        --}}
        <div class="article-content">
            {!! $post->content !!}
        </div>
    </article>
</div>
@endsection
