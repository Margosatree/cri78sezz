<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\User_Organisation;
//use App\User_Master;
use App\Model\UserMaster_model;
use Illuminate\Support\Facades\Auth;
//use App\UserOrganisation;
use App\Model\UserOrganisation_model;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Mail\VerifyUser;
use Illuminate\Support\Facades\Mail;
// use App\verify_user;
//use App\role_user;
// use App\Role;
use App\Model\VerifyUser_model;
use App\Model\Role_model;
use App\Model\RoleUser_model;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/verify/create';

    
    
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data){
        
        return Validator::make($data, [
            'username' => 'required|max:50|alpha_num|unique:user_masters',
            'phone' => [
                'required',
                'unique:user_masters',
                'min:10',
                'numeric',
                //'regex:^\(?082|083|084|072\)?[\s-]?[\d]{3}[\s-]?[\d]{4}$',
                'regex:/(7|8|9)\d{9}/'
            ],
            'email' => [
                'required',
                'email',
                'unique:user_masters',
                'regex:/(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@[*[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+]*/',
//                'regex:/\A[a-z0-9]+([-._][a-z0-9]+)*@([a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,4}\z/',
//                'regex:/^(?=.{1,64}@.{4,64}$)(?=.{6,100}$).*/',
            ],
            'password' => [
                'required',
                'confirmed',
                'regex:/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/',
            ]
        ]);

    }
    
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data){

        $User_Master = UserMaster_model::insert($data);

        $status_email = $this->sendEmail($data['email']);
        $status_sms = $this->sendSms($data['phone']);

        $this->redirectTo = '/verify/'.$status_email;
        
        $OrgData = ['um_id'=>$User_master->id,'email'=>$User_master->email,
                    'password'=>$data['password']];
        $user_orgId = UserOrganisation_model::insert($OrgData);

        $user_role = Role_model::getPlayerId();
        $normal_user = $user_role->id;

        $user_role = RoleUser_model::insert($user_orgId->id,$normal_user);
        return $user_orgId;

    }


    function sendEmail($user_email){
        $random_num = mt_rand(100000,999999);
        while(true){
            $check_otp = VerifyUser_model::getEmailOtp($random_num);    
            if(!count($check_otp)){
                break;
            }
            $random_num = mt_rand(100000,999999);
        }
        $token_data = str_random(32);
        if(!empty($user_email)){
            $check_email = UserMaster_model::getValueByEmail($user_email);
            if(count($check_email)){
                Mail::to($user_email)
                  ->send(new VerifyUser($random_num,$token_data));

                $store_data = ['email'=>$user_email,
                                'token'=>$token_data,
                                'email_otp'=>$random_num];
                $this->storeEmail($store_data);
                return $token_data;
            }else{
                return 0;
            }
        }
        
    }

    function storeEmail($data){

        $check_dup_email = VerifyUser_model::getValueByEmail($data['email']);
        if(count($check_dup_email)){
            $updateData =['email'=>$data['email'],'token'=> $data['token']
                        ,'email_otp'=>$data['email_otp']];
            VerifyUser_model::updateByEmail($updateData);
        }else{
            VerifyUser_model::createData($data);
        }
    }


    function sendSms($mobile_no){

        $check_mobile = VerifyUser_model::getValueByEmail($mobile_no);
        if(count($check_mobile)){
            VerifyUser_model::deleteByMobile($mobile_no);
        }
        $random_num = mt_rand(100000,999999);
        while(true){
            $check_otp = VerifyUser_model::checkMobileOtp($random_num);
            if(!count($check_otp)){
                break;
            }
            $random_num = mt_rand(100000,999999);
        }

        if(!empty($mobile_no)){
            $check_umobile = UserMaster_model::getValueByEmail($mobile_no);
            if(count($check_umobile)){
                foreach($check_umobile as $check_um){
                    $email = $check_um->email;
                }
                $check_email = VerifyUser_model::getValueByEmail($email);
                //Sms logic insert here
                $data_send = ['email'=>$email,'mobile' => $mobile_no
                            ,'mobile_otp'=>$random_num];
                if(count($check_email)){
                    VerifyUser_model::updateByMobile($data_send);
                }else{
                    unset($data_send['email']);
                VerifyUser_model::createData($data_send);
                }
                return 1;
            }else{
                return 0;
            }
        }
    }
    
}
