<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnnouncementResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'summary' => $this->summary,
            'body' => $this->body,
            'status' => $this->status,
            'published_at' => $this->published_at,
            'expires_at' => $this->expires_at,
            'attachment' => $this->attachment ? [
                'url' => $this->attachment_path,
                'name' => $this->attachment_name,
                'mime_type' => $this->attachment_mime_type,
            ] : null,
        ];
    }
}