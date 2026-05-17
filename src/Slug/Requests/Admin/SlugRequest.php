<?php

namespace Hexatex\LaravelSlug\Slug\Requests\Admin;

use Hexatex\LaravelMisc\FormRequest;

class SlugRequest extends FormRequest
{
    public function rules()
    {
        return [
            'slug' => ['nullable', 'string', 'max:191'],
        ];
    }
}
