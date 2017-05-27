<?php

namespace App\Http\Controllers\Web\Acl;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Permission_model;
use App\Model\Role_model;
// use App\PermissionRole;
class PermissionRoleController extends Controller
{

    protected $Role_model;
    protected $Permission_model;

    public function __construct(Role_model $role,Permission_model $permission){

        $this->Role_model = $role;
        $this->Permission_model = $permission;

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
        $permissions = $this->Permission_model->getAll();
        $roles = $this->Role_model->getAll();

        return view('acl\assign_permission', ['permissionData' => $permissions, 'roleData' => $roles]);
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
        'role_id' => 'required',
        'permission_id' => 'required'        
        ]);
        
        $this->Role_model->findByIdForPermission($request->role_id,$request->permission_id)
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
    public function displayPermissions(){
        $role_data = $this->Role_model->getAll();
        foreach($role_data as $data){
            $name = $data->name;
            $permissions = $this->Role_model->findPermissionById($data->id);
            if(count($permissions)){
                foreach($permissions as $permission){
                    $data = $permission->name;
                    $permissionId = $permission->pivot->permission_id;
                    $roleId = $permission->pivot->role_id;
                    $arr_data = array('id'=>$permissionId,'roleId'=>$roleId,'permission'=>$data,'name'=>$name);
                    $datas[]=$arr_data;
                }
            }else{
                $datas = $permissions;
            }
        }
        return view('acl\revoke_permission', ['roles' => $datas]);
    }
    public function destroy($id,$roleId)
    {
        $this->Role_model->detachPermission($id,$roleId);
        return redirect('/admin/home');
    }
}