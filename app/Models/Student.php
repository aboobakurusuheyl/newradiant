<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'date_of_birth',
        'age_group',
        'guardian_id',
        'jersey_number',
        'position',
        'medical_notes',
        'notes',
        'is_active',
        'experience',
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_relation',
        'enrollment_status',
        'assigned_coach_id',
        'approved_at',
        'approval_notes',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function guardian(): BelongsTo
    {
        return $this->belongsTo(Guardian::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function assignedCoach(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_coach_id');
    }

    public function paymentRequests(): HasMany
    {
        return $this->hasMany(PaymentRequest::class);
    }

    public function getAgeAttribute()
    {
        return $this->date_of_birth->age;
    }

    public function isApproved(): bool
    {
        return $this->enrollment_status === 'approved' && $this->is_active;
    }

    public function isPending(): bool
    {
        return $this->enrollment_status === 'pending';
    }

    public function isRejected(): bool
    {
        return $this->enrollment_status === 'rejected';
    }
}
