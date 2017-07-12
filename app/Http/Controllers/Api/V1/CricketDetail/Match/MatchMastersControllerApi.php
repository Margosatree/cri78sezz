<?php

namespace App\Http\Controllers\Api\V1\CricketDetail\Match;

use Illuminate\Http\Request;
use JWTAuth;
use JWTAuthException;
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
            $user = JWTAuth::parseToken()->authenticate();
            $organization_master_id = $user->organization_master_id;
            $Tour_id = $this->TournamentMaster_model->getId($organization_master_id,$request->tournament_id);
            $Matches = $this->MatchMaster_model->checkTourId($Tour_id);
            if($Matches){
                $output = array('status_code' => 200 ,'message' => 'Sucess','data' => $Matches);
            }else{
                $output = array('status_code' => 400 ,'message' => 'Transection Fail');
            }
        }else{
            $output = array('status_code' => 400 ,'message' => 'Transection Fail','errors' => $validator->errors()->all());
        }
        return response()->json($output,$output['status_code']);
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
                    $user = JWTAuth::parseToken()->authenticate();
                    $Matches = $this->MatchMaster_model->SaveMatch($request);
                    if($Matches){
                        $output = array('status_code' => 200 ,'message' => 'Sucess','data' => $Matches);
                    }else{
                        $output = array('status_code' => 400 ,'message' => 'Transection Fail');
                    }
                }else{
                    $output = array('status_code' => 400 ,'message' => 'Team Not Exists In Tournament');
                }
            }else{
                $output = array('status_code' => 400 ,'message' => 'Please Select Another Team');
            }
        }else{
            $output = array('status_code' => 400 ,'message' => 'Transection Fail','errors' => $validator->errors()->all());
        }
        return response()->json($output,$output['status_code']);
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
                    $user = JWTAuth::parseToken()->authenticate();
                    $Match = $this->MatchMaster_model->getDetailByTourMatch($request->tournament_id,$request->match_id);
                    if($Match){
                        $request->request->add(['updated_by' => $user->user_master_id]);
                        $this->MatchMaster_model->updateByTourId($request->tournament_id,$request->match_id,$request);
                        $output = array('status_code' => 200 ,'message' => 'Sucess');
                    }else{
                        $output = array('status_code' => 400 ,'message' => 'Transection Fail');
                    }
                }else{
                    $output = array('status_code' => 400 ,'message' => 'Team Not Exists In Tournament');
                }
            }else{
                $output = array('status_code' => 400 ,'message' => 'Please Select Another Team');
            }
        }else{
            $output = array('status_code' => 400 ,'message' => 'Transection Fail','errors' => $validator->errors()->all());
        }
        return response()->json($output,$output['status_code']);
    }

    public function deleteMatch(Request $request){
        $validator = Validator::make($request->all(), [
            'tournament_id' => 'required|numeric',
            'match_id' => 'required|numeric',
        ]);
        if(!$validator->fails()){
            $user = JWTAuth::parseToken()->authenticate();
            $Match = $this->MatchMaster_model->getDetailByTourMatch($request->tournament_id,$request->match_id);
            if($Match){
                $request->request->add(['update' => 1,'deleted_by' => $user->user_master_id]);
                $this->MatchMaster_model->SaveMatch($request);
                $Match = $this->MatchMaster_model->deleteByTourMatch($request->tournament_id,$request->match_id);
                $output = array('status_code' => 200 ,'message' => 'Sucess');
            }else{
                $output = array('status_code' => 400 ,'message' => 'Transection Fail');
            }
        }else{
            $output = array('status_code' => 400 ,'message' => 'Transection Fail','errors' => $validator->errors()->all());
        }
        return response()->json($output,$output['status_code']);
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
