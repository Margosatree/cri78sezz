<?php

namespace App\Http\Controllers\Api\V1\CricketDetail\Match;

use Illuminate\Http\Request;
use JWTAuth;
use Validator;
use App\Model\MatchMaster_model;
use App\Model\UserOrganisation_model;
use App\Model\UserMaster_model;
use App\Model\TournamentMaster_model;
use App\Model\TeamMaster_model;
use App\Model\TeamMembers_model;
use App\Http\Controllers\Controller;

class MatchMastersControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $MatchMaster_model;
    protected $UserOrganisation_model;
    protected $UserMaster_model;
    protected $TournamentMaster_model;
    protected $TeamMaster_model;
    protected $TeamMembers_model;

    public function __construct(){
        $this->_initModel();
        //parent::__construct();

    }

    protected function _initModel(){
        $this->MatchMaster_model=new MatchMaster_model();
        $this->UserOrganisation_model=new UserOrganisation_model();
        $this->UserMaster_model=new UserMaster_model();
        $this->TournamentMaster_model=new TournamentMaster_model();
        $this->TeamMaster_model=new TeamMaster_model();
        $this->TeamMembers_model=new TeamMembers_model();
    }

    public function listMatch(Request $request){
        $validator = Validator::make($request->all(), [
            'tournament_id' => 'required|numeric|min:1',
        ]);
        if(!$validator->fails()){
            $organization_master_id = 1; //have to find Org id from login
            $Tour_id = $this->TournamentMaster_model->getId($organization_master_id,$request->tournament_id);
            $Matches = $this->MatchMaster_model->checkTourId($Tour_id);
            if($Matches){
                $output = array('status' => 200 ,'msg' => 'Sucess','data' => $Matches);
            }else{
                $output = array('status' => 400 ,'msg' => 'Transection Fail');
            }
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail','errors' => $validator->errors()->all());
        }
        return response()->json($output);
    }
    
        public function addMatch(Request $request){
        $validator = Validator::make($request->all(), [
            'tournament_id' => 'required|numeric',
            'team1' => 'required|numeric',
            'team2' => 'required|numeric',
            'match_name' => 'required|max:190',
            'ground_name' => 'required|max:190',
            'match_type' => 'required|max:190',
            'match_date' => 'required|date|after:'.date('Y-m-d'),
            'overs' => 'required|numeric',
            'innings' => 'required|numeric',
        ]);
        if(!$validator->fails()){
            if(!($request->team1 == $request->team2)){
                $org_id = $this->TournamentMaster_model->getOrgIDByTourId($request->tournament_id);
                $teams = $this->TeamMaster_model->getTeamByOrg($org_id);
                $validateTeam = 0;
                foreach ($teams as $team){
                    if($request->team1 == $team['id']){ $validateTeam++; }
                    if($request->team2 == $team['id']){ $validateTeam++; }
                    if($validateTeam == 2){ break; }
                }
                if($validateTeam == 2){
                    $Matches = $this->MatchMaster_model->SaveMatch($request);
                    if($Matches){
                        $output = array('status' => 200 ,'msg' => 'Sucess','data' => $Matches);
                    }else{
                        $output = array('status' => 400 ,'msg' => 'Transection Fail');
                    }
                }else{
                    $output = array('status' => 400 ,'msg' => 'Team Not Exists In Tournament');
                }
            }else{
                $output = array('status' => 400 ,'msg' => 'Please Select Another Team');
            }
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail','errors' => $validator->errors()->all());
        }
        return response()->json($output);
    }

    public function updateMatch(Request $request){
        $validator = Validator::make($request->all(), [
            'match_id' => 'required|numeric|min:1',
            'tournament_id' => 'required|numeric|min:1',
            'team1' => 'required|numeric',
            'team2' => 'required|numeric',
            'match_name' => 'required|max:190',
            'ground_name' => 'required|max:190',
            'match_type' => 'required|max:190',
            'match_date' => 'required|date|after:'.date('Y-m-d'),
            'overs' => 'required|numeric',
            'innings' => 'required|numeric',
        ]);
//        dd($request->all());
        if(!$validator->fails()){
            if(!($request->team1 == $request->team2)){
                $org_id = $this->TournamentMaster_model->getOrgIDByTourId($request->tournament_id);
                $teams = $this->TeamMaster_model->getTeamByOrg($org_id);
                $validateTeam = 0;
                foreach ($teams as $team){
                    if($request->team1 == $team['id']){ $validateTeam++; }
                    if($request->team2 == $team['id']){ $validateTeam++; }
                    if($validateTeam == 2){ break; }
                }
                if($validateTeam == 2){
                    $Match = $this->MatchMaster_model->getDetailByTourMatch($request->tournament_id,$request->match_id);
                    if($Match){
                        $this->MatchMaster_model->updateByTourId($request->tournament_id,$request->match_id,$request);
                        $output = array('status' => 200 ,'msg' => 'Sucess');
                    }else{
                        $output = array('status' => 400 ,'msg' => 'Transection Fail');
                    }
                }else{
                    $output = array('status' => 400 ,'msg' => 'Team Not Exists In Tournament');
                }
            }else{
                $output = array('status' => 400 ,'msg' => 'Please Select Another Team');
            }
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail','errors' => $validator->errors()->all());
        }
        return response()->json($output);
    }

    public function deleteMatch(Request $request){
        $validator = Validator::make($request->all(), [
            'tournament_id' => 'required|numeric',
            'match_id' => 'required|numeric',
        ]);
        if(!$validator->fails()){
            $Match = $this->MatchMaster_model->getDetailByTourMatch($request->tournament_id,$request->match_id);
            if($Match){
                $Match = $this->MatchMaster_model->deleteByTourMatch($request->tournament_id,$request->match_id);
                $output = array('status' => 200 ,'msg' => 'Sucess');
            }else{
                $output = array('status' => 400 ,'msg' => 'Transection Fail');
            }
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail','errors' => $validator->errors()->all());
        }
        return response()->json($output);
    }

    public function listMyMatch(){
        $user = JWTAuth::parseToken()->authenticate();
        $datas = ['user_master_id'=>$user->user_master_id];
        $data_arr =array();
        $getTeams = $this->TeamMembers_model->getByAny($datas);
        // var_dump($getTeams);
        foreach($getTeams as $getTeam){
            $team_data = $this->MatchMaster_model->getDetailByTourTeam($getTeam->tournament_id,$getTeam->team_id);
            $team1_detail = $this->TeamMaster_model->getById($team_data->team1_id);
            $team2_detail = $this->TeamMaster_model->getById($team_data->team2_id);
            $teams_detail =['team1'=>$team1_detail
                            ,'team2'=>$team2_detail
                            ,'match'=>$team_data];
            
            $data_arr[]=$teams_detail;
        }                                    
        if(!is_null($data_arr)){
            $response = array('status' => 200 ,'msg' => 'success','data' => $data_arr);
        }else{
            $response = array('status' => 404 ,'msg' => 'transation_failed');
        }
        return response()->json($response,$response['status']);
    }
}
