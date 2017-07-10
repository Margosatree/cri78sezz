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
    
    public function listTeam(Request $request){
        $organization_master_id = 1;//have to find user id from login
        $Teams = $this->TeamMaster_model->getTeamDetail($organization_master_id);
        if($Teams){
            $output = array('status' => 200 ,'msg' => 'Sucess','data' => $Teams);
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail');
        }
        return response()->json($output);
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

    public function updateTeam(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|min:1',
            'team_name' => 'required|max:190',
            'team_owner_id' => 'required|numeric',
            'team_type' => 'required|max:190',
            'order_id' => 'required|numeric',
            'owner_id' => 'required|numeric',
            'image'=>'required',
            'mime'=>'required|in:png,jpg,gif,jpeg'
        ]);

        if(!$validator->fails()){
            $Team_name = $this->TeamMaster_model->TeamNameExistsByOwner($request->owner_id,$request->team_name);
            if(!$Team_name){
                $data = $request->image;
                $mime_data = $request->mime;
                $rand_str = str_random(40);
                $filename = "$rand_str.$mime_data";
                $data = base64_decode($data);
                file_put_contents(public_path('images/'. $filename), $data);
                $params['team_logo'] = $filename;
                $request->request->add(['team_logo' => $filename]);

                $request->request->add(['update' => 1,'id' => $request->id]);
                $Team = $this->TeamMaster_model->SaveTeam($request);
                if($Team){
                    $output = array('status' => 200 ,'msg' => 'Sucess','data' => $Team);
                }else{
                    $output = array('status' => 400 ,'msg' => 'Transection Fail');
                }
            }else{
                $output = array('status' => 400 ,'msg' => 'Team Name Already Exist');
            }
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail','errors' => $validator->errors()->all());
        }
        return response()->json($output);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteTeam(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|min:1',
        ]);
        if(!$validator->fails()){
            $Team = $this->TeamMaster_model->deleteById($request->id);
            if($Team){
                $Team->delete();
                $output = array('status' => 200 ,'msg' => 'Sucess');
            }else{
                $output = array('status' => 400 ,'msg' => 'Transection Fail');
            }
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail','errors' => $validator->errors()->all());
        }
        return response()->json($output);
    }
}
