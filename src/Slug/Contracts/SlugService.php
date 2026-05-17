<?php

namespace Hexatex\LaravelSlug\Slug\Contracts;

use Hexatex\LaravelService\Contracts\Service;

interface SlugService extends Service
{
    public function store(array $fill, Sluggable $sluggable): Slug;
    public function update(array $fill, Slug $slug): void;
    public function destroy(Slug $slug): void;
}
