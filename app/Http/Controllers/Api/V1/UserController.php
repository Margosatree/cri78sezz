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
use App\Model\TournamentUser_model;
use App\Model\TournamentMaster_model;

class UserController extends Controller
{   
    

    //call model class via object

    protected $UserMaster_model;
    protected $UserOrganisation_model;
    protected $Role_model;
    protected $RoleUser_model;
    protected $SendMailAndOtpServices;
    protected $ResetVerify_model;
    protected $TournamentUser_model;
    protected $TournamentMaster_model;


    public function __construct(){
        $this->UserMaster_model=new UserMaster_model();
        $this->UserOrganisation_model=new UserOrganisation_model();
        $this->Role_model=new Role_model();
        $this->RoleUser_model=new RoleUser_model();
        $this->SendMailAndOtpServices =new SendMailAndOtpServices();
        $this->ResetVerify_model =new ResetVerify_model();
        $this->TournamentUser_model = new TournamentUser_model();
        $this->TournamentMaster_model = new TournamentMaster_model();
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
        $User_Master = $this->UserMaster_model->insertViratualUser((object)$data);

        $data['verify_token'] = $verify_token;
        $display_data = ['status_code'=>200
                        ,'message'=>'user_created_successfully'
                        ,'data'=>$data];
        return response()->json($display_data,200);

    }
   
    public function registerInvite(Request $request){
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
            ],
            'expected_role_id' => [
                'required',
                'numeric',
                'min:1'
            ],
            'add_prifix' => [
                'required',
                'max:191',
                'in:tournament,team,player'
            ],
                'prifix_id' => [
                'required',
                'numeric',
                'min:1',
                'exists:roles,id'
            ],
                'org_id' => [
                'required',
                'numeric',
                'min:1',
                'exists:organization_masters,id'
            ]
        ]);
        if($validator->fails()){
            return Response::json([
                                    'message'=>$validator->errors()->all(),
                                    'status_code'=>403
                                ],403);
        }
        $user = JWTAuth::parseToken()->authenticate();
        $data = array(
                        'username'=>$request->username,
                        'phone'=>$request->phone,
                        'email'=>$request->email,
                        'password'=>$request->password,
                        'expected_role_id'=>$request->expected_role_id,
                        'created_by'=>$user->organization_master_id,
                        'add_prifix'=>$request->add_prifix,
                        'prifix_id'=>$request->prifix_id,
                        'org_id'=>$request->org_id,
                    );

        $verify_token =$this->SendMailAndOtpServices->sendVerifyNotify($data['email'],$data['phone']);

        $vuser_data = $this->UserMaster_model->getVirtualUserDetail($data);
        if($vuser_data){
            $this->UserMaster_model->deleteVUser($vuser_data->id);
        }
        $User_Master = $this->UserMaster_model->insertViratualUser((object)$data);

        $data['verify_token'] = $verify_token;
        $display_data = ['status_code'=>200
                        ,'message'=>'user_created_successfully'
                        ,'data'=>$data];
        return response()->json($display_data,200);

    }
    
    private function __register($request){
        $data = array(
                        'username'=>$request->username,
                        'phone'=>$request->phone,
                        'email'=>$request->email,
                        'password'=>$request->password,
                    );

        // $this->SendMailAndOtpServices->sendVerifyNotify($data['email'],$data['phone']);
        
        $User_Master = $this->UserMaster_model->insert($data);
        if(isset($request->org_id) && $request->org_id > 0){
            $Org_id = $request->org_id;
        }else{
            $Org_id = 0;
        }
        $OrgData = [
            'um_id'=>$User_Master->id,
            'email'=>$data['email'],
            'organization_master_id' => $Org_id,
            'password'=>$data['password']
        ];
        $user_orgId = $this->UserOrganisation_model->insert($OrgData);
        
        
        //if role exists in request then directly added.
        if(isset($request->expected_role_id) && $request->expected_role_id > 0){
            $normal_user = $request->expected_role_id;
            if($request->add_prifix == "tournament"){
                $tournament = new \stdClass();
                $tournament->user_id = $User_Master->id;
                $tournament->tour_id = $request->prifix_id;
//                $tournament->$tournament->add([ 'user_id' => $User_Master->id,'tour_id' => $request->prifix_id ]);
//                $dd($request);
//                $validator = Validator::make($tournament,[
//                    'user_id'=>'required|exists:user_masters,id|numeric|digits_between: 1,7',
//                    'tour_id'=>'required|exists:tournament_master,id|numeric|digits_between: 1,7',
//                ]);
//                if($validator->fails()){
                if(false){
                    $response = ['message'=>$validates->errors()->all(),'status_code'=>403];
                    return Response::json($response,$response['status_code']);
                }else{
                    $tour_org = array('id'=>$tournament->tour_id,'organization_master_id'=>$request->org_id);
                    $check_tour_with_orgId = $this->TournamentMaster_model->allCondtion($tour_org);
                    if(!count($check_tour_with_orgId)){
                        $response = ['message'=>'TourId is From Different Organiztion','status_code'=>403];
                        return Response::json($response,$response['status_code']);
                    }
                    $user_tour = array('user_id'=>$tournament->user_id,'tour_id'=>$tournament->tour_id);
                    $check_tour_with_user = $this->TournamentUser_model->allCondtion($user_tour);
                    if(count($check_tour_with_user)){
                        $response = ['message'=>'User is Already in Tournament','status_code'=>403];
                        return Response::json($response,$response['status_code']);
                    }
                    $insert_data = $this->TournamentUser_model->insertUserTour($user_tour);
                    if($insert_data){
                        $response = ['message'=>'inserted_successfully','status_code'=>200];
                    }else{
                        $response = ['message'=>'failed_to_insert_data','status_code'=>403];
                    }
                    return Response::json($response,$response['status_code']);
                }
            }else if($request->add_prifix == "team"){
                
            }else if($request->add_prifix == "player"){
                
            }
        }else{
            $user_role = $this->Role_model->getPlayerId();
            $normal_user = $user_role->id;
        }
        
        

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
            $objData['username']=$user_mobile_email->username;
            $objData['phone']= $user_mobile_email->phone;
            $objData['email']= $user_mobile_email->email;
            $objData['password']= $user_mobile_email->password;
            
            $objData['expected_role_id']= $user_mobile_email->expected_role_id;
            $objData['created_by']= $user_mobile_email->created_by;
            $objData['add_prifix']= $user_mobile_email->add_prifix;
            $objData['prifix_id']= $user_mobile_email->prifix_id;
            $objData['prifix_id']= $user_mobile_email->prifix_id;
            $objData['org_id']= $user_mobile_email->org_id;
            
            $this->__register((object)$objData);
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
            return Response::json([
                                        'message'=>'successfuly_changed_password.',
                                        'status_code'=>200
                                ],200);
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

    public function getUserInfoById(Request $request){
        $validator = Validator::make($request->all(), [
            'user_master_id' => 'required|exists:user_masters,id|numeric|digits_between:1,7'
        ]);
        if($validator->fails()){
            return Response::json([
                                    'message'=>$validator->errors()->all(),
                                    'status_code'=>403
                                ],403);
        }
        $user_data = $this->_getUserInfo($request->user_master_id);
        return response()->json([
                                    'message'=>'successfu.',
                                    'status_code'=>200,
                                    'data'=>$user_data
                                ],200);
    }

    public function getUserInfo(){
        $user = JWTAuth::parseToken()->authenticate();
        $user_data = $this->_getUserInfo($user->user_master_id);
        return response()->json([
                                    'message'=>'successfu.',
                                    'status_code'=>200,
                                    'data'=>$user_data
                                ],200);
    }

    private function _getUserInfo($user_master_id){
        $user_details = $this->UserOrganisation_model->getUserDetail($user_master_id);
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
        return $user_data;
        
    }

    public function verifyUserToken(Request $request){
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
    
    public function activeUser(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:user_masters,id|digits_between: 1,7',
            'status' => 'required|digits:1|in:0,1',
        ]);

        if($validator->fails()){
            return Response::json([
                    'message' => $validator->errors()->all(),
                    'status_code' => 403
                    ],403);
        }

        $User_org = $this->UserOrganisation_model->getIdByUserId($request->id);
        $where_data = array('id'=>$User_org->id);
        $update_datas = array('status'=>$request->status);
        $update_status = $this->UserOrganisation_model->updateUserOrg($where_data,$update_datas);
        if($update_status){
            return Response::json(['status_code' => 200 ,'message' => 'success'],200);
        }
        return Response::json(['status_code' => 403 ,'message' => 'failed'],403);
    }

} 