<?php

namespace Hexatex\LaravelSlug\Slug\Contracts;

use Hexatex\LaravelMisc\Contracts\Model;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $slug
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * Scopes
 * @method static Builder|Slug bySlug(string $slug)
 * @method static Builder|Slug byType(string $sluggableType)
 * 
 * Relationships
 * @property-read Sluggable $sluggable
 */
interface Slug extends Model
{
    /* Scopes */
    public function scopeBySlug(Builder $query, string $slug): void;
    public function scopeByType(Builder $query, string $sluggableType): void;

    /* Relationships */
    public function sluggable(): Builder;
}
