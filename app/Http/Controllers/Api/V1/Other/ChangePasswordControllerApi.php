<?php

namespace App\Http\Controllers\Api\V1\Other;
use App\Http\Controllers\Controller;
use App\Model\UserOrganisation_model;
use Validator;
use Illuminate\Http\Request;
use Auth;
use Hash;
//use Illuminate\Support\Facades\Crypt;
//use \Crypt;
class ChangePasswordControllerApi extends Controller {
    protected $UserOrganisation_model;
    
    public function __construct(){
        $this->UserOrganisation_model = new UserOrganisation_model();
    }
    
    protected function _initModel(){
        $this->UserOrganisation_model = new UserOrganisation_model();
    }
    
    public function updatePass(Request $request){
        $validator = Validator::make($request->all(), [
            'user_master_id' => [
                'required',
                'numeric',
                'min:1'
            ],
            'current_password' => [
                'required',
                'max:50'
            ],
            'password' => [
                'required',
                'confirmed',
                'regex:/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/',
            ]
        ]);
        if(!$validator->fails()){
            $User = $this->UserOrganisation_model->getIdByUserId($request->user_master_id);
            if($User){
                if(password_verify(request('current_password'), $User->password)) {
                    $User = $this->UserOrganisation_model->getById($User->id);
                    $User->password = Hash::make($request->password);
                    $User->save();
                    $output = array('status' => 200 ,'msg' => 'Sucess');
                }else{
                    $output = array('status' => 400 ,'msg' => 'Invalid Current Password');
                }   
            }else{
                $output = array('status' => 400 ,'msg' => 'Invalid User');
            }
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail','errors' => $validator->errors()->all());
        }
        return redirect()->route();
    }
    
    public function adminUpdatePass(Request $request){
        $validator = Validator::make($request->all(), [
            'user_master_id' => [
                'required',
                'numeric',
                'min:1'
            ],
            'password' => [
                'required',
                'confirmed',
                'regex:/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/',
            ]
        ]);
        if(!$validator->fails()){
            $Users = $this->UserOrganisation_model->getIdByUserId($request->user_master_id);
            if($Users){
                $User = $this->UserOrganisation_model->findById($Users->id);
                $User->password = Hash::make($request->password);
                    $User->save();
                $output = array('status' => 200 ,'msg' => 'Sucess');
            }else{
                $output = array('status' => 400 ,'msg' => 'Invalid User');
            }
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail','errors' => $validator->errors()->all());
        }
        return response()->json($output);
    }
    
}
