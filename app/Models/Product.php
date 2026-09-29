<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'description',
        'price',
        'specs',
        'image_url',
        'images',
    ];

    protected $casts = [
        'specs' => 'array',
        'images' => 'array',
        'price' => 'decimal:2',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * A null price means "not for sale / price on request", not zero. The
     * storefront must not render a $0.00 sticker price for those.
     */
    public function isPurchasable(): bool
    {
        return $this->price !== null;
    }

    /**
     * Money is rendered through one accessor everywhere so the storefront,
     * the cart and the order records cannot drift apart on rounding.
     */
    public function getFormattedPriceAttribute(): ?string
    {
        return $this->price === null ? null : number_format((float) $this->price, 2);
    }

    /**
     * The accessor must take the raw value as its argument. Eloquent resolves
     * an accessor by calling get{StudlyKey}Attribute($rawValue); reading
     * $this->image_url inside the body instead re-enters this very method and
     * recurses until the process dies, so every product page and cart render
     * that touched an image was a fatal error.
     */
    public function getImageUrlAttribute(?string $value = null): ?string
    {
        return $this->resolveImageUrl($value);
    }

    /**
     * @return list<string>
     */
    public function getGalleryUrlsAttribute(): array
    {
        $paths = is_array($this->attributes['images'] ?? null)
            ? $this->attributes['images']
            : (is_array($this->images) ? $this->images : []);

        return array_values(array_filter(array_map(
            fn ($path) => $this->resolveImageUrl(is_string($path) ? $path : null),
            $paths
        )));
    }

    protected function resolveImageUrl(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://', '//', 'data:'])) {
            return $path;
        }

        return asset('storage/'.ltrim($path, '/'));
    }

    /**
     * @param  Builder<Product>  $query
     */
    public function scopeInCategory(Builder $query, string $category): void
    {
        $query->where('category', $category);
    }
}
