<?php

namespace App\Model\BaseModel;

use Illuminate\Database\Eloquent\Model;

class Reset_verify extends Model
{
    protected $table = 'reset_verify';
    
    protected $fillable = [
        'email','mobile','mobile_otp','email_otp', 'token', 'is_password_reset'
    ];
}
