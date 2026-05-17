<?php

namespace Hexatex\LaravelSlug\Slug\Builders;

use Hexatex\LaravelSlug\Slug\Contracts\Slug;

interface BuilderFactory
{
    public function create(array $fill, Slug $slug): Builder;
}
