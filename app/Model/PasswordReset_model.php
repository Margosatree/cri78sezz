<?php

namespace App\Model;
use App\Model\BaseModel\Password_reset;

class PasswordReset_model {

	public function __construct(){
		//parent::__construct();
	}

	public function checkByEmailOrPhone($data){
		if(is_numeric($data)){
			if(strlen((string)$data == 6)){
				return Password_reset::where('otp',$data)->get();
			}else{
				return Password_reset::where('phone',$data)->get();
			}
		}else{
			return Password_reset::where('email',$data)->get();
		}
		
	}

	public function checkByEmailAndToken($data){
		return Password_reset::where('email',$data['email'])
    								  ->where('token',$data['token'])
    								  ->get();
	}

	public function insert($data){
		return Password_reset::create($data);
	}

	public function updateTokenByEmail($data){
		return Password_reset::where('email', $data['email'])
          					->update(['token' => $data['token']]);
	}

	public function updatePhoneOtpByEmail($data){
		return Password_reset::where('email', $data['email'])
          					->update(['phone' => $data['phone'],'otp'=>$data['otp']]);
	}

	public function deleteByEmailOrMobile($data){
		if(is_numeric($data)){
			return Password_reset::where('email',$data)
    					   ->delete();
		}else{
			return Password_reset::where('email',$data)
    					   ->delete();
		}
		
	}


}