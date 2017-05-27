<?php

namespace App\Http\Controllers\Web\Users\Admin;

use Auth;
use Session;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Model\Permission_model;
use App\Model\RoleUser_model;

class AdminLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $Permission_model;
    protected $RoleUser_model;

    protected function _initModel(){
        $this->Permission_model = new Permission_model;
        $this->RoleUser_model = new RoleUser_model;
    }

    //protected $redirectTo = '/admin/home';
    protected $guard = 'admin';
    protected function redirectTo(){

        if (Auth::guard('admin')->check())
        {
            $this->_initModel();
            $id = Auth::guard($this->guard)->user()->id;
            $check_roles = $this->RoleUser_model->getRoleById($id);
            $is_admin = 0;
            $perms = array();
            foreach($check_roles as $check_role){
                if($check_role->is_admin == 1){
                    $is_admin = 1;
                    
                $permissions = $this->Permission_model->getPermissionByRole($check_role->role_id);
                    foreach($permissions as $permission){
                        $perm = $permission->slug;
                        $perms[]=$perm;
                    }
                }
            }

            if(!$is_admin) {
               return '/admin/login';
            }
            
            Session::put('perms',array_unique($perms));

            return '/admin/home';
        }
    }
    

    public function __construct()
    {
        $this->middleware('guest:admin', ['except' => 'logout']);
    }

    public function showLoginForm() {
        return view('admin.adminlogin');
    }

    protected function guard(){
        return Auth::guard($this->guard);
    }
}
