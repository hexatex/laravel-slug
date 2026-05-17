<?php

namespace Hexatex\LaravelSlug\Tests\Unit\Slug;

use Hexatex\LaravelSlug\Factories\SlugFactory;
use Hexatex\LaravelSlug\Slug\Contracts\Sluggable;
use Hexatex\LaravelSlug\Slug\Slug;
use Hexatex\LaravelSlug\SluggedItem\SluggedItem;
use Hexatex\LaravelSlug\Tests\TestCase;
use Hexatex\LaravelSlug\Tests\TestObjects\TestSluggable;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use \Mockery;

class SlugTest extends TestCase
{
    use RefreshDatabase;

    public function testSlugTableExists()
    {
        // Act & Assert
        $this->assertTrue(Schema::hasTable('slugs'));
    }

    public function testSlugTableExistsWithCorrectColumns()
    {
        // Act
        $tableColumns = Schema::getColumnListing('slugs');

        // Assert
        $expectedColumns = ['id', 'slug', 'created_at', 'updated_at', 'sluggable_type', 'sluggable_id'];
        foreach ($expectedColumns as $column) {
            $this->assertContains($column, $tableColumns);
        }
    }

    public function testFillableAttributes()
    {
        // Arrange
        $slug = new Slug();

        // Act
        $fillableAttributes = $slug->getFillable();

        // Assert
        $expectedFillable = ['slug'];
        $this->assertEquals($expectedFillable, $fillableAttributes);
    }

    public function testScopeBySlug()
    {
        // Arrange
        $slug = new Slug;
        $builder = Mockery::mock(Builder::class);

        // Act
        $builder
            ->shouldReceive('where')
            ->with('slug', 'test-slug')
            ->once();

        $slug->scopeBySlug($builder, 'test-slug');

        // Assert
        $this->addToAssertionCount(1);
    }

    public function testScopeByType()
    {
        // Arrange
        $slug = new Slug;
        $builder = Mockery::mock(Builder::class);

        // Act
        $builder
            ->shouldReceive('where')
            ->with('sluggable_type', 'test-slug-type')
            ->once();

        $slug->scopeByType($builder, 'test-slug-type');

        // Assert
        $this->addToAssertionCount(1);
    }

    public function testSluggableRelation()
    {
        // Arrange
        $slug = new Slug();

        // Act
        $relation = $slug->sluggable();

        // Assert
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\MorphTo::class, $relation);
    }

    public function testCreateSlug()
    {
        // Arrange
        $fill = [
            'slug' => 'test-slug',
        ];
        $slug = $this->makeSlug($fill);

        // Act
        $slug->save();

        // Assert
        $this->assertNotNull($slug);
        $this->assertInstanceOf(Slug::class, $slug);
        $this->assertEquals('test-slug', $slug->slug);
        $this->assertDatabaseHas('slugs', ['id' => $slug->id]);
    }

    public function testUpdateSlug()
    {
        // Arrange
        $fill =[
            'slug' => 'initial-slug',
        ];
        $slug = $this->makeSlug($fill);
        $slug->save();

        $updatedData = [
            'slug' => 'updated-slug',
        ];

        // Act
        $slug->update($updatedData);

        // Assert
        $this->assertEquals('updated-slug', $slug->fresh()->slug);
        $this->assertDatabaseHas('slugs', ['id' => $slug->id]);
    }

    public function testDeleteSlug()
    {
        // Arrange
        $fill = [
            'slug' => 'slug-to-be-deleted',
        ];
        $slug = $this->makeSlug($fill);
        $slug->save();

        // Act
        $slug->delete();

        // Assert
        $this->assertDatabaseMissing('slugs', ['id' => $slug->id]);
    }

    /*
     * Protected Methods
     */
    protected function makeSlug(array $fill = [])
    {
        $sluggable = new TestSluggable;
        $sluggable->id = 12345;
        $slug = new Slug($fill);
        $slug->sluggable()->associate($sluggable);

        return $slug;
    }
}
