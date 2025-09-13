<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Player extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'nickname',
        'jersey_number',
        'position',
        'position_detail',
        'date_of_birth',
        'nationality',
        'height',
        'weight',
        'preferred_foot',
        'photo',
        'biography',
        'career_stats',
        'achievements',
        'contract_start',
        'contract_end',
        'is_active',
        'is_captain',
        'is_vice_captain',
        'sort_order',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'career_stats' => 'array',
        'achievements' => 'array',
        'is_active' => 'boolean',
        'is_captain' => 'boolean',
        'is_vice_captain' => 'boolean',
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getDisplayNameAttribute()
    {
        return $this->nickname ?: $this->full_name;
    }

    public function getAgeAttribute()
    {
        return $this->date_of_birth ? Carbon::parse($this->date_of_birth)->age : null;
    }

    public function getPositionBadgeClassAttribute()
    {
        return match($this->position) {
            'Goalkeeper' => 'bg-green-100 text-green-800',
            'Defender' => 'bg-blue-100 text-blue-800',
            'Midfielder' => 'bg-yellow-100 text-yellow-800',
            'Forward' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByPosition($query, $position)
    {
        return $query->where('position', $position);
    }

    public function scopeCaptains($query)
    {
        return $query->where('is_captain', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('jersey_number');
    }

    public function scopeByJerseyNumber($query, $number)
    {
        return $query->where('jersey_number', $number);
    }
}
