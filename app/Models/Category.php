<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory, Sluggable;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
        'icon',
        'featured_image_id',
        'is_active',
        'meta_title',
        'meta_description',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function publishedPosts(): HasMany
    {
        return $this->hasMany(Post::class)
            ->published()
            ->orderBy('published_at', 'desc');
    }

    public function publishedPostsWithRelations(): HasMany
    {
        return $this->publishedPosts()
            ->with(['user:id,name'])
            ->select(['id', 'title', 'slug', 'excerpt', 'user_id', 'category_id', 'featured_image_id', 'published_at', 'views_count']);
    }

    public function getPostsCountAttribute(): int
    {
        return cache()->remember(
            "category_{$this->id}_posts_count",
            1800, // 30 minutes
            fn () => $this->publishedPosts()->count()
        );
    }

    public function featuredImage(): BelongsTo
    {
        return $this->belongsTo(\Awcodes\Curator\Models\Media::class, 'featured_image_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
