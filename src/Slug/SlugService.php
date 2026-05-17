<?php

namespace Hexatex\LaravelSlug\Slug;

use Hexatex\LaravelService\Service;
use Hexatex\LaravelSlug\Slug\Contracts\Slug;
use Hexatex\LaravelSlug\Slug\Contracts\SlugRepository;
use Hexatex\LaravelSlug\Slug\Contracts\SlugService as SlugServiceContract;
use Hexatex\LaravelSlug\Slug\Contracts\Sluggable;
use \Str;

class SlugService extends Service implements SlugServiceContract
{
    public function __construct(SlugRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(array $fill, Sluggable $sluggable): Slug
    {
        $fill['slug'] = $this->uniqueSlug($fill, $sluggable);

        return $this->repository->store($fill, $sluggable);
    }

    public function update(array $fill, Slug $slug): void
    {
        $fill['slug'] = $this->uniqueSlug($fill, $slug->sluggable);

        $this->repository->update($fill, $slug);
    }

    public function destroy(Slug $slug): void
    {
        $this->repository->destroy($slug);
    }

    /*
     * Protected Methods
     */
    protected function uniqueSlug(array $fill, Sluggable $sluggable): string
    {
        $slug = Str::slug($fill['slug'] ?? $sluggable->getDefaultSlug() ?? 'slug');

        $append = '';
        for ($i = 1; $this->repository->slugExists($slug . $append); $i++) {
            $append = '-' . $i;
        }

        return $slug . $append;
    }
}
