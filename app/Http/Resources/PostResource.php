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
            'post_title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->body,
            'status' => $this->is_published ? 'Published' : 'Draft',
            'publication_date' => $this->publish_date ,
            'meta_description' => $this->meta_description,
            'tags' => $this->tags,
            'keywords' => $this->keyword,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
