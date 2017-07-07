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
use App\Model\ResetVerify_model;
use App\Services\V1\SendMailAndOtpServices;

class UserController extends Controller
{   

    //call model class via object

    protected $UserMaster_model;
    protected $UserOrganisation_model;
    protected $Role_model;
    protected $RoleUser_model;
    protected $SendMailAndOtpServices;
    protected $ResetVerify_model;


    public function __construct(){
        $this->UserMaster_model=new UserMaster_model();
        $this->UserOrganisation_model=new UserOrganisation_model();
        $this->Role_model=new Role_model();
        $this->RoleUser_model=new RoleUser_model();
        $this->SendMailAndOtpServices =new SendMailAndOtpServices();
        $this->ResetVerify_model =new ResetVerify_model();
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
            return Response::json([
                                    'message'=>$validator->errors()->all(),
                                    'status_code'=>403
                                ],403);
        }

        $data = array(
                        'username'=>$request->username,
                        'phone'=>$request->phone,
                        'email'=>$request->email,
                        'password'=>$request->password,
                    );

        $verify_token =$this->SendMailAndOtpServices->sendVerifyNotify($data['email'],$data['phone']);

        $vuser_data = $this->UserMaster_model->getVirtualUserDetail($data);
        if($vuser_data){
            $this->UserMaster_model->deleteVUser($vuser_data->id);
        }
        $User_Master = $this->UserMaster_model->insertViratualUser($data);

        $data['verify_token'] = $verify_token;
        $display_data = ['status_code'=>200
                        ,'message'=>'user_created_successfully'
                        ,'data'=>$data];
        return response()->json($display_data,200);

    }
   
    private function __register($request){

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
            return Response::json([
                                    'message'=>$validator->errors()->all(),
                                    'status_code'=>403
                                ],403);
        }

        $data = array(
                        'username'=>$request->username,
                        'phone'=>$request->phone,
                        'email'=>$request->email,
                        'password'=>$request->password,
                    );

        // $this->SendMailAndOtpServices->sendVerifyNotify($data['email'],$data['phone']);
        
        $User_Master = $this->UserMaster_model->insert($data);

        $OrgData = ['um_id'=>$User_Master->id,'email'=>$data['email'],
                    'organization_master_id' => 0,'password'=>$data['password']];
        $user_orgId = $this->UserOrganisation_model->insert($OrgData);

        $user_role = $this->Role_model->getPlayerId();
        $normal_user = $user_role->id;

        $user_role = $this->RoleUser_model->insert($user_orgId->id,$normal_user);

        $display_data = ['status_code'=>200
                        ,'message'=>'user_created_successfully'
                        ,'data'=>$user_orgId];
        return $display_data;
    }
    
    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                'email',
                'regex:/(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@[*[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+]*/',
            ],
            'password' => [
                'required',
                'regex:/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/',
            ]
        ]);

        if($validator->fails()){
            return Response::json([
                                    'message'=>$validator->errors()->all(),
                                    'status_code'=>403
                                ],403);
        }
        $credentials = $request->only('email', 'password');
        $token = null;
        try {
           if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                                    'message'=>'invalid_email_or_password',
                                    'status_code'=>403
                                ], 403);
           }
        } catch (JWTAuthException $e) {
            return response()->json([
                                    'message'=>'failed_to_create_token',
                                    'status_code'=>404
                                ], 404);
        }
        $currentUser = JWTAuth::toUser($token);
        $user_details = $this->UserOrganisation_model->getUserDetail($currentUser['user_master_id']);
        
        $data = ['user_org_id'=>$currentUser['id']
                ,'user_id'=>$currentUser['user_master_id']
                ,'org_id'=>$currentUser['organization_master_id']
                ,'user_email'=>$currentUser['email']
                ,'access_role'=>$currentUser['role']
                ,'user_token'=>$token
                ,'display_img'=>$user_details->display_img];
        return response()->json([
                                    'message'=>'success',
                                    'status_code'=>200,
                                    'data'=>$data
                                ],200);
    }
    public function getAuthUser(){
        $user = JWTAuth::parseToken()->authenticate();

        return response()->json(['result' => $user]);
    }

    public function verifyUser(Request $request){
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email_otp' => 'required|numeric|digits:6',
            'mobile_otp' => 'required|numeric|digits:6'
        ]);
        if($validator->fails()){
            return Response::json([
                                'message'=>$validator->errors()->all(),
                                'status_code'=>403
                                ],403);
        }
        $data = array(
                        'token' => $request->token,
                        'email_otp' => $request->email_otp,
                        'mobile_otp' => $request->mobile_otp
                    );

        $check_if_exists = $this->SendMailAndOtpServices->verifyEmailMobileUser($data);
        if(count($check_if_exists)){

            $datas = ['phone'=>$check_if_exists->first()->mobile,
                      'email'=>$check_if_exists->first()->email];
            $user_mobile_email =$this->UserMaster_model->getVirtualUserDetail($datas);
            $userObj = new stdClass();
            $userObej->username = $user_mobile_email->username;
            $userObej->phone = $user_mobile_email->phone;
            $userObej->email = $user_mobile_email->email;
            $userObej->password = $user_mobile_email->password;
            
            $this->__register($userObej);
            return Response::json([
                                    'message'=>'successfuly_verified.',
                                    'status_code'=>200
                                ],200);
        }else{
            return Response::json([
                                    'message'=>'email_or_mobile_otp_invalid',
                                    'status_code'=>403
                                ],403);
        }
    }


    public function forgetPassword(Request $request){

        if(is_numeric($request->email_or_mobile)){
            $validator = Validator::make($request->all(),[
                'email_or_mobile'=>'required|numeric|min:10',
            ]);

            if($validator->fails()){
            return Response::json([
                                    'message'=>$validator->errors()->all(),
                                    'status_code'=>403
                                ],403);
            }
            // dd('number');
            $status = $this->SendMailAndOtpServices
                            ->sendOtpForForgetPass($request->email_or_mobile);

        }else{
            $validator = Validator::make($request->all(),[
                'email_or_mobile'=>'required|email',
            ]);
            
            if($validator->fails()){
            return Response::json([
                                        'error_message'=>$validator->errors()->all(),
                                        'status_code'=>403
                                ],403);
            }

            $status = $this->SendMailAndOtpServices
                            ->sendEmailForForgetPass($request->email_or_mobile);
        }

        if(count($status)){
            return Response::json([
                                        'message'=>'successfuly_send.',
                                        'status_code'=>200
                                ],200);
        }else{
            return Response::json([
                                    'message'=>'email_OR_mobile_invalid',
                                    'status_code'=>403
                                ],403);
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
            return Response::json([
                                        'message'=>$validator->errors()->all(),
                                        'status_code'=>403
                                ],403);
        }

        $data = array('token'=>$request->token,
                      'email'=>$request->email,
                      'password'=>$request->password);

        

        $status = $this->SendMailAndOtpServices->resetPassByEmails($data);

        if(count($status)){
            return Response::json(
                            ['success'=>[
                                        'message'=>'successfuly_changed_password.',
                                        'status_code'=>200
                                ]],200);
        }else{
            return Response::json([
                                    'message'=>'email_OR_mobile_invalid',
                                    'status_code'=>403
                                ],403);
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
            return Response::json([
                                    'message'=>$validator->errors()->all(),
                                    'status_code'=>403
                                ],403);
        }

        $data = array('mobile'=>$request->mobile,
                      'mobile_otp'=>$request->mobile_otp,
                      'password'=>$request->password
                      );

        $status = $this->SendMailAndOtpServices->resetPassByMobiles($data);

        if(count($status)){
            return Response::json([
                                    'message'=>'successfuly_send.',
                                    'status_code'=>200
                                ],200);
        }else{
            return Response::json([
                                    'message'=>'email_and_mobile_is_not_correct',
                                    'status_code'=>403
                                ],403);
        }    
    }


    public function getUserInfo(){
        $user = JWTAuth::parseToken()->authenticate();
        $user_details = $this->UserOrganisation_model->getUserDetail($user->user_master_id);
        $user_data = array();
        $user_data['bio'] =array(
                             'id'=>$user_details->um_id
                            ,'first_name'=>$user_details->first_name
                            ,'middle_name'=>$user_details->middle_name
                            ,'last_name'=>$user_details->last_name
                            ,'date_of_birth'=>$user_details->date_of_birth
                            ,'gender'=>$user_details->gender
                            ,'phone'=>$user_details->phone
                            ,'email'=>$user_details->email
                        ,'physically_challenged'=>$user_details->physically_challenged
                            ,'display_img'=>$user_details->display_img
                            );
        $user_data['address'] =array(
                             'id'=>$user_details->um_id
                            ,'address'=>$user_details->um_address
                            ,'suburb'=>$user_details->suburb
                            ,'city'=>$user_details->um_city
                            ,'state'=>$user_details->um_state
                            ,'country'=>$user_details->um_country
                            ,'pin'=>$user_details->pin
                            ,'display_img'=>$user_details->display_img
                            );
        // $user_data['org'] =array(
        //                      'id'=>$user_details->om_id
        //                     ,'name'=>$user_details->name
        //                     ,'address'=>$user_details->om_address
        //                     ,'suburb'=>$user_details->suburb
        //                     ,'city'=>$user_details->om_city
        //                     ,'state'=>$user_details->om_state
        //                     ,'country'=>$user_details->om_country
        //                     ,'pin'=>$user_details->pincode
        //                     ,'display_img'=>$user_details->display_img
        //                     );
        $user_data['cri_profile'] =array(
                                 'id'=>$user_details->cp_id
                                ,'user_master_id'=>$user_details->user_master_id
                                ,'your_role'=>$user_details->your_role
                                ,'batsman_style'=>$user_details->batsman_style
                                ,'batsman_order'=>$user_details->batsman_order
                                ,'bowler_style'=>$user_details->bowler_style
                                ,'player_type'=>$user_details->player_type
                                ,'description'=>$user_details->description
                                ,'is_completed'=>$user_details->is_completed
                                ,'display_img'=>$user_details->display_img
                                );
        return response()->json([
                                    'message'=>'successfu.',
                                    'status_code'=>200,
                                    'data'=>$user_data
                                ],200);
    }

    public function verifyUserToken(){
        $validator = Validator::make($request->all(), [
            'token' => 'required',
        ]);
        if($validator->fails()){
            return Response::json([
                                'message'=>$validator->errors()->all(),
                                'status_code'=>403
                                ],403);
        }

        $user = JWTAuth::toUser($token);
        if(is_null($user)){
               $display_data = [
                                'message'=>'token_is_invalid',
                                'status_code'=>403
                                ];
        }else{
            $display_data = [
                                'message'=>'token_is_valid',
                                'status_code'=>200,
                                'data'=>$user
                                ];
        }

        return Response::json($display_data,$display_data['status_code']);

    }

} 