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

	public function insertData($data){
		return Reset_verify::create($data);
	}

	public function updateByEmailOrMobile($check_data=array(),$update_data=array()){
		return Reset_verify::where($check_data)->update($update_data);
	}

}