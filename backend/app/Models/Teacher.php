<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'role',
        'biography',
        'photo_path',
        'photo_alt',
        'display_order',
        'status',
    ];

    protected $casts = [
        'display_order' => 'integer',
        'status' => 'string',
    ];

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}