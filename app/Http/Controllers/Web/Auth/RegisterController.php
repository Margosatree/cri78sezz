<?php

namespace App\Http\Controllers\Web\Auth;
use Illuminate\Http\Request;
use App\User_Organisation;
use App\Model\UserMaster_model;
use Illuminate\Support\Facades\Auth;
use App\Model\UserOrganisation_model;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Mail\VerifyUser;
use Illuminate\Support\Facades\Mail;
use App\Model\VerifyUser_model;
use App\Model\Role_model;
use App\Model\RoleUser_model;

class RegisterController extends Controller
{
    use RegistersUsers;
    protected $redirectTo = '/verify/create';

    //call model class via object 

    protected $UserMaster_model;
    protected $UserOrganisation_model;
    protected $VerifyUser_model;
    protected $Role_model;
    protected $RoleUser_model;

    public function __construct(){
        $this->_initModel();
        $this->middleware('guest');
    }

    protected function _initModel(){
        $this->UserMaster_model=new UserMaster_model();
        $this->UserOrganisation_model=new UserOrganisation_model();
        $this->VerifyUser_model=new VerifyUser_model();
        $this->Role_model=new Role_model();
        $this->RoleUser_model=new RoleUser_model();
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
        // dd($this->UserMaster_model->getAll());

        $User_Master = $this->UserMaster_model->insert($data);

        $status_email = $this->sendEmail($data['email']);
        $status_sms = $this->sendSms($data['phone']);

        $this->redirectTo = '/verify/'.$status_email;
        
        $OrgData = ['um_id'=>$User_Master->id,'email'=>$data['email'],
                    'organization_master_id' => 0,'password'=>$data['password']];
        $user_orgId = $this->UserOrganisation_model->insert($OrgData);

        $user_role = $this->Role_model->getPlayerId();
        $normal_user = $user_role->id;

        $user_role = $this->RoleUser_model->insert($user_orgId->id,$normal_user);
        return $user_orgId;

    }


    function sendEmail($user_email){
        $random_num = mt_rand(100000,999999);
        while(true){
            $check_otp = $this->VerifyUser_model->getEmailOtp($random_num);    
            if(!count($check_otp)){
                break;
            }
            $random_num = mt_rand(100000,999999);
        }
        $token_data = str_random(32);
        if(!empty($user_email)){
            $check_email = $this->UserMaster_model->getValueByEmail($user_email);
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

        $check_dup_email = $this->VerifyUser_model->getValueByEmail($data['email']);
        if(count($check_dup_email)){
            $updateData =['email'=>$data['email'],'token'=> $data['token']
                        ,'email_otp'=>$data['email_otp']];
            $this->VerifyUser_model->updateByEmail($updateData);
        }else{
            $this->VerifyUser_model->createData($data);
        }
    }


    function sendSms($mobile_no){

        $check_mobile = $this->VerifyUser_model->getValueByEmail($mobile_no);
        if(count($check_mobile)){
            $this->VerifyUser_model->deleteByMobile($mobile_no);
        }
        $random_num = mt_rand(100000,999999);
        while(true){
            $check_otp = $this->VerifyUser_model->checkMobileOtp($random_num);
            if(!count($check_otp)){
                break;
            }
            $random_num = mt_rand(100000,999999);
        }

        if(!empty($mobile_no)){
            $check_umobile = $this->UserMaster_model->getValueByEmail($mobile_no);
            if(count($check_umobile)){
                foreach($check_umobile as $check_um){
                    $email = $check_um->email;
                }
                $check_email = $this->VerifyUser_model->getValueByEmail($email);
                //Sms logic insert here
                $data_send = ['email'=>$email,'mobile' => $mobile_no
                            ,'mobile_otp'=>$random_num];
                if(count($check_email)){
                    $this->VerifyUser_model->updateByMobile($data_send);
                }else{
                    unset($data_send['email']);
                    $this->VerifyUser_model->createData($data_send);
                }
                return 1;
            }else{
                return 0;
            }
        }
    }
    
}
