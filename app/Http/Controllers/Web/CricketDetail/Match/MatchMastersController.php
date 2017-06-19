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

class MatchMastersController extends Controller
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

    public function index($Tournament)
    {
        $org_id = Auth::user()->organization_master_id;
        $Tour_id = $this->TournamentMaster_model->getId($org_id,$Tournament);
        $Matches = $this->MatchMaster_model->checkTourId($Tour_id);
//        dd($Matches);
//        foreach ($Matches as $value) {
//            echo json_encode($value->match_name);
//        }
        return view('user.matchmst.index',compact('Matches','Tournament'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($Tournament)
    {
//        dd('create');
        
        $usermaster_id = Auth::user()->user_master_id;
        $Teams = $this->TeamMaster_model->getTeamDetail($usermaster_id);
        dd($Teams);
        return view('user.matchmst.add',compact('Tournament','Teams','Owners'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$Tournament)
    {
//        dd(request()->all());
        $this->validate($request, [
//            'tournament_id' => 'required|numeric',
            'team1' => 'required|numeric',
            'team2' => 'required|numeric',
            'match_name' => 'required|max:190',
            'ground_name' => 'required|max:190',
            'match_type' => 'required|max:190',
            'match_date' => 'required|date|after:'.date('Y-m-d'),
            'overs' => 'required|numeric',
            'innings' => 'required|numeric',
        ]);
        if($request->team1 == $request->team2){
            dd('Please Select Another Team');
        }
        $request->request->add(['tournament_id' => $Tournament]);
        $this->MatchMaster_model->SaveMatch($request);
        
        return redirect()->route('match.index',$Tournament);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($Tournament,$id)
    {
        dd('show');
        $match = $this->MatchMaster_model->getDetailById($id);
        return view('matchmaster.show',compact('match'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($Tournament,$id)
    {
//        dd('edit');
        $usermaster_id = Auth::user()->user_master_id;
        $Teams = $this->TeamMaster_model->getTeamDetail($usermaster_id);
        $Match = $this->MatchMaster_model->getDetailByTourMatch($Tournament,$id);
        return view('user.matchmst.edit',compact('Tournament','Teams','Match'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $Tournament,$id)
    {
//        dd(request()->all() );
        $this->validate($request, [
            'team1' => 'required|numeric',
            'team2' => 'required|numeric',
            'match_name' => 'required|max:190',
            'ground_name' => 'required|max:190',
            'match_type' => 'required|max:190',
            'match_date' => 'required|date|after:'.date('Y-m-d'),
            'overs' => 'required|numeric',
            'innings' => 'required|numeric',
        ]);
        if($request->team1 == $request->team2){
            dd('Please Select Another Team');
        }
        
        $Match = $this->MatchMaster_model->getDetailByTourMatch($Tournament,$id);
            if($Match){
                $this->MatchMaster_model->updateByTourId($Tournament,$id,$request);
            }
        return redirect()->route('match.index',$Tournament);
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($Tournament,$id)
    {
        $Match = $this->MatchMaster_model->getDetailByTourMatch($Tournament,$id);
        if($Match){
            $Match = $this->MatchMaster_model->deleteByTourMatch($Tournament,$id);
        }else{
            dd('Not Exist');
        }
        return redirect()->route('match.index',$Tournament);
    }
}
