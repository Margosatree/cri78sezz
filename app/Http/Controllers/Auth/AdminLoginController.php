<?php

namespace App\Http\Controllers\Auth;
use Auth;
use Session;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AdminLoginController extends Controller
{
    use AuthenticatesUsers;

    //protected $redirectTo = '/admin/home';
    protected $guard = 'admin';
    protected function redirectTo(){
        if (Auth::guard('admin')->check())
        {
            $id = Auth::guard($this->guard)->user()->id;
            $check_roles = DB::table('role_user')
                ->select('*')
                ->leftJoin('roles','roles.id','=','role_user.role_id')
                ->where('role_user.user_id', '=', $id)
                ->get();

            foreach($check_roles as $check_role){
                if($check_role->is_admin == 1){
                    
                $permissions = DB::table('permission_role')
                        ->select('*')
                        ->leftJoin('permissions','permissions.id','=','permission_role.permission_id')
                        ->where('permission_role.role_id', '=', $check_role->role_id)
                        ->get();
                    foreach($permissions as $permission){
                        $perm = $permission->slug;
                        $perms[]=$perm;
                    }
                }
            }
            foreach($check_roles as $check_role){
                if($check_role->is_admin == 1){
                    $arr_perms = array_unique($perms);
                    Session::put('perms',$arr_perms);
                   return '/admin/home'; 
                }else{
                    return '/admin/login';
                }
            } 
            
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
