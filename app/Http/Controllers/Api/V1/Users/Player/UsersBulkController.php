<?php

namespace App\Http\Controllers\Api\V1\Users\Player;

use Auth;
use Hash;
use Excel;
use Session;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;
use App\Model\UserMaster_model;
use App\Model\UserOrganisation_model;

class UsersBulkController extends Controller
{
    
    //call model class via object 

    protected $UserMaster_model;
    protected $UserOrganisation_model;

    public function __construct(){
        $this->_initModel();
        $this->middleware('auth');
    }

    protected function _initModel(){
        $this->UserMaster_model = new UserMaster_model();
        $this->UserOrganisation_model = new UserOrganisation_model();
    }
    
    public function bulkUpload(Request $request){
        if(Input::hasFile('import_file')){
            $path = Input::file('import_file')->getRealPath();
            $data = Excel::load($path, function($reader) {
            })->get();

            if(!empty($data) && $data->count()){
                $Errors = array();
                $count = 0;
                foreach ($data as $key => $value) {
                    if(isset($value['username']) || !isEmpty($value['username'])){
                        if(strlen(''.$value['username']) > 50){
                            $username['lengh'] = 'Username Filed Is Too Long';
                        }
                        if(!ctype_alnum(''.$value['username'])){
                            $username['alpha_num'] = 'Must Be Alphanumeric';
                        }
                        $Username_Exists = $this->UserMaster_model->userExists($value['username']);
                        if($Username_Exists->count){
                            $username['unique'] = 'Username Already Exists';
                        }
                    }else{
                        $username['data'] = 'Data Not Found';
                    }
                    if(isset($value['phone']) || !isEmpty($value['phone'])){
                        if(!is_numeric($value['phone'])){
                            $phone['numeric'] = 'Should Be A Number';
                        }
                        if(strlen(''.$value['phone']) != 10){
                            $phone['lengh'] = 'Invalid Phone Number';
                        }
                        if(!preg_match('/(7|8|9)\d{9}/', $value['phone'])){
                            $phone['phonenumber'] = 'Phone Number Should Start With 9|8|7';
                        }
                        $Phone_Exists = $this->UserMaster_model->phoneExists($value['phone']);
                        if($Phone_Exists->count){
                            $phone['unique'] = 'Phone Already Exists';
                        }
                    }else{
                        $phone['data'] = 'Data Not Found';
                    }
                    if(isset($value['email']) || !isEmpty($value['email'])){
                        if(strlen(''.$value['email']) > 50){
                            $email['lengh'] = 'email Filed Is Too Long';
                        }
                        if(!preg_match('/(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@[*[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+]*/', $value['email'])){
                            $email['email'] = 'Invalid Email';
                        }
                        $email_Exists = $this->UserMaster_model->emailExists($value['email']);
                        if($email_Exists->count){
                            $email['unique'] = 'Email Already Exists';
                        }
                    }else{
                        $email['data'] = 'Data Not Found';
                    }
                    if(isset($username) && count($username) > 0){
                        $User_Data['username'] = $username;
                    }
                    if(isset($phone) && count($phone) > 0){
                        $User_Data['phone'] = $phone;
                    }
                    if(isset($email) && count($email) > 0){
                        $User_Data['email'] = $email;
                    }
                    if(isset($User_Data) && count($User_Data) > 0){
                        $User_Data['u_id'] = $value['id'];
                        $User_Data['u_username'] = $value['username'];
                        $User_Data['u_phone'] = $value['phone'];
                        $User_Data['u_email'] = $value['email'];
                        $Errors[$value['id']] = $User_Data;
                    }
                    if(!isset($username) && !isset($phone) && !isset($email)){
                        
                        $User_master = $this->UserMaster_model->insert(
                            ['username' => $value['username']],
                            ['phone' => $value['phone']],
                            ['email' => $value['email']]
                        );

                        $User_Org = $this->UserMaster_model->insert(
                            ['username' => $User_master->id],
                            ['organization_master_id' => Auth::user()->organization_master_id],
                            ['email' => $value['email']],
                            ['password' => $value['username'].'@123'],
                            ['role' => 'user']
                        );
                    }else{
                        $count++;
                    }
                }
//                dd($Errors);
                Session::put('msg','Your '.$count.' Entry Is Not Saved');
                return view('user.org.bulk', compact('Errors'));
            }
        }
        Session::put('msg','Please Select File');
        return redirect()->back();
    }
}
