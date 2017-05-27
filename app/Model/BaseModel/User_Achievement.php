<?php

namespace App\Model\BaseModel;

use Illuminate\Database\Eloquent\Model;

class User_Achievement extends Model
{
    protected $table = 'user_achievements';
    
    protected $fillable = [
        'title','orgname','name','location', 'start_date', 'end_date'
    ];
}
