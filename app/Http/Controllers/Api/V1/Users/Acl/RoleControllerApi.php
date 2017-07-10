<?php

namespace App\Http\Controllers\Api\V1\Users\Acl;

use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Role_model;
use App\Model\RoleUser_model;
use App\Model\UserOrganisation_model;
use Validator;

class RoleControllerApi extends Controller
{

    protected $Role_model;

    public function __construct(){
        $this->Role_model = new Role_model();
    }

    public function addRole(Request $request){
        $validates = Validator::make($request->all(),[
            'role_name'=>'required|alpha_dash|min:5|max:15|unique:roles,name',
            'is_admin'=>'digits:1|in:0,1',
            'desc'=>'alpha_numeric|min:5|max:100'
            ]);

        if($validates->fails()){
            $response = [
                        'message'=>$validates->errors()->all(),
                        'status_code'=>403
                        ];
            return Response::json($response,$response['status_code']);
        }

        $inserted_data = $this->Role_model->insert($request);
        if($inserted_data){
            $response = [
                        'message'=>'inserted_successfully',
                        'status_code'=>200
                        ];
            return Response::json($response,$response['status_code']);
        }


    }

    public function addRoleBulk(Request $request){
        $validates = Validator::make($request->all(),[
            ''=>
            ]);

        if($validates->fails()){
            $response = [
                        'message'=>$validates->errors()->all(),
                        'status_code'=>403
                        ];
            return Response::json($response,$response['status_code']);
        }
    }

    public function editRole(Request $request){
        $validates = Validator::make($request->all(),[
            'role_id'=>'required|exists:roles.id|numeric|min:1|max:7',
            'role_name'=>'required|alpha_dash|min:5|max:15|unique:roles,name',
            'is_admin'=>'digits:1|in:0,1',
            'desc'=>'alpha_numeric|min:5|max:100'
            ]);

        if($validates->fails()){
            $response = [
                        'message'=>$validates->errors()->all(),
                        'status_code'=>403
                        ];
            return Response::json($response,$response['status_code']);
        }

        $role_data = array('role_id'=>$request->role_id);
        $check_role_assign = $this->RoleUser_model->checkRole($role_data);
        if(count($check_role_assign)){
            $response = [
                        'message'=>'Please_Remove_role_assign_to_user_from_RoleUser_table',
                        'status_code'=>403
                        ];
            return Response::json($response,$response['status_code']);
        }
        $update_data = array();
        if(isset($request->role_id) && $request->role_id){
            $update_data['name'] = $request->role_name;
            $update_data['slug'] = strtolower($request->role_name);
        }
        if(isset($request->is_admin) && $request->is_admin){
            $update_data['is_admin'] = $request->is_admin;
        }
        if(isset($request->desc) && $request->desc){
            $update_data['description'] = $request->desc;
        }

        if(is_null($update_data)){
            $response = [
                        'message'=>'please_provide_atleast_one_data_to_update',
                        'status_code'=>403
                        ];
            return Response::json($response,$response['status_code']);
        }

        $role_id = array('id'=>$request->role_id);
        $update = $this->Role_model->updateRole($role_id,$update_data);
        if($update){
            $response = [
                        'message'=>'updated_successfully',
                        'status_code'=>200
                        ];
            return Response::json($response,$response['status_code']);
        }
    }

    public function deleteRole(Request $request){
        $validates = Validator::make($request->all(),[
            'role_id'=>'required|exists:roles.id|numeric|min:1|max:7'
            ]);

        if($validates->fails()){
            $response = [
                        'message'=>$validates->errors()->all()
                        'status_code'=>403
                        ];
            return Response::json($response,$response['status_code']);
        }

        $role_data = array('id'=>$request->role_id);
        $check_role_assign = $this->RoleUser_model->checkRole($role_data);
        if(count($check_role_assign)){
            $response = [
                        'message'=>'Please Remove role assign to user from RoleUser table',
                        'status_code'=>403
                        ];
            return Response::json($response,$response['status_code']);
        }


        $delete = $this->Role_model->deleteRole($request->role_id);
        if($delete){
            $response = [
                        'message'=>'deleted_successfully',
                        'status_code'=>200
                        ];
            return Response::json($response,$response['status_code']);
        }

    }

    public function listRole(Request $request){
        $validates = Validator::make($request->all(),[
            'role_id'=>'exists:roles.id|numeric|min:1|max:7'
            ]);

        if($validates->fails()){
            $response = [
                        'message'=>$validates->errors()->all()
                        'status_code'=>403
                        ];
            return Response::json($response,$response['status_code']);
        }

        $list = $this->Role_model->getAll();
        if($list){
            $response = [
                        'message'=>'success',
                        'status_code'=>200
                        'data'=>$list
                        ];
            return Response::json($response,$response['status_code']);
        }
    }


    public function addRoleToUser(Request $request){
        $validates = Validator::make($request->all(),[
            'role_id'=>'required|exists:roles.id|numeric|min:1|max:7',
            'user_id'=>'required|exists:user_organizations.id|numeric|min:1|max:7'
            ]);

        if($validates->fails()){
            $response = [
                        'message'=>$validates->errors()->all()
                        'status_code'=>403
                        ];
            return Response::json($response,$response['status_code']);
        }

        $where_data = array('role_id'=>$request->role_id,
                            'user_id'=>$request->user_id);

        $is_exists = $this->RoleUser_model->checkRole($where_data);

        if(count($is_exists)){
            $response = [
                        'message'=>'already_exists_data_in_table'
                        'status_code'=>403
                        ];
            return Response::json($response,$response['status_code']);
        }

        $inserted_data = $this->RoleUser_model->insert($request);
        if($inserted_data){
            $response = [
                        'message'=>'inserted_successfully',
                        'status_code'=>200
                        ];
            return Response::json($response,$response['status_code']);
        }
    }

    public function removeUserToRole(Request $request){
        $validates = Validator::make($request->all(),[
            'id'=>'required|exists:role_user.id|numeric|min:1|max:7'
            ]);

        if($validates->fails()){
            $response = [
                        'message'=>$validates->errors()->all()
                        'status_code'=>403
                        ];
            return Response::json($response,$response['status_code']);
        }


        $removed_data = $this->RoleUser_model->removeUserToRole($request->id);
        if($removed_data){
            $response = [
                        'message'=>'deleted_successfully',
                        'status_code'=>200
                        ];
            return Response::json($response,$response['status_code']);
        }
    }


    public function listUserWithRole(){
        $user_ids = $this->RoleUser_model->getUserId();

        $display_data = array()
        
        foreach($user_ids as $user_id){
            $user_data = array();

            $user_email = $this->UserOrganisation_model->getById($user_id);
            $user_data['user_id']=$user_id
            $user_data['user_email'] = $user_email->email;

            $role_ids = $this->RoleUser_model->checkRole(['user_id'=>$user_id]);

            $roles = array();
            foreach($role_ids as $role_id){
               $role =  $this->Role_model->findById($role_id);
               $roles[]=$role
            }
            $user_data['user_role']=$roles;
            $display_data[]=$user_data; 
        }

        if(is_null($display_data)){
            $response = [
                        'message'=>'success',
                        'status_code'=>200
                        'data'=>$display_data
                        ];
            return Response::json($response,$response['status_code']);
        }

    }    
}

