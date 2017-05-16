<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Match_Masters;

class MatchMastersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $match_masters = Match_Masters::get();
        return view('matchmaster.index',compact('match_masters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('matchmaster.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->validate(request(), [
            'tournament_id' => 'required|numeric',
            'match_name' => 'required',
            'match_type' => 'required',
            'overs' => 'required|numeric',
            'team1_id' => 'required|numeric',
            'team2_id' => 'required|numeric',
            'match_date' => 'required|date|before:'.date('Y-m-d'),
            'win_toss_id' => 'required|numeric',
            'selected_to_by_toss_winner' => 'required|in:bat,ball'

        ]);

        $data = [
                'tournament_id' => $request->tournament_id,
                'match_name' => $request->match_name,
                'ground_name' => 'BMC Ground',
                'match_type' => $request->match_type,
                'overs' => $request->overs,
                'innings' => '2',
                'status' => 'running',
                'toss' => 'Head',
                'team1_id' => $request->team1_id,
                'team2_id' => $request->team2_id,
                'location' => 'mohali',
                'match_date' => $request->match_date,
                'ttl_overs' => 40,
                'ttl_player_each_cnt' => 22,
                'win_toss_id' => $request->win_toss_id,
                'selected_to_by_toss_winner' => $request->selected_to_by_toss_winner,
                'inning_1' => 150,
                'inning_2' => 124,
                'created_by' => 25,
                'created_date' => date('Y-m-d H:i:m')
                ];
                Match_Masters::create($data);
                return redirect()->to('/matchmaster');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $match = Match_Masters::find($id);
        return view('matchmaster.show',compact('match'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $match = Match_Masters::find($id);
        return view('matchmaster.edit',compact('match'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate(request(), [
            'tournament_id' => 'required|numeric',
            'match_name' => 'required',
            'match_type' => 'required',
            'overs' => 'required|numeric',
            'team1_id' => 'required|numeric',
            'team2_id' => 'required|numeric',
            'match_date' => 'required|date|before:'.date('Y-m-d'),
            'win_toss_id' => 'required|numeric',
            'selected_to_by_toss_winner' => 'required|in:bat,ball'

        ]);

        $data = [
                'tournament_id' => $request->tournament_id,
                'match_name' => $request->match_name,
                'ground_name' => 'BMC Ground',
                'match_type' => $request->match_type,
                'overs' => $request->overs,
                'innings' => '2',
                'status' => 'running',
                'toss' => 'Head',
                'team1_id' => $request->team1_id,
                'team2_id' => $request->team2_id,
                'location' => 'mohali',
                'match_date' => $request->match_date,
                'ttl_overs' => 40,
                'ttl_player_each_cnt' => 22,
                'win_toss_id' => $request->win_toss_id,
                'selected_to_by_toss_winner' => $request->selected_to_by_toss_winner,
                'inning_1' => 150,
                'inning_2' => 124,
                'modified_by'=>115,
                'modified_date'=>date('Y-m-d H:i:m'),
                ];

        $match = Match_Masters::find($match_id)->update($data);
        return redirect()->to('/matchmaster');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
