<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSection extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'image',
        'button_text',
        'button_link',
        'type',
        'is_active',
        'sort_order',
        'published_at',
        'expires_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'published_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    protected $appends = ['image_url'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where(function($q) {
                        $q->whereNull('published_at')
                          ->orWhere('published_at', '<=', now());
                    })
                    ->where(function($q) {
                        $q->whereNull('expires_at')
                          ->orWhere('expires_at', '>=', now());
                    });
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at', 'desc');
    }

    public function isPublished()
    {
        return $this->is_active && 
               ($this->published_at === null || $this->published_at <= now()) &&
               ($this->expires_at === null || $this->expires_at >= now());
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return '/img/team.jpg'; // Default fallback image
        }
        
        // If it's a full URL (external), return as is
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }
        
        // If it's a storage path (uploaded image), return storage URL
        if (str_starts_with($this->image, 'hero-sections/')) {
            return '/storage/' . $this->image;
        }
        
        // If it's just a filename (local image), return from img folder
        return '/img/' . $this->image;
    }
}
