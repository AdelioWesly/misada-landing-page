<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'featured_image',
        'image_alt',
        'status',
        'published_at',
    ];

    protected $casts = [
        'status' => 'string',
        'published_at' => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(GalleryItem::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}