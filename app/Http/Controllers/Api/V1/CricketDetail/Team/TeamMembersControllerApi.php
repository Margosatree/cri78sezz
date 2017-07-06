<?php

namespace App\Http\Controllers\Api\V1\CricketDetail\Team;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use Validator;
use App\Model\TeamMembers_model;
use App\Model\TournamentDetails_model;
//use App\Model\UserOrganisation_model;

class TeamMembersControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $TeamMembers_model;
    protected $TournamentDetails_model;

    public function __construct(){
        $this->_initModel();
    }

    protected function _initModel(){
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
                'user_master_id' => $request->user_master_id
            ]);
            if($Team_Members_Count < $Rule_Max_Player_Count){
                $Team_Member_Exists = $this->TeamMembers_model->getWhereQuery([
                    'tournament_id' => $request->tournament_id,
                    'user_master_id' => $request->user_master_id
                ]);
                if(!$Team_Member_Exists){
                    $Team = $this->TeamMembers_model->SaveTeamMembers($request);
                    if($Team){
                        $output = array('status' => 200 ,'msg' => 'Sucess','data' => $Team);
                    }else{
                        $output = array('status' => 400 ,'msg' => 'Transection Fail');
                    }
                }else{
                    $output = array('status' => 400 ,'msg' => 'Member Already Exists In Other Team');
                }
            }else{
                $output = array('status' => 400 ,'msg' => 'Team Member Limit Reached');
            }
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail','errors' => $validator->errors()->all());
        }
        return response()->json($output);
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

        $request->request->add(['update' => 1]);

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
        if($team_members)
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
}
