<?php

namespace App\Http\Controllers\Web\Users\Admin;

use Auth;
use Session;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Model\RoleUser_model;

class AdminLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $RoleUser_model;

    public function __construct()
    {
        $this->middleware('guest:admin', ['except' => 'logout']);
    }

    //protected $redirectTo = '/admin/home';
    protected $guard = 'admin';
    protected function redirectTo(){

        if (Auth::guard('admin')->check())
        {
            $this->RoleUser_model = new RoleUser_model;
            $id = Auth::guard($this->guard)->user()->id;
            $is_admin = 1;
            $get_perms = $this->RoleUser_model->getPermissionsByUserId($id,$is_admin);

            if(is_null($get_perms)) {
               return '/admin/login';
            }else{
              Session::put('perms',array_unique($get_perms));
              return '/admin/home';
            }
        }
    }

    public function showLoginForm() {
        return view('admin.adminlogin');
    }

    protected function guard(){
        return Auth::guard($this->guard);
    }
}
