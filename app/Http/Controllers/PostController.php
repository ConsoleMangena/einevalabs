<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\ExternalLink\ExternalLinkExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\MarkdownConverter;

class PostController extends Controller
{
    private MarkdownConverter $markdown;

    public function __construct()
    {
        $environment = new Environment([
            /*
             * Post bodies are authored in the admin panel and rendered with
             * {!! !!}, so the parser is the security boundary. 'escape'
             * neutralises any raw tag - a stray "<" in a code sample becomes
             * visible text rather than disappearing, and neither setting can
             * emit an executable element.
             */
            'html_input' => 'escape',
            'allow_unsafe_links' => false,

            // Bounds the work a single post can force the parser to do.
            'max_nesting_level' => 25,
        ]);

        $environment->addExtension(new CommonMarkCoreExtension);
        $environment->addExtension(new GithubFlavoredMarkdownExtension);
        $environment->addExtension(new ExternalLinkExtension([
            'open_in_new_window' => true,
            'nofollow' => true,
            'noopener' => true,
        ]));

        $this->markdown = new MarkdownConverter($environment);
    }

    public function index(): View
    {
        // Scoped to published posts: an admin draft is a draft, not a page.
        $posts = Post::query()
            ->published()
            ->latest('published_at')
            ->paginate(10)
            ->withQueryString();

        return view('posts.index', compact('posts'));
    }

    public function show(Post $post): View
    {
        abort_unless($post->isPublished(), 404);

        // Admin content arrives with literal "\n" from some editors; undo that
        // before handing it to the markdown parser.
        $source = str_replace(['\\n', "\r\n"], "\n", (string) $post->content);

        $post->content = $this->markdown->convert($source)->getContent();

        return view('posts.show', compact('post'));
    }
}
