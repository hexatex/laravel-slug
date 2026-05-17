<?php

namespace Hexatex\LaravelSlug\Slug\Contracts;

interface SlugRepository
{
    public function store(array $fill, Sluggable $sluggable): Slug;
    public function update(array $fill, Slug $slug): void;
    public function destroy(Slug $slug): void;
    public function slugExists(string $slug): bool;
}
