<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';

    //Allowed fields to be mass assigned (all columns)
    protected $guarded = [];
}
