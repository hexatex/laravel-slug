<?php

namespace Hexatex\LaravelSlug\Slug;

use Hexatex\LaravelMisc\Model;
use Hexatex\LaravelSlug\Slug\Contracts\Slug as SlugContract;
use Illuminate\Contracts\Database\Query\Builder;

class Slug extends Model implements SlugContract
{
    protected $fillable = [
        'slug',
    ];

    /*
     * Scopes
     */
    public function scopeBySlug(Builder $query, string $slug): void
    {
        $query->where('slug', $slug);
    }

    public function scopeByType(Builder $query, string $sluggableType): void
    {
        $query->where('sluggable_type', $sluggableType);
    }

    /*
     * Relationships
     */
    public function sluggable(): Builder
    {
        return $this->morphTo();
    }
}
