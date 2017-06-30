<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Reset_verify extends Model
{
    use SoftDeletes;
    protected $table = 'reset_verify';
    protected $dates = ['deleted_at'];
    protected $hidden = [
        'created_at','updated_at','deleted_by','updated_by','deleted_at'
    ];
    
    protected $fillable = [
        'email','mobile','mobile_otp','email_otp', 'token', 'is_password_reset'
    ];
}
