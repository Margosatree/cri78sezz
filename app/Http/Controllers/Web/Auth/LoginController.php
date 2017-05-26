<?php

namespace App\Http\Controllers\Web\Auth;
use Session;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User_Cricket_Profile;
use DB;
class LoginController extends Controller
{

    use AuthenticatesUsers;

//    protected $redirectTo = '/home';
    protected function redirectTo(){

        if (Auth::check())
        {
            $Cri_Profile = User_Cricket_Profile::selectRaw('*')->where('user_master_id',Auth::user()->user_master_id)->get()->first();
            if($Cri_Profile){
                Session::put('user_img', $Cri_Profile->display_img);
            }

            $id = Auth::user()->id;
            $check_roles = DB::table('role_user')
                ->select('*')
                ->leftJoin('roles','roles.id','=','role_user.role_id')
                ->where('role_user.user_id', '=', $id)
                ->get();
                // dd($check_roles);
            foreach($check_roles as $check_role){
                if($check_role->is_admin == 0){


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
                if($check_role->is_admin == 0){
                    if(isset($perms)){
                        $arr_perms = array_unique($perms);
                        Session::put('perms',$arr_perms);
                    }
                   return '/home';
                }else{
                    Auth::logout();
                    Session::flush();
                    return '/login';
                }
            }

        }
        //return '/home';
    }

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

}
