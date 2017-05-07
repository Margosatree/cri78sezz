<?php

namespace App\Http\Controllers\Auth;
use Session;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User_Cricket_Profile;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
//    protected $redirectTo = '/home';
    protected function redirectTo(){
        $Cri_Profile = User_Cricket_Profile::selectRaw('*')->where('user_master_id',Auth::user()->user_master_id)->get()->first();
        if($Cri_Profile){
            Session::put('user_img', $Cri_Profile->display_img);
        }
        return '/home';
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
        $this->middleware('guest', ['except' => 'logout']);
    }
}
