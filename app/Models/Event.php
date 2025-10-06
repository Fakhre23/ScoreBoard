<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'location',
        'start_datetime',
        'end_datetime',
        'max_participants',
        'created_by',
        'status',
        'approved_by',
        'approval_date',
        'rejection_reason',
        'scope',
        'university_id',
        'actual_participants',
        'created_at',
    ];

    // Each event belongs to the user who created it
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Each event may also belong to an approver
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Each event belongs to one university (if scope is "University")
    public function university()
    {
        return $this->belongsTo(University::class, 'university_id');
    }

    // Each event has many score claims (users who registered)
    public function scoreClaims()
    {
        return $this->hasMany(ScoreClaim::class, 'event_id');
    }
}
