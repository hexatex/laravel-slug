<?php

namespace Hexatex\LaravelSlug\Slug\Builders;

use Hexatex\LaravelSlug\Slug\Contracts\Slug;

class DefaultBuilderFactory implements BuilderFactory
{
    public function create(array $fill, Slug $slug): Builder
    {
        return new DefaultBuilder($fill, $slug);
    }
}
