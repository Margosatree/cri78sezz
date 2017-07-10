<?php

namespace App\Http\Controllers\Api\V1\Users\Acl;

use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Permission_model;
use App\Model\Role_model;
use Validator;

class PermissionControllerApi extends Controller
{

    protected $Permission_model;
    protected $Role_model;

    public function __construct(){
        $this->Permission_model = new Permission_model();
        $this->Role_model = new Role_model();
    }

    public function addPerm(Request $request){
        $validates = Validator::make($request->all(),[
            'perm_name'=>'required|string|min:5|max:50|unique:permissions,name',
            'desc'=>'string|min:5|max:100'
            ]);

        if($validates->fails()){
            $response = [
                        'message'=>$validates->errors()->all(),
                        'status_code'=>403
                        ];
            return Response::json($response,$response['status_code']);
        }
        $request->request->add(['slug' => strtolower($request->perm_name)]);
        $inserted_data = $this->Permission_model->insert($request);
        if($inserted_data){
            $response = [
                        'message'=>'inserted_successfully',
                        'status_code'=>200
                        ];
            return Response::json($response,$response['status_code']);
        }
    }


    public function editPerm(Request $request){
        $validates = Validator::make($request->all(),[
            'perm_id'=>'required|exists:permissions,id|numeric|digits_between: 1,7',
            'perm_name'=>'required|string|min:5|max:50|unique:permissions,name',
            'desc'=>'string|min:5|max:100'
            ]);

        if($validates->fails()){
            $response = [
                        'message'=>$validates->errors()->all(),
                        'status_code'=>403
                        ];
            return Response::json($response,$response['status_code']);
        }

        $update_data = array();
        if(isset($request->perm_id) && $request->perm_id){
            $update_data['name'] = $request->perm_name;
            $update_data['slug'] = strtolower($request->perm_name);
        }
        if(isset($request->is_admin) && $request->is_admin){
            $update_data['is_admin'] = $request->is_admin;
        }
        if(isset($request->desc) && $request->desc){
            $update_data['description'] = $request->desc;
        }

        if(!count($update_data)){
            $response = [
                        'message'=>'please_provide_atleast_one_data_to_update',
                        'status_code'=>403
                        ];
            return Response::json($response,$response['status_code']);
        }

        $perm_data = array('permission_id'=>$request->perm_id);
        $check_perm_assign = $this->Permission_model->checkPerm($perm_data);
        if(count($check_perm_assign)){
            $response = [
                        'message'=>'Please_Remove_perm_assign_to_role_from_PermRole_table',
                        'status_code'=>403
                        ];
            return Response::json($response,$response['status_code']);
        }
        

        $perm_id = array('id'=>$request->perm_id);

        $update = $this->Permission_model->updatePerm($perm_id,$update_data);
        if($update){
            $response = [
                        'message'=>'updated_successfully',
                        'status_code'=>200
                        ];
            return Response::json($response,$response['status_code']);
        }
    }


    public function deletePerm(Request $request){
        $validates = Validator::make($request->all(),[
            'perm_id'=>'required|exists:permissions,id|numeric|digits_between: 1,7'
            ]);

        if($validates->fails()){
            $response = [
                        'message'=>$validates->errors()->all(),
                        'status_code'=>403
                        ];
            return Response::json($response,$response['status_code']);
        }

        $perm_data = array('permission_id'=>$request->perm_id);
        $check_perm_assign = $this->Permission_model->checkPerm($perm_data);
        if(count($check_perm_assign)){
            $response = [
                        'message'=>'Please_Remove_perm_assign_to_role_from_PermRole_table',
                        'status_code'=>403
                        ];
            return Response::json($response,$response['status_code']);
        }


        $delete = $this->Permission_model->deletePerm($request->perm_id);
        if($delete){
            $response = [
                        'message'=>'deleted_successfully',
                        'status_code'=>200
                        ];
            return Response::json($response,$response['status_code']);
        }

    }


     public function listPerm(Request $request){
        $validates = Validator::make($request->all(),[
            'perm_id'=>'exists:roles,id|numeric|digits_between: 1,7'
            ]);

        if($validates->fails()){
            $response = [
                        'message'=>$validates->errors()->all(),
                        'status_code'=>403
                        ];
            return Response::json($response,$response['status_code']);
        }

        $list = $this->Permission_model->getAll();
        if($list){
            $response = [
                        'message'=>'success',
                        'status_code'=>200,
                        'data'=>$list
                        ];
            return Response::json($response,$response['status_code']);
        }
    }

    public function addPermToUser(Request $request){
        $validates = Validator::make($request->all(),[
            'role_id'=>'required|exists:roles,id|numeric|digits_between: 1,7',
            'permission_id'=>'required|exists:permissions,id|numeric|digits_between: 1,7'
            ]);

        if($validates->fails()){
            $response = [
                        'message'=>$validates->errors()->all(),
                        'status_code'=>403
                        ];
            return Response::json($response,$response['status_code']);
        }

        $where_data = array('role_id'=>$request->role_id,
                            'permission_id'=>$request->permission_id);

        $is_exists = $this->Permission_model->checkPerm($where_data);

        if(count($is_exists)){
            $response = [
                        'message'=>'already_exists_data_in_table',
                        'status_code'=>403
                        ];
            return Response::json($response,$response['status_code']);
        }

         $inserted_data = $this->Role_model->findByIdForPermission($request->role_id,$request->permission_id);

        if($inserted_data){
            $response = [
                        'message'=>'inserted_successfully',
                        'status_code'=>200
                        ];
            return Response::json($response,$response['status_code']);
        }
    }

    public function removePermToRole(Request $request){
        $validates = Validator::make($request->all(),[
            'id'=>'required|exists:permission_role,id|numeric|digits_between: 1,7'
            ]);

        if($validates->fails()){
            $response = [
                        'message'=>$validates->errors()->all(),
                        'status_code'=>403
                        ];
            return Response::json($response,$response['status_code']);
        }

        $removed_data = $this->Permission_model->deletePermAssignRole($request->id);
        if($removed_data){
            $response = [
                        'message'=>'deleted_successfully',
                        'status_code'=>200
                        ];
            return Response::json($response,$response['status_code']);
        }
    }


    public function listRoleWithPerm(){
        $role_ids = $this->Permission_model->getUserId();

        $display_data = array();
        if(count($role_ids)){

            foreach($role_ids as $role_id){
                $user_data = array();

                $role_name = $this->Role_model->findById($role_id->role_id);
                $user_data['role_id']=$role_id->role_id;
                $user_data['role_name'] = $role_name->first()->name;

                $perm_ids = $this->Permission_model->checkPerm(['role_id'=>$role_id->role_id]);

                $perms = array();
                foreach($perm_ids as $perm_id){
                   $perm =  $this->Permission_model->findById($perm_id->permission_id);
                   $perms[]=$perm;
                }
                $user_data['user_perm']=$perms;
                $display_data[]=$user_data; 
            }

        }
        $response = [
                    'message'=>'success',
                    'status_code'=>200,
                    'data'=>$display_data
                    ];
        return Response::json($response,$response['status_code']);

    } 

}