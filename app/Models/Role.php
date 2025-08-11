<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
        protected $table = 'standard_user_role';
        protected $fillable = [
                'name',
        ];
}
