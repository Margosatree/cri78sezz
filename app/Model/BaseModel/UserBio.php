<?php

namespace App\Model\BaseModel;

use Illuminate\Database\Eloquent\Model;

class UserBio extends Model
{
    protected $table = 'user_masters';
    
    protected $fillable = [
        'first_name','middle_name', 'last_name', 'date_of_birth','gender', 'physically_challenged',
        'phone','email', 'username','address','suburb', 'city', 'state','country', 'pin'
        
    ];
}
