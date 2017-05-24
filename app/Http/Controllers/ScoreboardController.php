<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScoreboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('scoreboard');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(),[
        'MatchID' => 'required|unique:roles',
        'TeamID1' => 'required',
        'TeamID2' => 'required', 
        'Innings' => 'required',
        'BatsmanID' => 'required',
        'BatsmanID2' => 'required',
        'BowlerID' => 'required',
        'FilderID' => 'required', 
        'BatsmanScore'=> 'required',
        'BowlerGiven'=> 'required',
        'ExtraRuns'=> 'required',
        'TotalRuns'=> 'required',
        'TeamRuns'=> 'required',
        'WicketCount'=> 'required',
        'BallNo'=> 'required',
        'BallTypeID'=> 'required',
        'BallType'=> 'required',
        'OverNo'=> 'required',
        'WicketId'=> 'required',
        'WicketType'=> 'required',
        'WicketDesc'=> 'required',
        'Remark'=> 'required',
        'Commentry'=> 'required',      
        ]);
        if(request('TransID') == '')
        {
        $data = [
        'MatchID' => request('MatchID'),
        'TeamID1' => request('TeamID1'),
        'TeamID2' => request('TeamID2'),
        'Innings' => request('Innings'),
        'BatsmanID' => request('BatsmanID'),
        'BatsmanID2' => request('BatsmanID2'),
        'BowlerID' => request('BowlerID'),
        'FilderID' => request('FilderID'),
        'BatsmanScore'=> request('BatsmanScore'),
        'BowlerGiven'=> request('BowlerGiven'),
        'ExtraRuns'=> request('ExtraRuns'),
        'TotalRuns'=> request('TotalRuns'),
        'TeamRuns'=> request('TeamRuns'),
        'WicketCount'=> request('WicketCount'),
        'BallNo'=> request('BallNo'),
        'BallTypeID'=> request('BallTypeID'),
        'BallType'=> request('BallType'),
        'OverNo'=> request('OverNo'),
        'WicketId'=> request('WicketId'),
        'WicketType'=> request('WicketType'),
        'WicketDesc'=> request('WicketDesc'),
        'Remark'=> request('Remark'),
        'Commentry'=> request('Commentry'),
        ];
        $data = json_encode($data);
        return view('json_display', compact('data'));
    }
    else{
        $data = 'hello';
        return view('json_display',compact('data'));
        }
        }
        

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
