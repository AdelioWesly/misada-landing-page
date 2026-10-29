<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'summary' => $this->summary,
            'body' => $this->body,
            'starts_at' => $this->starts_at,
            'ends_at' => $this->ends_at,
            'location' => $this->location,
            'registration_url' => $this->registration_url,
            'featured_image' => $this->featured_image,
            'image_alt' => $this->image_alt,
            'status' => $this->status,
            'published_at' => $this->published_at,
        ];
    }
}