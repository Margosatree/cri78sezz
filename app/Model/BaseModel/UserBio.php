<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class UserBio extends Model
{
    use SoftDeletes;
    protected $table = 'user_masters';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'first_name','middle_name', 'last_name', 'date_of_birth','gender', 'physically_challenged',
        'phone','email', 'username','address','suburb', 'city', 'state','country', 'pin'
        
    ];

    protected $hidden = [
        'created_at','updated_at','deleted_by','updated_by','deleted_at'
    ];
}
