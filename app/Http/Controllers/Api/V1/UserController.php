<?php
namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use JWTAuthException;
use Validator;
use App\Model\UserOrganisation_model;
use App\Model\UserMaster_model;
use App\Model\Role_model;
use App\Model\RoleUser_model;
use App\Services\V1\SendMailAndOtpServices;

class UserController extends Controller
{   

    //call model class via object

    protected $UserMaster_model;
    protected $UserOrganisation_model;
    protected $Role_model;
    protected $RoleUser_model;
    protected $SendMailAndOtpServices;


    public function __construct(){
        $this->UserMaster_model=new UserMaster_model();
        $this->UserOrganisation_model=new UserOrganisation_model();
        $this->Role_model=new Role_model();
        $this->RoleUser_model=new RoleUser_model();
        $this->SendMailAndOtpServices =new SendMailAndOtpServices();
    }
   
    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'username' => 'required|max:50|alpha_num|unique:user_masters',
            'phone' => [
                'required',
                'unique:user_masters',
                'min:10',
                'numeric',
                'regex:/(7|8|9)\d{9}/'
            ],
            'email' => [
                'required',
                'email',
                'unique:user_masters',
                'regex:/(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@[*[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+]*/',
            ],
            'password' => [
                'required',
                'regex:/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/',
            ]
        ]);

        if($validator->fails()){
            return Response::json(
                            ['error'=>[
                                        'error_message'=>$validator->errors()->all(),
                                        'status_code'=>403
                                ]],403);
        }

        $data = array(
                        'username'=>$request->username,
                        'phone'=>$request->phone,
                        'email'=>$request->email,
                        'password'=>$request->password,
                    );

        $this->SendMailAndOtpServices->sendVerifyNotify($data['email'],$data['phone']);
        
        $User_Master = $this->UserMaster_model->insert($data);

        $OrgData = ['um_id'=>$User_Master->id,'email'=>$data['email'],
                    'organization_master_id' => 0,'password'=>$data['password']];
        $user_orgId = $this->UserOrganisation_model->insert($OrgData);

        $user_role = $this->Role_model->getPlayerId();
        $normal_user = $user_role->id;

        $user_role = $this->RoleUser_model->insert($user_orgId->id,$normal_user);

        return response()->json(['status'=>true,'message'=>'User created successfully','data'=>$user_orgId]);
    }
    
    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return Response::json(
                            ['error'=>[
                                        'error_message'=>$validator->errors()->all(),
                                        'status_code'=>403
                                ]],403);
        }
        $credentials = $request->only('email', 'password');
        $token = null;
        try {
           if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['invalid_email_or_password'], 422);
           }
        } catch (JWTAuthException $e) {
            return response()->json(['failed_to_create_token'], 500);
        }
        return response()->json(compact('token','controller'));
    }
    public function getAuthUser(){
        $user = JWTAuth::parseToken()->authenticate();
        return response()->json(['result' => $user]);
    }

    public function getUserProfile(){
        // $user = JWTAuth::parseToken()->authenticate();
        $data = $this->UserOrganisation_model->displayUserProfile();
        return response()->json(['result' => $data]);
    }

    public function verifyUser(Request $request){
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email_otp' => 'required|numeric|digits:6',
            'mobile_otp' => 'required|numeric|digits:6'
        ]);
        if($validator->fails()){
            return Response::json(
                            ['error'=>[
                                        'error_message'=>$validator->errors()->all(),
                                        'status_code'=>403
                                ]],403);
        }
        $data = array(
                        'token' => $request->token,
                        'email_otp' => $request->email_otp,
                        'mobile_otp' => $request->mobile_otp
                    );

        $check_if_exists = $this->SendMailAndOtpServices->verifyEmailMobileUser($data);
        if(count($check_if_exists)){
            return Response::json(
                            ['success'=>[
                                        'message'=>'successfuly verified.',
                                        'status_code'=>200
                                ]],200);
        }else{
            return Response::json(
                            ['error'=>[
                                    'message'=>'Email and Mobile Otp is Invalid',
                                    'status_code'=>403
                                ]],403);
        }
    }


    public function forgetPassword(Request $request){

        if(is_numeric($request->email_or_mobile)){
            $validator = Validator::make($request->all(),[
                'email_or_mobile'=>'required|numeric|min:10',
            ]);

            if($validator->fails()){
            return Response::json(
                            ['error'=>[
                                        'error_message'=>$validator->errors()->all(),
                                        'status_code'=>403
                                ]],403);
            }
            // dd('number');
            $status = $this->SendMailAndOtpServices
                            ->sendOtpForForgetPass($request->email_or_mobile);

        }else{
            $validator = Validator::make($request->all(),[
                'email_or_mobile'=>'required|email',
            ]);
            
            if($validator->fails()){
            return Response::json(
                            ['error'=>[
                                        'error_message'=>$validator->errors()->all(),
                                        'status_code'=>403
                                ]],403);
            }

            $status = $this->SendMailAndOtpServices
                            ->sendEmailForForgetPass($request->email_or_mobile);
        }

        if(count($status)){
            return Response::json(
                            ['success'=>[
                                        'message'=>'successfuly Send.',
                                        'status_code'=>200
                                ]],200);
        }else{
            return Response::json(
                            ['error'=>[
                                    'message'=>'Email OR Mobile Invalid',
                                    'status_code'=>403
                                ]],403);
        }
    }

    public function resetPassByEmail(Request $request){
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'conf_pass' => 'required|same:password'
        ]);
        if($validator->fails()){
            return Response::json(
                            ['error'=>[
                                        'error_message'=>$validator->errors()->all(),
                                        'status_code'=>403
                                ]],403);
        }

        $data = array('token'=>$request->token,
                      'email'=>$request->email,
                      'password'=>$request->password);

        

        $status = $this->SendMailAndOtpServices->resetPassByEmails($data);

        if(count($status)){
            return Response::json(
                            ['success'=>[
                                        'message'=>'successfuly Changed Password.',
                                        'status_code'=>200
                                ]],200);
        }else{
            return Response::json(
                            ['error'=>[
                                    'message'=>'Email OR Mobile Invalid',
                                    'status_code'=>403
                                ]],403);
        }

    }

    public function resetPassByMobile(Request $request){
        $validator = Validator::make($request->all(), [
            'mobile' => 'required',
            'mobile_otp' => 'required|numeric|digits:6',
            'password' => 'required',
            'conf_pass' => 'required|same:password'
        ]);
        if($validator->fails()){
            return Response::json(
                            ['error'=>[
                                        'error_message'=>$validator->errors()->all(),
                                        'status_code'=>403
                                ]],403);
        }

        $data = array('mobile'=>$request->mobile,
                      'mobile_otp'=>$request->mobile_otp,
                      'password'=>$request->password
                      );

        $status = $this->SendMailAndOtpServices->resetPassByMobiles($data);

        if(count($status)){
            return Response::json(
                            ['success'=>[
                                        'message'=>'successfuly Send.',
                                        'status_code'=>200
                                ]],200);
        }else{
            return Response::json(
                            ['error'=>[
                                    'message'=>'Email and Mobile is not correct',
                                    'status_code'=>403
                                ]],403);
        }    
    }

} 