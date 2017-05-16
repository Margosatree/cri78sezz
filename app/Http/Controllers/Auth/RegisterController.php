<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\User_Organisation;
use App\User_Master;
use Illuminate\Support\Facades\Auth;
use App\UserOrganisation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Mail\VerifyUser;
use Illuminate\Support\Facades\Mail;
use App\verify_user;
use App\role_user;
use PHPZen\LaravelRbac\Model\Role;

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


        //This is Verify Logic

        $User_master = new User_Master;
        $User_master->username = $data['username'];
        $User_master->phone = $data['phone'];
        $User_master->email = $data['email'];
        $User_master->save();

        $status_email = $this->sendEmail($data['email']);
        $status_sms = $this->sendSms($data['phone']);

        $this->redirectTo = '/verify/'.$status_email;
        
        $user_orgId = User_Organisation::create([
            'user_master_id' => $User_master->id,
            'organization_master_id' => 0,
            'email' => $User_master->email,
            'password' => bcrypt($data['password']),
            'role' => config('constants.role.User'),
        ]);

        $user_role = Role::where('slug','player')->first();
        $normal_user = $user_role->id;

        $user_role = new role_user;
        $user_role->user_id = $user_orgId->id;
        $user_role->role_id = $normal_user;
        $user_role->save();
        return $user_orgId;

    }


    function sendEmail($user_email){
        $random_num = mt_rand(100000,999999);
        while(true){
            $check_otp = verify_user::where('email_otp',$random_num)
                                       ->get();                            
            if(!count($check_otp)){
                break;
            }
            $random_num = mt_rand(100000,999999);
        }
        // dd($user_email);
        $token_data = str_random(32);
        // dd($token_data);
        if(!empty($user_email)){
            // dd($user_email);
            $check_email = User_Master::where('email',$user_email)->get();
            if(count($check_email)){
                // dd($check_email);
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

        $check_dup_email = verify_user::where('email',$data['email'])
                                            ->get();
        if(count($check_dup_email)){
            verify_user::where('email', $data['email'])
                        ->update(['token' => $data['token'],
                            'email_otp'=>$data['email_otp']]); 
        }else{
            verify_user::create($data);
        }
    }


    function sendSms($mobile_no){

        $check_mobile = verify_user::where('mobile',$mobile_no)
                                       ->get();
        if(count($check_mobile)){
            verify_user::where('mobile',$mobile_no)->delete();
        }
        $random_num = mt_rand(100000,999999);
        while(true){
            $check_otp = verify_user::where('mobile_otp',$random_num)
                                       ->get();                            
            if(!count($check_otp)){
                break;
            }
            $random_num = mt_rand(100000,999999);
        }
        // dd($random_num);
        // dd($mobile_no);

        if(!empty($mobile_no)){
            $check_umobile = User_Master::where('phone',$mobile_no)->get();
            if(count($check_umobile)){
                foreach($check_umobile as $check_um){
                    $email = $check_um->email;
                }
                $check_email = verify_user::where('email',$email)
                                       ->get();
                //Sms logic insert here
                if(count($check_email)){
                    verify_user::where('email', $email)
                        ->update(['mobile' => $mobile_no,'mobile_otp'=>$random_num]);
                }else{
                verify_user::create(['mobile'=>$mobile_no,'mobile_otp'=>$random_num]);
                }
                return 1;
            }else{
                return 0;
            }
        }
    }
    
}
