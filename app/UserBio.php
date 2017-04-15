<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBio extends Model
{
    protected $table = 'user_masters';
    
    protected $fillable = [
        'address','suburb', 'city', 'state','country', 'pin'
    ];
}
