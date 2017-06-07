<?php

namespace App\Model\BaseModel;

use Illuminate\Database\Eloquent\Model;

class verify_user extends Model
{
    protected $fillable = [
		'email','mobile','mobile_otp','email_otp','token'
	];
}
