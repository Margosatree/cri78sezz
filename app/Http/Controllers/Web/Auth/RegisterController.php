<?php

namespace App\Http\Controllers\Web\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Model\UserOrganisation_model;
use App\Model\UserMaster_model;
use App\Model\VerifyUser_model;
use App\Model\Role_model;
use App\Model\RoleUser_model;

use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Mail\VerifyUser;
use Illuminate\Support\Facades\Mail;

use App\Services\V1\SendMailAndOtpServices;

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

    protected $SendMailAndOtpServices;


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
        $this->SendMailAndOtpServices = new SendMailAndOtpServices();
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

        $token = $this->SendMailAndOtpServices
                        ->sendVerifyNotify($data['email'],$data['phone']);

        $User_Master = $this->UserMaster_model->insert($data);

        $this->redirectTo = '/verify/'.$token;
        $OrgData = ['um_id'=>$User_Master->id,'email'=>$data['email'],
                    'organization_master_id' => 0,'password'=>$data['password']];
        $user_orgId = $this->UserOrganisation_model->insert($OrgData);

        $user_role = $this->Role_model->getPlayerId();
        $normal_user = $user_role->id;

        $user_role = $this->RoleUser_model->insert($user_orgId->id,$normal_user);
        return $user_orgId;

    }
}
