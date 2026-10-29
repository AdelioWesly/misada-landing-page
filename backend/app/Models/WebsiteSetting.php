<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
    ];

    protected $casts = [
        'value' => 'json',
    ];

    public function scopeAllowlist($query)
    {
        return $query->whereIn('key', [
            'school_name',
            'tagline',
            'logo_url',
            'contact_email',
            'contact_phone',
            'address',
            'social_links',
        ]);
    }
}