<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{
    protected $fillable = [
        'opponent',
        'match_date',
        'match_time',
        'venue',
        'type',
        'competition',
        'age_group',
        'our_score',
        'opponent_score',
        'status',
        'notes',
    ];

    protected $casts = [
        'match_date' => 'date',
        'match_time' => 'datetime:H:i',
    ];

    public function getResultAttribute(): string
    {
        if ($this->our_score === null || $this->opponent_score === null) {
            return 'TBD';
        }

        if ($this->our_score > $this->opponent_score) {
            return 'W';
        } elseif ($this->our_score < $this->opponent_score) {
            return 'L';
        } else {
            return 'D';
        }
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isUpcoming(): bool
    {
        return $this->status === 'scheduled' && $this->match_date > now()->toDateString();
    }
}
