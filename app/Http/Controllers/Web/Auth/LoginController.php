<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Auth;
use Session;
use App\Model\UserCricketProfile_model;
use App\Model\Permission_model;
use App\Model\RoleUser_model;

class LoginController extends Controller
{

    
    use AuthenticatesUsers;

//    protected $redirectTo = '/home';

    protected $UserCricketProfile_model;
    protected $Permission_model;
    protected $RoleUser_model;

    protected function _initModel(){
        $this->UserCricketProfile_model = new UserCricketProfile_model;
        $this->Permission_model = new Permission_model;
        $this->RoleUser_model = new RoleUser_model;
    }

    protected function redirectTo(){

        if (Auth::check())
        {
            $this->_initModel();
            $usermaster_id = Auth::user()->user_master_id;
            $Cri_Profile = $this->UserCricketProfile_model
                                ->getCriProfileByUserMasterId($usermaster_id);
            if($Cri_Profile){
                Session::put('user_img', $Cri_Profile->display_img);
            }

            $id = Auth::user()->id;
            $check_roles = $this->RoleUser_model->getRoleById($id);
            foreach($check_roles as $check_role){
                if($check_role->is_admin == 0){


                $permissions = $this->Permission_model->getPermissionByRole($check_role->role_id);
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
