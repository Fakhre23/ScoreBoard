<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserHistory extends Model
{

    public $timestamps = false; // Laravel automatically expects the updated_at column

    protected $table = 'user_history';
    protected $fillable = [
        'user_id',
        'role_id',
        'created_at',
        'start_date',
        'end_date',
        'approved_by',
        'approval_status',
        'notes',
    ];
}
