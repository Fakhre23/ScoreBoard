<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


//by default the search on the plural of the model name and represent it as a tabel (if you dont use protected $table)

class University extends Model
{
    //Here you define the model as a table
    protected $table = 'universities';
    protected $fillable = ['name', 'country', 'total_score', 'Status', 'UNI_photo', 'created_at', 'updated_at'];
}
