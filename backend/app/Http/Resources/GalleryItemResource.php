<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GalleryItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'gallery_id' => $this->gallery_id,
            'display_order' => $this->display_order,
            'image_path' => $this->image_path,
            'video_url' => $this->video_url,
            'alt_text' => $this->alt_text,
            'caption' => $this->caption,
        ];
    }
}