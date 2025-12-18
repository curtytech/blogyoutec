<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'content' => $this->content,
            'banner_url' => $this->featured_image ? url('storage/' . $this->featured_image) : null,
            'published_at' => $this->published_at,
            'author' => [
                'name' => $this->author->name,
                'image_url' => $this->author->image ? url('storage/' . $this->author->image) : null,
            ],
            'category' => $this->category ? [
                'name' => $this->category->name,
                'slug' => $this->category->slug,
            ] : null,
            'tags' => $this->tags->map(fn ($tag) => [
                'name' => $tag->name,
                'slug' => $tag->slug,
            ]),
        ];
    }
}
