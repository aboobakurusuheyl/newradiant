<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'id_number',
        'home_address',
        'telephone_no',
        'nationality',
        'school_attended',
        'parent_name',
        'parent_telephone',
        'photograph_path',
        'heard_about',
        'heard_about_other',
        'application_received_by',
        'reg_no',
        'squad',
        'centre',
        'remarks',
        'status'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    // Accessor for full name
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    // Scope for pending enrollments
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Scope for approved enrollments
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
}
