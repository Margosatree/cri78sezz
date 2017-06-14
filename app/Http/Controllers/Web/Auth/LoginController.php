<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Auth;
use Session;
use App\Model\UserCricketProfile_model;
use App\Model\RoleUser_model;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $UserCricketProfile_model;
    protected $RoleUser_model;

    protected function redirectTo(){

        if (Auth::check())
        {
            $this->UserCricketProfile_model = new UserCricketProfile_model;
            $usermaster_id = Auth::user()->user_master_id;
            $Cri_Profile = $this->UserCricketProfile_model
                                ->getCriProfileByUserMasterId($usermaster_id);
            if($Cri_Profile){
                Session::put('user_img', $Cri_Profile->display_img);
            }

            $this->RoleUser_model = new RoleUser_model;
            $id = Auth::user()->id;
            $get_perms = $this->RoleUser_model->getPermissionsByUserId($id);

            if(is_null($get_perms)) {
              Auth::logout();
              Session::flush();
              return '/login';
            }
            Session::put('perms',array_unique($get_perms));
            return '/home';
        }
    }

    public function __construct()
    {
        $this->middleware('guest', ['only' =>['showLoginForm','login']
                      ,'except' => ['logout','showAdminLoginForm','adminLogin']]);
        $this->middleware('guest:admin', ['only' =>['showAdminLoginForm','adminLogin']
                                          ,'except' =>['logout','showLoginForm','login']]);
    }

    public function showAdminLoginForm() {
        return view('admin.adminlogin');
    }


    public function adminLogin(Request $request)
   {
       $this->validate($request, [
           'email' => 'required|email',
           'password' => 'required',
       ]);
       if (auth()->guard('admin')->attempt(['email' => $request->input('email'), 'password' => $request->input('password')]))
       {
         $this->RoleUser_model = new RoleUser_model;
         $id = Auth::guard('admin')->user()->id;
         $is_admin = 1;
         $get_perms = $this->RoleUser_model->getPermissionsByUserId($id,$is_admin);

         if(is_null($get_perms)) {
             return redirect()->to('/admin/login');
         }
           Session::put('perms',array_unique($get_perms));
            return  redirect()->intended('/admin/home');
       }else{
           return back()->with('error','your username and password are wrong.');
       }
   }


}
