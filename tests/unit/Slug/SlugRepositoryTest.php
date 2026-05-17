<?php

namespace Hexatex\LaravelSlug\Tests\Unit\Slug;

use Hexatex\LaravelSlug\Factories\SlugFactory;
use Hexatex\LaravelSlug\Slug\Builders\BuilderFactory;
use Hexatex\LaravelSlug\Slug\Contracts\Slug;
use Hexatex\LaravelSlug\Slug\Slug as ConcreteSlug;
use Hexatex\LaravelSlug\Slug\Contracts\Sluggable;
use Hexatex\LaravelSlug\Slug\SlugRepository;
use Hexatex\LaravelSlug\Tests\TestCase;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator as ConcreteLengthAwarePaginator;
use Illuminate\Support\Collection;
use \Mockery;

class SlugRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $slugRepository;
    protected $builderFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->builderFactory = $this->mock(BuilderFactory::class);
        $this->slugRepository = $this->getMockBuilder(SlugRepository::class)
            ->onlyMethods(['getModel', 'create'])
            ->setConstructorArgs([$this->builderFactory])
            ->getMock();
    }

    public function testStore()
    {
        // Arrange
        $fill = $this->slugFill();
        $slug = $this->mockSlug();
        $builder = $this->mockSlugBuilder();
        $sluggable = Mockery::mock(Sluggable::class);

        // Act
        $this->slugRepository
            ->expects($this->once())
            ->method('create')
            ->willReturn($slug);

        $this->builderFactory
            ->shouldReceive('create')
            ->once()
            ->with($fill, $slug)
            ->andReturn($builder);

        $builder
            ->shouldReceive('forStore')
            ->once()
            ->with($sluggable);

        $slug
            ->shouldReceive('save')
            ->once()
            ->with();

        $result = $this->slugRepository->store($fill, $sluggable);

        // Assert
        $this->assertInstanceOf(Slug::class, $result);
        $this->assertEquals($slug, $result);
    }

    public function testUpdate()
    {
        // Arrange
        $fill = $this->slugFill();
        $slug = $this->mockSlug();
        $builder = $this->mockSlugBuilder();

        // Act
        $this->builderFactory
            ->shouldReceive('create')
            ->once()
            ->with($fill, $slug)
            ->andReturn($builder);

        $builder
            ->shouldReceive('forUpdate')
            ->once()
            ->with();

        $slug
            ->shouldReceive('save')
            ->once()
            ->andReturnNull();

        $this->slugRepository->update($fill, $slug);

        // Assert
        $this->addToAssertionCount(1);
    }

    public function testDestroy()
    {
        // Arrange
        $slug = $this->mockSlug();

        // Act
        $slug
            ->shouldReceive('delete')
            ->once();

        $result = $this->slugRepository->destroy($slug);

        // Assert
        $this->assertNull($result);
    }

    public function testGetModel()
    {
        // Arrange
        $repository = new SlugRepository($this->builderFactory);
        $method = $this->getInaccessibleMethod($repository, 'getModel');

        // Act
        $result = $method->invoke($repository);

        // Assert
        $this->assertEquals(ConcreteSlug::class, $result);
    }

    public function testCreate()
    {
        // Arrange
        $repository = $this->getMockBuilder(SlugRepository::class)
            ->onlyMethods(['getModel'])
            ->setConstructorArgs([$this->builderFactory])
            ->getMock();

        $method = $this->getInaccessibleMethod($repository, 'create');

        // Act
        $repository
            ->expects($this->once())
            ->method('getModel')
            ->willReturn(ConcreteSlug::class);

        $result = $method->invoke($repository);

        // Assert
        $this->assertInstanceOf(Slug::class, $result);
    }

    /*
     * Protected Methods
     */
    protected function mockSlug()
    {
        return $this->mock(Slug::class);
    }

    protected function mockSlugBuilder()
    {
        return $this->mock(\Hexatex\LaravelSlug\Slug\Builders\Builder::class);
    }

    protected function slugFill()
    {
        return SlugFactory::new()->make()->toArray();
    }
}
