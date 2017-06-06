<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsersBioController_Api
 *
 * @author Das
 */
namespace App\Http\Controllers\Api\V1\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\UserMaster_model;
class UsersBioControllerApi extends Controller{
    
    protected $UserMaster_model;
    public function __construct() {
        $this->_initModel();
    }
    
    protected function _initModel(){
        $this->UserMaster_model = new UserMaster_model();
    }
    
    public function addUserBio(Request $request){
        
        $this->validate(request(), [
            'first_name' => 'required|max:50|alpha',
            'middle_name' => 'required|max:50|alpha',
            'last_name' => 'required|max:50|alpha',
            'date_of_birth' => 'required|date|before:'.date('Y-m-d', strtotime('-5 year')),
            'gender' => 'in:female,male',
            'physically_challenged' => 'in:no,yes',
        ]);
//        dd(request()->all());
        $User_Bio = $this->UserMaster_model->SaveUserBio($request);
        if($User_Bio){
            $output = array('status' => 200 ,'msg' => 'Entry Added Successfuly');
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail');
        }
        return response()->json($output);
    }
}
