<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'gallery_id',
        'display_order',
        'image_path',
        'video_url',
        'alt_text',
        'caption',
    ];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }
}