<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'content', 'excerpt', 'image', 'published_at'];

    /**
     * `published_at` is a real datetime rather than a boolean so posts can be
     * scheduled and so the public index can order by it directly.
     */
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    /**
     * Only posts that are published *and* whose publish time has passed are
     * visible to the public. Without this an admin draft leaks to the blog
     * the moment it is saved.
     *
     * @param  Builder<Post>  $query
     */
    public function scopePublished(Builder $query): void
    {
        $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    public function isPublished(): bool
    {
        return $this->published_at !== null && $this->published_at->lessThanOrEqualTo(now());
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Post images are uploaded through Filament onto the `public` disk, which
     * stores a path relative to that disk ("blog/abc.jpg"). Rendering the raw
     * attribute as an <img src> produces "/blog/abc.jpg" and a 404, so every
     * URL is resolved through the disk here instead of in the view.
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->resolveImageUrl($this->image);
    }

    protected function resolveImageUrl(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        // Already absolute - an externally hosted image pasted into the admin.
        if (Str::startsWith($path, ['http://', 'https://', '//', 'data:'])) {
            return $path;
        }

        return asset('storage/'.ltrim($path, '/'));
    }
}
