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

//    protected function redirectTo()
//    {
//        $data = User_Master::find(Auth::user()->user_master_id);
//        dd($data);
//        $data->username->first();
//        $user_data = array('username' => $data->username->first());
//        dd($user_data);
//        return '/verify';
//        return view('/verify',$user_data)->url()->compact();
//        if(Auth::user()->role == 2){
//            return redirect()->route('verify.create');
//        }else if(Auth::user()->role == 3){
//            return redirect()->route('org.create');
//        }
//        return redirect()->to('/post/'.$id);
//    }
    
    
    
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
            'username' => 'required|max:255',
            'first_name' => 'required|max:255',
            'middle_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'date_of_birth' => 'date',
            'gender' => 'in:female,male,others',
            'physically_challenged' => 'in:no,yes',
            'phone' => 'required|min:10|numeric',
            'email' => 'required|email|unique:user_masters',
            'password' => 'required|confirmed'
        ]);
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
        
        return User_Organisation::create([
            'user_master_id' => $User_master->id,
            'organization_master_id' => 0,
            'email' => $User_master->email,
            'password' => bcrypt($data['password']),
            'role' => $data['is_organisation'],
        ]);

    }
    
}
