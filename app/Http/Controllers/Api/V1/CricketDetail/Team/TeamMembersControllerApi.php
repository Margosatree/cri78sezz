<?php

namespace App\Http\Controllers\Api\V1\CricketDetail\Team;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use Validator;
use App\Model\TeamMembers_model;
use App\Model\TournamentDetails_model;
use App\Model\UserMaster_model;
//use App\Model\UserOrganisation_model;

class TeamMembersControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $UserMaster_model;
    protected $TeamMembers_model;
    protected $TournamentDetails_model;

    public function __construct(){
        $this->_initModel();
    }

    protected function _initModel(){
         $this->UserMaster_model = new UserMaster_model();
        $this->TeamMembers_model = new TeamMembers_model();
        $this->TournamentDetails_model = new TournamentDetails_model();
    }
    
    public function listTeamMembers(Request $request){
        
    }
    
    public function addTeamMembers(Request $request){
        $validator = Validator::make($request->all(), [
            'tournament_id' => 'required|numeric',
            'team_id' => 'required|numeric',
            'user_master_id' => 'required|numeric',
            'selected_as' => 'required|max:190'
        ]);
        if(!$validator->fails()){
            $Rule_Max_Player_Count = $this->TournamentDetails_model->getTourDetByIdRuleId($request->tournament_id,7);
            $Team_Members_Count = $this->TeamMembers_model->getCountByWhereQuery([
                'tournament_id' => $request->tournament_id,
                'team_id' => $request->user_master_id
            ]);
            if($Team_Members_Count < $Rule_Max_Player_Count){
                $Team_Member_Exists = $this->TeamMembers_model->getWhereQuery([
                    'tournament_id' => $request->tournament_id,
                    'user_master_id' => $request->user_master_id
                ]);
                if(!$Team_Member_Exists){
                    $Team = $this->TeamMembers_model->SaveTeamMembers($request);
                    if($Team){
                        $output = array('status_code' => 200 ,'message' => 'Sucess','data' => $Team);
                    }else{
                        $output = array('status_code' => 400 ,'message' => 'Transection Fail');
                    }
                }else{
                    $output = array('status_code' => 400 ,'message' => 'Member Already Exists In Other Team');
                }
            }else{
                $output = array('status_code' => 400 ,'message' => 'Team Member Limit Reached');
            }
        }else{
            $output = array('status_code' => 400 ,'message' => 'Transection Fail','errors' => $validator->errors()->all());
        }
        return response()->json($output,$output['status_code']);
    }

    public function updateTeamMembers(Request $request){
        $validator = Validator::make($request->all(), [
            'id'=>'required|numeric|min:1',
            'tournament_id' => 'required|numeric',
            'team_id' => 'required|numeric',
            'user_master_id' => 'required|numeric',
        ]);

        if($validator->fails()){
            return Response::json([
                                    'message'=>$validator->errors()->all(),
                                    'status_code'=>403
                                ],403);
        }

        $check_team = $this->TeamMembers_model->getById($request->id);
        if(!$check_team){
            return Response::json([
                                    'message'=>'team_member_id_does_not_exists',
                                    'status_code'=>404
                                ],404);
        }
        $user = JWTAuth::parseToken()->authenticate();
        $request->request->add(['update' => 1,'updated_by' => $user->user_master_id]);

        $team = $this->TeamMembers_model->SaveTeamMembers($request);
        if($team){
            $response = array('status_code' => 200 
                            ,'message' => 'sucessfully_updated'
                            ,'data' => $team
                            );
        }else{
            $response = array('status_code' => 403 
                            ,'message' => 'transection_fail'
                            );
        }
          
        return response()->json($response,$response['status_code']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteTeamMembers(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|min:1',
        ]);

        if($validator->fails()){
            return Response::json([
                                    'message'=>$validator->errors()->all(),
                                    'status_code'=>403
                                ],403);
        }

        $check_team = $this->TeamMembers_model->getById($request->id);
        if(!$check_team){
            return Response::json([
                                    'message'=>'team_member_id_does_not_exists',
                                    'status_code'=>404
                                ],404);
        }

        $user = JWTAuth::parseToken()->authenticate();
        $request->request->add(['update' => 1,'deleted_by' => $user->user_master_id]);
        $this->TeamMembers_model->SaveTeamMembers($request);
        $delete_team_member = $this->TeamMembers_model->deleteById($request->id);
        if($delete_team_member){
            $response = array('status_code' => 200 
                            ,'message' => 'sucessfully_deleted'
                            );
        }else{
            $response = array('status_code' => 403 
                            ,'message' => 'transection_fail'
                            );
        }
        return response()->json($response,$response['status_code']);
    }

    public function listMyTeamMembers(){
        $user = JWTAuth::parseToken()->authenticate();
        $team_members = $this->TeamMembers_model->listMyTeams($user->user_master_id);
        if($team_members){
            foreach($team_members as $team_member){
                 $user_owner = $this->UserMaster_model->getById($team_member->team_owner_id);
                 $data_arr = array('team_member'=>$team_member);
                 $data_arr['team_member']['first_name']=$user_owner->first_name;
                 $data_arr['team_member']['last_name']=$user_owner->last_name;
            }
        }
        if($team_members){
            $response = array('status' => 200 ,'msg' => 'success','data' => $data_arr);
        }else{
            $response = array('status' => 404 ,'msg' => 'transation_failed');
        }
        return response()->json($response,$response['status']);
    }
    
    public function upload(Request $request){
        $validator = Validator::make($request->all(), [
            'excel' => 'required',
            'mime' => 'required'
        ]);
        if(!$validator->fails()){
//            dd($request->all());
            $excel_B64 = $request->excel;
            $mime_data = $request->mime;
            $rand_str = str_random(10);
            $filename = "Excel"."$rand_str.$mime_data";
            $excel_B64 = base64_decode($excel_B64);
            file_put_contents(public_path('images/'. $filename), $excel_B64);
            $data = Excel::load(public_path('images/'. $filename), function($reader) {
            })->get();
//            })->get()->toArray();
//            echo json_encode($data);die();
            if(!empty($data) && $data->count()){
                $Errors = array();
                $count = 0;
                foreach ($data as $key => $value) {
                    if(isset($value['username']) && isset($value['phone']) && isset($value['email'])){
                        if($value['username'] != ""){
                            if(strlen(''.$value['username']) > 50){
                                $username['lengh'] = 'Username Filed Is Too Long';
                            }
                            if(!ctype_alnum(''.$value['username'])){
                                $username['alpha_num'] = 'Must Be Alphanumeric';
                            }
                            $Username_Exists = $this->UserMaster_model->userExists($value['username']);
                            if($Username_Exists->count){
                                $username['unique'] = 'Username Already Exists';
                            }
                        }else{
                            $username['data'] = 'Data Not Found';
                        }
                        if($value['phone'] != ""){
                            if(!is_numeric($value['phone'])){
                                $phone['numeric'] = 'Should Be A Number';
                            }
                            if(strlen(''.$value['phone']) != 10){
                                $phone['lengh'] = 'Invalid Phone Number';
                            }
                            if(!preg_match('/(7|8|9)\d{9}/', $value['phone'])){
                                $phone['phonenumber'] = 'Phone Number Should Start With 9|8|7';
                            }
                            $Phone_Exists = $this->UserMaster_model->phoneExists($value['phone']);
                            if($Phone_Exists->count){
                                $phone['unique'] = 'Phone Already Exists';
                            }
                        }else{
                            $phone['data'] = 'Data Not Found';
                        }
                        if($value['email'] != ""){
                            if(strlen(''.$value['email']) > 50){
                                $email['lengh'] = 'email Filed Is Too Long';
                            }
                            if(!preg_match('/(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@[*[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+]*/', $value['email'])){
                                $email['email'] = 'Invalid Email';
                            }
                            $email_Exists = $this->UserMaster_model->emailExists($value['email']);
                            if($email_Exists->count){
                                $email['unique'] = 'Email Already Exists';
                            }
                        }else{
                            $email['data'] = 'Data Not Found';
                        }
                        if(isset($username) && count($username) > 0){
                            $User_Data['username'] = $username;
                        }
                        if(isset($phone) && count($phone) > 0){
                            $User_Data['phone'] = $phone;
                        }
                        if(isset($email) && count($email) > 0){
                            $User_Data['email'] = $email;
                        }
                        if(isset($User_Data) && count($User_Data) > 0){
                            $User_Data['u_id'] = $value['id'];
                            $User_Data['u_username'] = $value['username'];
                            $User_Data['u_phone'] = $value['phone'];
                            $User_Data['u_email'] = $value['email'];
                            $Errors[$value['id']] = $User_Data;
                        }
                        if(!isset($username) && !isset($phone) && !isset($email)){
                            $User_Mst_Data['username'] = $value['username'];
                            $User_Mst_Data['phone'] = $value['phone'];
                            $User_Mst_Data['email'] = $value['email'];
//                            dd($User_Mst_Data);
                            $User_master = $this->UserMaster_model->insert($User_Mst_Data);
                            
                            $User_Org_Data = new \stdClass();
                            $User_Org_Data->user_master_id = $User_master->id;
                            $User_Org_Data->organization_master_id = 1;
                            $User_Org_Data->email = $User_master->email;
                            $User_Org_Data->password = $User_master->username.'@123';
                            $User_Org_Data->role = 'user';
                            $User_Org = $this->UserOrganisation_model->SaveUserOrg($User_Org_Data);
                        }else{
                            $count++;
                        }
                    }else{
                        $Errors = array('status' => 400, 'msg' => 'Invalid File Format');
                    }
                }
                if($Errors == null){
                    $Errors['status'] = 200;
                    $Errors['msg'] = 'Sucess';
                }
                return response()->json($Errors);
            }
        }else{
            dd('Invalid');
        }
    }
}
