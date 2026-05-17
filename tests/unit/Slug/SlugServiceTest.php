<?php

namespace Hexatex\LaravelSlug\Tests\Unit\Slug;

use Hexatex\LaravelSlug\Factories\SlugFactory;
use Hexatex\LaravelSlug\Slug\Contracts\Slug;
use Hexatex\LaravelSlug\Slug\Contracts\SlugRepository;
use Hexatex\LaravelSlug\Slug\Contracts\Sluggable;
use Hexatex\LaravelSlug\Slug\SlugService;
use Hexatex\LaravelSlug\Tests\TestCase;
use Hexatex\LaravelSlug\Tests\TestObjects\TestSluggable;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use \Mockery;

class SlugServiceTest extends TestCase
{
    protected $slugRepository;
    protected $slugService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->slugRepository = $this->mock(SlugRepository::class);

        $this->slugService = new SlugService($this->slugRepository);
    }

    public function testStore(bool $nullSlug = false)
    {
        // Arrange
        $slug = $this->mockSlug();
        $originalFill = [
            'slug' => $nullSlug ? null : 'test slug',
        ];
        $fill = $originalFill;
        $expectedSlug = $nullSlug ? 'test-value' : 'test-slug';

        $fill['slug'] = $expectedSlug . '-2';

        $sluggable = Mockery::mock(Sluggable::class);

        // Act
        if ($nullSlug) {
            $sluggable
                ->shouldReceive('getDefaultSlug')
                ->once()
                ->andReturn('test value');
        }

        $this->slugRepository
            ->shouldReceive('slugExists')
            ->once()
            ->with($expectedSlug)
            ->andReturn(true);

        $this->slugRepository
            ->shouldReceive('slugExists')
            ->once()
            ->with($expectedSlug . '-1')
            ->andReturn(true);

        $this->slugRepository
            ->shouldReceive('slugExists')
            ->once()
            ->with($expectedSlug . '-2')
            ->andReturn(false);

        $this->slugRepository
            ->shouldReceive('store')
            ->once()
            ->with($fill, $sluggable);

        $result = $this->slugService->store($originalFill, $sluggable);

        // Assert
        $this->assertInstanceOf(Slug::class, $result);
    }

    public function testStore_nullSlug()
    {
        $this->testStore(nullSlug: true);
    }

    public function testUpdate()
    {
        // Arrange
        $slug = $this->mockSlug();
        $originalFill = [
            'slug' => 'test slug',
        ];
        $fill = $originalFill;
        $fill['slug'] = 'test-slug-2';

        // Act
        $this->slugRepository
            ->shouldReceive('slugExists')
            ->once()
            ->with('test-slug')
            ->andReturn(true);

        $this->slugRepository
            ->shouldReceive('slugExists')
            ->once()
            ->with('test-slug-1')
            ->andReturn(true);

        $this->slugRepository
            ->shouldReceive('slugExists')
            ->once()
            ->with('test-slug-2')
            ->andReturn(false);

        $this->slugRepository
            ->shouldReceive('update')
            ->once()
            ->with($fill, $slug);

        $this->slugService->update($originalFill, $slug);

        // Assert
        $this->addToAssertionCount(1);
    }

    public function testDestroy()
    {
        // Arrange
        $slug = $this->mockSlug();

        $this->slugRepository
            ->shouldReceive('destroy')
            ->once()
            ->with($slug);

        // Act
        $this->slugService->destroy($slug);

        // Assert
        $this->addToAssertionCount(1);
    }

    protected function mockSlug()
    {
        $slug = SlugFactory::new()->make();

        $sluggable = new TestSluggable;
        $slug->setRelation('sluggable', $sluggable);

        return Mockery::mock($slug);
    }
}
