<?php

namespace App\Http\Controllers\Api\V1\Other;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use DB;
use Validator;
class HomeControllerApi extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function display(){
        return view('adminhome');
    }
    
    public function test()
    {
        // $id = Auth::user()->id;
        // // dd($id);
        // $check_roles = DB::table('role_user')
        //     ->select('*')
        //     ->leftJoin('roles','roles.id','=','role_user.role_id')
        //     ->where('role_user.user_id', '=', $id)
        //     ->get();
        // // dd($check_roles);

        // foreach($check_roles as $check_role){
        //     if($check_role->is_admin == 1){
                
        //     $permissions = DB::table('permission_role')
        //             ->select('*')
        //             ->leftJoin('permissions','permissions.id','=','permission_role.permission_id')
        //             ->where('permission_role.role_id', '=', $check_role->role_id)
        //             ->get();
        //         foreach($permissions as $permission){
        //             $perm = $permission->slug;
        //             $perms[]=$perm;
        //         }
        //     }
        // }
        // dd(array_unique($perms));
        // $data = UserMaster_model::getAll(); 
        // return response()->json($data);

    }

}
