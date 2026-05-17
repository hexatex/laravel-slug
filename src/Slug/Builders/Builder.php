<?php

namespace Hexatex\LaravelSlug\Slug\Builders;

use Hexatex\LaravelSlug\Slug\Contracts\Slug;
use Hexatex\LaravelSlug\Slug\Contracts\Sluggable;

interface Builder
{
    public function __construct(array $fill, Slug $model);
    public function forStore(Sluggable $sluggable): void;
    public function forUpdate(): void;
}
