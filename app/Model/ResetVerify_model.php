<?php

namespace App\Model;
use App\Model\BaseModel\Reset_verify;

class ResetVerify_model {

	public function __construct(){
		//parent::__construct();
	}

	public function getValueByEmailOrMobile($data){
		if(isset($data['email'])){
			return Reset_verify::where($data)->get();
		}else{
			return Reset_verify::where($data)->get();
		}
	}

	public function createData($data){
		return Reset_verify::create($data);
	}

	public function updateByEmail($data){
		return Reset_verify::where(['email'=>$data['email'],
							'is_password_reset'=>$data['is_password_reset']])
                        ->update(['token' => $data['token'],
                            'email_otp'=>$data['email_otp']]);
	}

}