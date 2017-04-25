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
//        $email = $data['email'];
//        
//        $password = $data['password'];
//        dd($data);
        return Validator::make($data, [
            'username' => 'required|max:50|alpha',
            'first_name' => 'required|max:50|alpha',
            'middle_name' => 'required|max:50|alpha',
            'last_name' => 'required|max:50|alpha',
            'date_of_birth' => 'required|date|before:'.date('Y-m-d', strtotime('-5 year')),
            'gender' => 'in:female,male',
            'physically_challenged' => 'in:no,yes',
            'phone' => 'required|min:10|numeric',
//            'email' => 'required|email|unique:user_masters|regex:',
            'email' => [
                'required',
                'email',
                'unique:user_masters',
                'regex:/\A[a-z0-9]+([-._][a-z0-9]+)*@([a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,4}\z/',
                'regex:/^(?=.{1,64}@.{4,64}$)(?=.{6,100}$).*/',
            ],
            'password' => [
                'required',
                'confirmed',
                'regex:/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/',
            ]
        ]);
//        
//        $validator->after(function($validator){
//            dd($request()->all());
//            dd('hu sevak tu swami');
//            if(preg_match('/\A[a-z0-9]+([-._][a-z0-9]+)*@([a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,4}\z/', $email)
//                && preg_match('/^(?=.{1,64}@.{4,64}$)(?=.{6,100}$).*/', $email)){
//                echo 'Valid '.$email;
//            }else{
//                echo 'Invalid '.$email;
//            }
//            if(preg_match('/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/',$password)){
//                echo 'Valid '.$password;
//            }else{
//                echo 'Invalid '.$password;
//            }
//        });
//
//        if ($validator->fails()){
//            // Handle errors
//        }
//        dd($email.' '.$password);
//        return $validator;
    }
    
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data){
        $User_master = new User_Master;
        $User_master->username = $data['username'];
        $User_master->first_name = $data['first_name'];
        $User_master->middle_name = $data['middle_name'];
        $User_master->last_name = $data['last_name'];
        $User_master->date_of_birth = $data['date_of_birth'];
        $User_master->gender = $data['gender'];
        $User_master->physically_challenged = $data['physically_challenged'];
        $User_master->phone = $data['phone'];
        $User_master->email = $data['email'];
        $User_master->save();
        
        if($data['is_organisation'] == 2){
            $this->redirectTo = '/org/create';
        }else{
            $this->redirectTo = '/verify/create';
        }
        
        return User_Organisation::create([
            'user_master_id' => $User_master->id,
            'organization_master_id' => 0,
            'email' => $User_master->email,
            'password' => bcrypt($data['password']),
            'role' => $data['is_organisation'],
        ]);

    }
    
}
