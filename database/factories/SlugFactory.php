<?php

namespace Hexatex\LaravelSlug\Factories;

use Hexatex\LaravelSlug\Slug\Slug;
use Hexatex\LaravelMisc\Contracts\Authenticatable;
use Hexatex\LaravelSlug\Slug\Contracts\Sluggable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use \Str;

class SlugFactory extends Factory
{
    protected $model = Slug::class;

    public function definition()
    {
        return [
            'slug' => Str::slug($this->faker->sentence),
        ];
    }

    /*
     * States
     */
    public function sluggable(Sluggable $sluggable)
    {
        return $this->afterMaking(function (Slug $slug) use ($sluggable) {
            $slug->sluggable()->associate($sluggable);
        });
    }
}
