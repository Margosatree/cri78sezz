<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_Achievement extends Model
{
    protected $table = 'user_achievements';
    
    protected $fillable = [
        'title','location', 'start_date', 'end_date'
    ];
}
