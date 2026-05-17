<?php

namespace Hexatex\LaravelSlug\Slug\Resources\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SlugResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'slug' => $this->slug,
            // todo add sluggable resource for poly morph relationship, sluggable resources should also include morph_class attribute
        ];
    }
}
