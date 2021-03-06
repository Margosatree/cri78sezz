<?php

namespace App\Http\Controllers\Web\CricketDetail\Match;

use Illuminate\Http\Request;
use Auth;

use App\Model\MatchMaster_model;
use App\Model\UserOrganisation_model;
use App\Model\UserMaster_model;
use App\Model\TournamentMaster_model;
use App\Model\TeamMaster_model;
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
    }

    public function listMatch(Request $request){
        $this->validate($request,[
            'tournament_id' => 'required|numeric|min:1',
            'organization_master_id' => 'required|numeric|min:1',
        ]);
        $organization_master_id = 1;//have to find Org id from login
        $Tour_id = $this->TournamentMaster_model->getId($organization_master_id,$request->tournament_id);
        $Matches = $this->MatchMaster_model->checkTourId($Tour_id);
        if($Matches){
            $output = array('status' => 200 ,'msg' => 'Sucess','data' => $Matches);
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail');
        }
        return response()->json($output);
    }
    
    public function addMatch(Request $request){
        $this->validate($request, [
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
        if(!$request->team1 == $request->team2){
            $Matches = $this->MatchMaster_model->SaveMatch($request);
            if($Matches){
                $output = array('status' => 200 ,'msg' => 'Sucess','data' => $Matches);
            }else{
                $output = array('status' => 400 ,'msg' => 'Transection Fail');
            }
        }else{
            $output = array('status' => 400 ,'msg' => 'Please Select Another Team');
        }
        return response()->json($output);
    }

    public function updateMatch(Request $request){
        $this->validate($request, [
            'tournament_id' => 'required|numeric',
            'match_id' => 'required|numeric',
            'team1' => 'required|numeric',
            'team2' => 'required|numeric',
            'match_name' => 'required|max:190',
            'ground_name' => 'required|max:190',
            'match_type' => 'required|max:190',
            'match_date' => 'required|date|after:'.date('Y-m-d'),
            'overs' => 'required|numeric',
            'innings' => 'required|numeric',
        ]);
        if(!$request->team1 == $request->team2){
            $Match = $this->MatchMaster_model->getDetailByTourMatch($request->tournament_id,$request->match_id);
            if($Match){
                $this->MatchMaster_model->updateByTourId($request->tournament_id,$request->match_id,$request);
                $output = array('status' => 200 ,'msg' => 'Sucess');
            }else{
                $output = array('status' => 400 ,'msg' => 'Transection Fail');
            }
        }else{
            $output = array('status' => 400 ,'msg' => 'Please Select Another Team');
        }
        return response()->json($output);
    }

    public function deleteMatch(Request $request){
        $this->validate($request, [
            'tournament_id' => 'required|numeric',
            'match_id' => 'required|numeric',
        ]);
        $Match = $this->MatchMaster_model->getDetailByTourMatch($request->tournament_id,$request->match_id);
        if($Match){
            $Match = $this->MatchMaster_model->deleteByTourMatch($request->tournament_id,$request->match_id);
            $output = array('status' => 200 ,'msg' => 'Sucess');
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail');
        }
        return response()->json($output);
    }
}
