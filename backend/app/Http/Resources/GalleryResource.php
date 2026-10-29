<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GalleryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'featured_image' => $this->featured_image,
            'image_alt' => $this->image_alt,
            'status' => $this->status,
            'published_at' => $this->published_at,
            'items' => $this->whenLoaded('items', function () {
                return GalleryItemResource::collection($this->items);
            }),
        ];
    }
}