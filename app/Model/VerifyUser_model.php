<?php

namespace App\Model;
use App\Model\BaseModel\verify_user;

class VerifyUser_model {

	public function __construct(){
		//parent::__construct();
	}

	public function getValueByEmail($email){
		if(is_numeric($email)){
			return verify_user::where('mobile',$email)->get();
		}else{
			return verify_user::where('email',$email)->get();
		}
		
	}

	public function getEmailOtp($random_num){
		return verify_user::where('email_otp',$random_num)
                                       ->get();
	}

	public function checkMobileOtp($random_num){
		return verify_user::where('mobile_otp',$random_num)->get();
	}

	public function createData($data){
		return verify_user::create($data);
	}

	public function updateByEmail($data){
		return verify_user::where('email', $data['email'])
                        ->update(['token' => $data['token'],
                            'email_otp'=>$data['email_otp']]);
	}
	public function updateByMobile($data){
		return verify_user::where('email', $data['email'])
                        ->update(['mobile' => $data['mobile']
                        	      ,'mobile_otp'=>$data['mobile_otp']
                        	      ]);
	}

	public function deleteByMobile($mobile){
		return verify_user::where('mobile',$mobile_no)->delete();  
	}

}