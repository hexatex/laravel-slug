<?php

namespace Hexatex\LaravelSlug\Tests\TestObjects;

use Hexatex\LaravelMisc\Model;
use Hexatex\LaravelSlug\Slug\Contracts\Sluggable;
use Hexatex\LaravelSlug\Slug\Slug;
use Illuminate\Contracts\Database\Query\Builder;

class TestSluggable extends Model implements Sluggable
{
    /*
     * Sluggable
     */
    public function getDefaultSlug(): string
    {
        $this->test_attribute = 'test value';

        return $this->test_attribute;
    }

    public function slug(): Builder
    {
        return $this->morphOne(Slug::class, 'sluggable');
    }
}
