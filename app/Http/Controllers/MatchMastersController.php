<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use App\Match_Master;
use App\User_Organisation;
use App\User_Master;
use App\Tournament_Master;
use App\Team_Master;

class MatchMastersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($Tournament)
    {
//        dd('index');
        $Tour_id = Tournament_Master::selectRaw('id')
                    ->where('organization_master_id',Auth::user()->organization_master_id)
                    ->where('id',$Tournament)->get();
        $Matches = Match_Master::selectRaw('*')->whereIn('tournament_id',$Tour_id)->get();
       // dd($Matches);
//        $Matches = Match_Master::all();
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
        
        $Teams = Team_Master::selectRaw('*')->where('team_owner_id',Auth::user()->user_master_id)->get();
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
        if(request('team1') == request('team2')){
            dd('Please Select Another Team');
        }
        
        $Match = new Match_Master();
        $Match->tournament_id = $Tournament;
        $Match->team1_id = request('team1');
        $Match->team2_id = request('team2');
        $Match->match_name = request('match_name');
        $Match->ground_name = request('ground_name');
        $Match->match_type = request('match_type');
        $Match->match_date = request('match_date');
        $Match->overs = request('overs');
        $Match->innings = request('innings');
        $Match->save();
        
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
        $match = Match_Master::find($id);
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
        $Teams = Team_Master::selectRaw('*')->where('team_owner_id',Auth::user()->user_master_id)->get();
        $Match = Match_Master::selectRaw('*')->where('tournament_id',$Tournament)->where('match_id',$id)->get()->first();
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
        $this->validate(request(), [
            'team1' => 'required|numeric',
            'team2' => 'required|numeric',
            'match_name' => 'required|max:190',
            'ground_name' => 'required|max:190',
            'match_type' => 'required|max:190',
            'match_date' => 'required|date|after:'.date('Y-m-d'),
            'overs' => 'required|numeric',
            'innings' => 'required|numeric',
        ]);
        if(request('team1') == request('team2')){
            dd('Please Select Another Team');
        }
        
        $Match = Match_Master::selectRaw('*')->where('tournament_id',$Tournament)->where('match_id',$id)->get();
            if($Match){
                $Match = Match_Master::where('tournament_id', $Tournament)->where('match_id', $id);
                $Match->update([
                    'team1_id' => request('team1'),
                    'team2_id' => request('team2'),
                    'match_name' => request('match_name'),
                    'ground_name' => request('ground_name'),
                    'match_type' => request('match_type'),
                    'match_date' => request('match_date'),
                    'overs' => request('overs'),
                    'innings' => request('innings'),
                ]);
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
        $Match = Match_Master::selectRaw('*')->where('tournament_id',$Tournament)->where('match_id',$id)->get();
        if($Match){
            Match_Master::where(['tournament_id'=>$Tournament,'match_id'=>$id])->delete();
        }else{
            dd('Not Exist');
        }
        return redirect()->route('match.index',$Tournament);
    }
}
