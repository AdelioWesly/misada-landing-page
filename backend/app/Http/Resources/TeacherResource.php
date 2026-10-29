<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'role' => $this->role,
            'biography' => $this->biography,
            'photo_path' => $this->photo_path,
            'photo_alt' => $this->photo_alt,
            'display_order' => $this->display_order,
        ];
    }
}