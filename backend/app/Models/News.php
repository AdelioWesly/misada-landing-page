<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'author_id',
        'title',
        'slug',
        'summary',
        'body',
        'featured_image',
        'image_alt',
        'status',
        'published_at',
    ];

    protected $casts = [
        'status' => 'string',
        'published_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(NewsCategory::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}