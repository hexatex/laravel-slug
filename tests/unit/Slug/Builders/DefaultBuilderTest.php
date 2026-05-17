<?php

namespace Hexatex\LaravelSlug\Tests\Unit\Slug\Builders;

use Hexatex\LaravelMisc\Eloquent\Relations\MorphTo;
use Hexatex\LaravelSlug\Slug\Builders\DefaultBuilder;
use Hexatex\LaravelSlug\Slug\Contracts\Sluggable;
use Hexatex\LaravelSlug\Slug\Contracts\Slug;
use Hexatex\LaravelSlug\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use \Mockery;

class DefaultBuilderTest extends TestCase
{
    use RefreshDatabase;

    public function testForStore()
    {
        $fill = [];
        $slug = Mockery::mock(Slug::class);
        $builder = new DefaultBuilder($fill, $slug);
        $sluggable = Mockery::mock(Sluggable::class);
        $sluggableMorphTo = Mockery::mock(MorphTo::class);

        $slug
            ->shouldReceive('fill')
            ->with($fill)
            ->once();

        $slug
            ->shouldReceive('sluggable')
            ->once()
            ->andReturn($sluggableMorphTo);

        $sluggableMorphTo
            ->shouldReceive('associate')
            ->with($sluggable)
            ->once();

        $builder->forStore($sluggable);

        $this->addToAssertionCount(1);
    }

    public function testForUpdate()
    {
        $fill = [];
        $slug = Mockery::mock(Slug::class);
        $builder = new DefaultBuilder($fill, $slug);

        $slug
            ->shouldReceive('fill')
            ->with($fill)
            ->once();

        $builder->forUpdate();

        $this->addToAssertionCount(1);
    }
}
