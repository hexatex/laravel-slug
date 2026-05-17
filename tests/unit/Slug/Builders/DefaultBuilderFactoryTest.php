<?php

namespace Hexatex\LaravelSlug\Tests\Unit\Slug\Builders;

use Hexatex\LaravelSlug\Slug\Builders\DefaultBuilder;
use Hexatex\LaravelSlug\Slug\Builders\DefaultBuilderFactory;
use Hexatex\LaravelSlug\Factories\SlugFactory;
use Hexatex\LaravelSlug\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DefaultBuilderFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function testCreate()
    {
        // Arrange
        $fill = SlugFactory::new()->make()->toArray();
        $slug = SlugFactory::new()->make();

        $builderFactory = new DefaultBuilderFactory();

        // Act
        $resizer = $builderFactory->create($fill, $slug);

        // Assert
        $this->assertInstanceOf(DefaultBuilder::class, $resizer);
    }
}
