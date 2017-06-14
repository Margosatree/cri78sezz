<?php

namespace App\Model\BaseModel;

use Illuminate\Database\Eloquent\Model;

class Password_reset extends Model
{
	protected $fillable = [
		'email','token','phone','otp',
	];
}
