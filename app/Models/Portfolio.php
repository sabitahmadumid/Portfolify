<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Portfolio extends Model
{
    /** @use HasFactory<\Database\Factories\PortfolioFactory> */
    use HasFactory, Sluggable;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'client',
        'project_url',
        'github_url',
        'technologies',
        'featured_image_id',
        'gallery_images',
        'project_date',
        'is_featured',
        'is_published',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'technologies' => 'array',
            'gallery_images' => 'array',
            'meta_keywords' => 'array',
            'project_date' => 'date',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function featuredImage(): BelongsTo
    {
        return $this->belongsTo(\Awcodes\Curator\Models\Media::class, 'featured_image_id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
