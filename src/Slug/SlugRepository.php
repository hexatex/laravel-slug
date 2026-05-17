<?php

namespace Hexatex\LaravelSlug\Slug;

use Hexatex\LaravelSlug\Slug\Builders\BuilderFactory;
use Hexatex\LaravelSlug\Slug\Contracts\Slug;
use Hexatex\LaravelSlug\Slug\Slug as ConcreteSlug;
use Hexatex\LaravelSlug\Slug\Contracts\SlugRepository as SlugRepositoryContract;
use Hexatex\LaravelSlug\Slug\Contracts\Sluggable;

class SlugRepository implements SlugRepositoryContract
{
    protected $builderFactory;

    public function __construct(BuilderFactory $builderFactory)
    {
        $this->builderFactory = $builderFactory;
    }

    public function store(array $fill, Sluggable $sluggable): Slug
    {
        $slug = $this->create();
        $builder = $this->builderFactory->create($fill, $slug);
        $builder->forStore($sluggable);
        $slug->save();

        return $slug;
    }

    public function update(array $fill, Slug $slug): void
    {
        $builder = $this->builderFactory->create($fill, $slug);
        $builder->forUpdate();
        $slug->save();
    }

    public function destroy(Slug $slug): void
    {
        $slug->delete();
    }

    public function slugExists(string $slug): bool
    {
        return $this->create()->bySlug($slug)->exists();
    }

    /*
     * Protected Methods
     */
    protected function getModel(): string
    {
        return ConcreteSlug::class;
    }

    protected function create(): Slug
    {
        return new ($this->getModel());
    }
}
