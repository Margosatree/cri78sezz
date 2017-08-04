<?php

namespace App\Http\Controllers\Api\V1\Users\Player;
use JWTAuth;
use JWTAuthException;
use Hash;
use Excel;
use Session;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Model\UserMaster_model;
use App\Model\UserOrganisation_model;
use Event;
use App\Events\SendMailQueue;
use App\Services\V1\SendMailAndOtpServices;

class UsersBulkControllerApi extends Controller
{
    
    //call model class via object 

    protected $UserMaster_model;
    protected $UserOrganisation_model;
    protected $SendMailAndOtpServices;

    public function __construct(){
        $this->_initModel();
//        $this->middleware('auth');
    }

    protected function _initModel(){
        $this->UserMaster_model = new UserMaster_model();
        $this->UserOrganisation_model = new UserOrganisation_model();
        $this->SendMailAndOtpServices = new SendMailAndOtpServices();
    }
    public function upload(Request $request){
        $validator = Validator::make($request->all(), [
            'excel' => 'required',
            'mime' => 'required'
        ]);
        if(!$validator->fails()){
//            dd($request->all());
            $excel_B64 = $request->excel;
            $mime_data = $request->mime;
            $rand_str = str_random(10);
            $filename = "Excel"."$rand_str.$mime_data";
            $excel_B64 = base64_decode($excel_B64);
            file_put_contents(public_path('images/'. $filename), $excel_B64);
            $data = Excel::load(public_path('images/'. $filename), function($reader) {
            })->get();
//            })->get()->toArray();
//            echo json_encode($data);die();
            if(!empty($data) && $data->count()){
                $Errors = array();
                $count = 0;
                foreach ($data as $key => $value) {
                    if(isset($value['username']) && isset($value['phone']) && isset($value['email'])){
                        if($value['username'] != ""){
                            if(strlen(''.$value['username']) > 50){
                                $username['lengh'] = 'Username Filed Is Too Long Max 50';
                            }
                            if(!ctype_alnum(''.$value['username'])){
                                $username['alpha_num'] = 'Must Be Alphanumeric';
                            }
//                            $Username_Exists = $this->UserMaster_model->userExists($value['username']);
//                            if($Username_Exists->count){
//                                $username['unique'] = 'Username Already Exists';
//                            }
                        }else{
                            $username['data'] = 'Data Not Found';
                        }
                        if($value['phone'] != ""){
                            if(!is_numeric($value['phone'])){
                                $phone['numeric'] = 'Should Be A Number';
                            }else{
                                if(!preg_match('/(7|8|9)\d{9}/', $value['phone'])){
                                    $phone['phonenumber'] = 'Phone Number Should Start With 9|8|7';
                                }
                            }
                            if(strlen(''.$value['phone']) != 10){
                                $phone['lengh'] = 'Invalid Phone Number';
                            }
                            $Phone_Exists = $this->UserMaster_model->phoneExists($value['phone']);
                            if($Phone_Exists->count){
                                $phone['unique'] = 'Phone Already Exists';
                            }
                        }else{
                            $phone['data'] = 'Data Not Found';
                        }
                        if($value['email'] != ""){
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
                            $User_Data['u_id'] = ++$count;
                            $User_Data['u_username'] = $value['username'];
                            $User_Data['u_phone'] = $value['phone'];
                            $User_Data['u_email'] = $value['email'];
                            array_push($Errors, $User_Data);
                        }
                        if(!isset($username) && !isset($phone) && !isset($email)){
                            $virtual_data['username'] = $value['username'];
                            $virtual_data['phone'] = $value['phone'];
                            $virtual_data['email'] = $value['email'];
                            $virtual_data['password'] = str_random(40);
//                            dd($virtual_data);
//                            $user = JWTAuth::parseToken()->authenticate();
//                            $User_Mst_Data['username'] = $value['username'];
//                            $User_Mst_Data['phone'] = $value['phone'];
//                            $User_Mst_Data['email'] = $value['email'];
////                            dd($User_Mst_Data);
//                            $User_master = $this->UserMaster_model->insert($User_Mst_Data);
//                            
//                            $User_Org_Data = new \stdClass();
//                            $User_Org_Data->user_master_id = $User_master->id;
//                            $User_Org_Data->organization_master_id = $user->organization_master_id;
//                            $User_Org_Data->email = $User_master->email;
////                            $User_Org_Data->password = $User_master->username.'@123';
//                            $User_Org_Data->status = 0;
//                            $User_Org_Data->role = 'user';
//                            $this->UserOrganisation_model->SaveUserOrg($User_Org_Data);
                            
                            $vuser_data = $this->UserMaster_model->getVirtualUserDetail($virtual_data);
                            if($vuser_data){
                                $this->UserMaster_model->deleteVUser($vuser_data->id);
                            }
                            $this->UserMaster_model->insertViratualUser((object)$virtual_data);
                            $this->SendMailAndOtpServices->sendVerifyNotify($virtual_data['email'],$virtual_data['phone']);
                        }
                        unset($username);unset($phone);unset($email);unset($User_Data);
                    }else{
                        $Errors = array('status_code' => 400, 'message' => 'Invalid File Format');
                    }
                }
                if($Errors == null){
                    $output['status_code'] = 200;
                    $output['message'] = 'Sucess';
                }else{
                    $output['status_code'] = 400;
                    $output['message'] = 'Error In Some Entries';
                    $output['data'] = $Errors;
                }
            }
        }else{
            $output = array('status_code' => 400 ,'message' => 'Transection Fail','errors' => $validator->errors()->all());
        }
         return response()->json($output,$output['status_code']);
    }
}
