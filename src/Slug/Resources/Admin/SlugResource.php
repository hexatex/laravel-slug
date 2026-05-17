<?php

namespace Hexatex\LaravelSlug\Slug\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SlugResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            // todo add sluggable resource for poly morph relationship, sluggable resources should also include morph_class attribute
        ];
    }
}
