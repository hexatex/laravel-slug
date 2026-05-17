<?php

namespace Hexatex\LaravelSlug\Tests\Unit\Slug\Resources\Admin;

use Hexatex\LaravelImage\Factories\ImageFactory;
use Hexatex\LaravelImage\Image\Resources\Admin\ImageResource;
use Hexatex\LaravelSlug\Factories\SlugFactory;
use Hexatex\LaravelSlug\Factories\SlugItemFactory;
use Hexatex\LaravelSlug\SlugItem\SlugItem;
use Hexatex\LaravelSlug\SlugItem\Resources\Admin\SlugItemResource;
use Hexatex\LaravelSlug\Slug\Slug;
use Hexatex\LaravelSlug\Slug\Resources\Admin\SlugResource;
use Hexatex\LaravelSlug\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class SlugResourceTest extends TestCase
{
    use RefreshDatabase;

    public function testSlugResource()
    {
        // Arrange
        $slug = SlugFactory::new()->make();
        $slug->id = 12345;
        $slug->created_at = Carbon::yesterday();
        $slug->updated_at = Carbon::now();
        $resource = new SlugResource($slug);

        // Act
        $data = $resource->toArray(request());

        // Assert
        $this->assertEquals([
            'id' => $slug->id,
            'slug' => $slug->slug,
            'created_at' => $slug->created_at,
            'updated_at' => $slug->updated_at,
            // todo when sluggable relation is added to resource make sure to test for $this->whenLoaded() expectations
        ], $data);
    }
}
