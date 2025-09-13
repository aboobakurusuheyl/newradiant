<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    protected $fillable = [
        'student_id',
        'coach_id',
        'skill_rating',
        'discipline_rating',
        'fitness_rating',
        'overall_rating',
        'notes',
        'period',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function coach(): BelongsTo
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    public function getAverageRatingAttribute(): float
    {
        return ($this->skill_rating + $this->discipline_rating + $this->fitness_rating) / 3;
    }
}
