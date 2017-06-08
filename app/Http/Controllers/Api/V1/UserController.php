<?php
namespace App\Http\Controllers\Api\V1;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use JWTAuthException;
use Validator;
use App\Model\UserOrganisation_model;
use App\Model\UserMaster_model;
use App\Model\VerifyUser_model;
use App\Model\Role_model;
use App\Model\RoleUser_model;

class UserController extends Controller
{   

    //call model class via object

    protected $UserMaster_model;
    protected $UserOrganisation_model;
    protected $VerifyUser_model;
    protected $Role_model;
    protected $RoleUser_model;

    public function __construct(){
        $this->UserMaster_model=new UserMaster_model();
        $this->UserOrganisation_model=new UserOrganisation_model();
        $this->VerifyUser_model=new VerifyUser_model();
        $this->Role_model=new Role_model();
        $this->RoleUser_model=new RoleUser_model();
    }
   
    public function register(Request $request){
        // dd($request);
        $data = array(
                        'username'=>$request->username,
                        'phone'=>$request->phone,
                        'email'=>$request->email,
                        'password'=>$request->password,
                    );
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

    public function getAuthUser1(){
        $user = JWTAuth::parseToken()->authenticate();

        return response()->json(['result' => $user]);
    }
} 