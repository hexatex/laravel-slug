<?php

namespace Hexatex\LaravelSlug\Slug\Builders;

use Hexatex\LaravelMisc\Patterns\Builder as BaseBuilder;
use Hexatex\LaravelSlug\Slug\Contracts\Slug;
use Hexatex\LaravelSlug\Slug\Contracts\Sluggable;

class DefaultBuilder extends BaseBuilder implements Builder
{
    public function __construct(array $fill, Slug $model)
    {
        $this->fill = $fill;
        $this->model = $model;
    }

    public function forStore(Sluggable $sluggable): void
    {
        $this->fill();
        $this->associate('sluggable', $sluggable);
    }

    public function forUpdate(): void
    {
        $this->fill();
    }
}
