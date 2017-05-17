<?php

namespace App\Http\Controllers\Acl;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User_Organisation;
use PHPZen\LaravelRbac\Model\Role;
use DB;
// use App\RoleUser;

class RoleUserController extends Controller
{
    
    
    public function __construct(){
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   

        $users = User_Organisation::get();
        // foreach($users as $user){
        // $results = DB::select( DB::raw("select id,name from roles where id not in 
        //                                 (select role_id from role_user 
        //                                     WHERE user_id = :userid)"), 
        //                                     array('userid' => $user->id));
        // $user_info = array('id'=>$user->id,'email'=>$user->email);
        // $results[] = $user_info;
        // $total[] = $results;
        // }
        // dd($total);
        // return view('acl\assign_role', compact($total));
        $users = User_Organisation::all();
        $roles = Role::get();
      //  dd($users);
        return view('acl\assign_role', ['userData' => $users, 'roleData' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(),[
        'user_id' => 'required',
        'role_id' => 'required'        
        ]);

        $user = User_Organisation::find($request->user_id);
        $roleId = $request->role_id;

        $user->roles()->attach($roleId);
        return redirect('/admin/home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function displayRoles()
    {   

        $user_data = User_Organisation::get();
        foreach($user_data as $data){
            $email = $data->email;
            $roles = User_Organisation::find($data->id)->roles()->get();
            if(count($roles)){
                foreach($roles as $role){
                    $data = $role->name;
                    $roleId = $role->pivot->role_id;
                    $userId = $role->pivot->user_id;
                    $arr_data = array('id'=>$roleId,'userId'=>$userId,'role'=>$data,'email'=>$email);
                    $datas[]=$arr_data;
                }
            }else{
                $datas=$roles;
            }
        }
        return view('acl\revoke_role', ['users' => $datas]);
    }
    public function destroy($id,$userId)
    {
       $user = User_Organisation::find($userId);
       $user->roles()->detach($id);
        return redirect('/admin/home');
    }
}