<?php

namespace App\Http\Controllers\Auth;
use Session;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User_Cricket_Profile;
class LoginController extends Controller
{

    use AuthenticatesUsers;

//    protected $redirectTo = '/home';
    protected function redirectTo(){
        $Cri_Profile = User_Cricket_Profile::selectRaw('*')->where('user_master_id',Auth::user()->user_master_id)->get()->first();
        if($Cri_Profile){
            Session::put('user_img', $Cri_Profile->display_img);
        }
        return '/home';
    }

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
}
