<?php

namespace Hexatex\LaravelSlug\Slug\Contracts;

use Hexatex\LaravelMisc\Contracts\Model;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * @property int $id
 *
 * Read Only
 * @property string $default_slug_attribute
 *
 * Relationships
 * @property-read Slug|null $slug
 */
interface Sluggable extends Model
{
    /* Public Methods */
    /**
     * Get the default slug when none is provided during creation.
     *
     * @return string The default slug value.
     */
    public function getDefaultSlug(): string;

    /* Relationships */
    public function slug(): Builder;
}
