<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Scoreboard;
use App\Batsmanmaster;
use App\BowlerMaster;
use App\FielderMaster;
use App\User_Master;
use App\User_Cricket_Profile;
use DB;
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
        // dd(request()->all());
        DB::beginTransaction();
        try{
            $this->validate(request(),[
                'MatchID' => 'required',
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
          //  upadte
            $this->saveBallerSummery($request);


            DB::commitTransaction();
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
        }
        return $data2;     
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

    public function saveBatsmanSummery(){

    }
    public function saveBallerSummery($request){
        // dd(request()->all());
        
        $bowler_data = Scoreboard::selectRaw(" 
            SUM(IF(BowlerGiven = 0,1,0)) AS Run0,
            SUM(IF(BowlerGiven = 1,1,0)) AS Run1,
            SUM(IF(BowlerGiven = 2,1,0)) AS Run2,
            SUM(IF(BowlerGiven = 3,1,0)) AS Run3,
            SUM(IF(BowlerGiven = 4,1,0)) AS Run4,
            SUM(IF(BowlerGiven = 6,1,0)) AS Run6, 
            SUM(IF(ExtraRuns > 0 ,ExtraRuns,0)) AS RunExt,
            SUM(IF(BallType IN ( 'WD' ),1,0)) AS RunExtWd,
            SUM(IF(BallType IN ( 'NB+WD', 'NB'),1,0)) AS RunExtNb, 
            SUM(IF(WicketCount > 0,WicketCount,0)) AS Wicket,
            SUM(Maiden) AS Maiden,
            SUM(IF(ballType NOT IN ('WD','NB+WD'),1,0)) AS Balls,
            ROUND(SUM(IF(ballType NOT IN ('WD','NB+WD','NB'),1,0)) / 6,1) AS Overs,
            ROUND(SUM(BowlerGiven)*6/COUNT(BallNo)) AS econ,
            BowlerID,MatchID,Innings AS side")
            ->WHERE('BowlerID', $request->BowlerID)
            ->groupBy(['BowlerID','MatchID','Innings'])
            ->get()->first();

        $order_data = BowlerMaster::where('MatchId',request('MatchID'))
                    ->where('Side',request('Innings'))
                    ->orderBy('TransID', 'DESC')
                    ->take(1)
                    ->get();
            if(count($order_data) == 0){
                $orderid = 1;
            }else{
                $orderid = $order_data->OrderId;
                $orderid = $orderid + 1;
            }
        // dd($bowler);
        $bowlerName = $this->getUsernameByID($request->BowlerID);
        $BowlerType = $this->getPlayerStyleByUserID($request->BowlerID,"BALL");
        $bowler_data = BowlerMaster::selectRaw('count(*) as ballcount')
            ->where('MatchID',$request->MatchID)
            ->where('Side',$request->Innings)
            ->where('BolwerID',$request->BowlerID)
            ->firstOrFail();
        if($bowler_data->ballcount){
            // dd('add');
            $bowler = new BowlerMaster();
            $bowler->MatchID = $bowler_data->MatchID;
            $bowler->Side = $bowler_data->Innings;
            $bowler->OrderId = $orderid;
            $bowler->BolwerID = $bowler_data->BowlerID;
            $bowler->BolwerName = $BowlerName;
            $bowler->BolwerType = $bowlerType;
            $bowler->Balls = 1;
            $bowler->Overs = NULL;
            $bowler->Maiden = $bowler_data->Maiden;
            $bowler->Runs = $bowler_data->Runs;
            $bowler->Run0 = $bowler_data->Run0;
            $bowler->Run1 = $bowler_data->Run1;
            $bowler->Run2 = $bowler_data->Run2;
            $bowler->Run3 = $bowler_data->Run3;
            $bowler->Run4 = $bowler_data->Run4;
            $bowler->Run6 = $bowler_data->Run6;
            $bowler->RunExt = $bowler_data->RunExt;
            $bowler->RunExtWd = $bobowler_datawler->RunExtWd;
            $bowler->RunExtNb = $bowler_data->RunExtNb;
            $bowler->Econ = $bowler_data->Econ;
            $bowler->Wicket = $bowler_data->MatchID;
            $bowler->Index =  null;
            $bowler->save();
            dd($bowler);
        }else{
           // dd('update');
            $TransID = BowlerMaster::selectRaw('TransId')
                ->where('MatchID',$request->MatchID)
                ->where('Side',$request->Innings)
                ->where('BolwerID',$request->BowlerID)
                ->value('TransId');
            $bowler = BowlerMaster::find($TransID);
            $bowler->Run0 = $bowler_data->Run0;
            $bowler->Run1 = $bowler_data->Run1;
            $bowler->Run2 = $bowler_data->Run2;
            $bowler->Run3 = $bowler_data->Run3;
            $bowler->Run4 = $bowler_data->Run4;
            $bowler->Run6 = $bowler_data->Run6;
            $bowler->Runs = $bowler_data->Runs;
            $bowler->RunExt = $bowler_data->RunExt;
            $bowler->RunExtWd = $bowler_data->RunExtWd;
            $bowler->RunExtNb = $bowler_data->RunExtNb;
            $bowler->Wicket = $bowler_data->Wicket; 
            $bowler->Maiden = $bowler_data->Maiden; 
            $bowler->Balls = $bowler_data->Balls;
            $bowler->Overs = $bowler_data->Overs;
            $bowler->econ = $bowler_data->econ;
            $bowler->save();
        }
    }
    // public function saveFilderSummery(){



    //     $fielder_data = Batsmanmaster::selectRaw('count(*) as fildercount')
    //         ->where('match_id',request('MatchID'))
    //         ->where('Side',request('Innings'))
    //         ->where('fielder_id',request('fielder_id'))
    //         ->firstOrFail();
    //     if($fielder_data->fildercount > 0){
    //         $TransID = Batsmanmaster::selectRaw('TransId')
    //             ->where('match_id',request('MatchID'))
    //             ->where('Side',request('Innings'))
    //             ->where('fielder_id',request('FilderID'))
    //             ->value('TransId');
    //         // dd($Bat);
    //         $Filder = ::find($TransID);
    //         $Filder->MatchID = $batsman->Balls;
    //         $Filder->Side = $batsman->Balls;
    //         $Filder->OrderId = $batsman->Balls;
    //         $Filder->BolwerID = $batsman->Balls;
    //         $Filder->BolwerName = $batsman->Balls;
    //         $Filder->BolwerType = $batsman->Balls;
    //         $Filder->Balls = $batsman->Balls;
    //         $Filder->Overs = $batsman->Balls;
    //         $Filder->Maiden = $batsman->Balls;
    //         $Filder->Runs = $batsman->Runs;
    //         $Filder->Run0 = $batsman->Run0;
    //         $Filder->Run1 = $batsman->Run1;
    //         $Filder->Run2 = $batsman->Run2;
    //         $Filder->Run3 = $batsman->Run3;
    //         $Filder->Run4 = $batsman->Run4;
    //         $Filder->Run6 = $batsman->Run6;
    //         $Filder->RunExt = request('ExtraRuns');
    //         $Filder->RunExtWd = request('ExtraRuns');
    //         $Filder->RunExtNb = request('ExtraRuns');
    //         $Filder->Econ = request('ExtraRuns');
    //         $Filder->RunExt = request('ExtraRuns');
    //         $Filder->RunExt = request('ExtraRuns'); 
    //         $Filder->Wicket = $batsman->strkrate; 
    //         $Filder->Index = request('WicketType');
    //         $Filder->save();
    //     }else{

    //     }
    // }

    public function getUsernameByID($user_id){
        // dd($user_id);
        $user = User_Master::where('id', $user_id)->get()->first();
        return $user->first_name.' '.$user->last_name;
    }

    public function getPlayerStyleByUserID($user_id,$style){
        $profile = User_Cricket_Profile::where('user_master_id',$user_id)->get()->first();
        if($style == "BAT"){
            return $profile->batsman_style;
        }else if($style == "BALL"){
            return $profile->bowler_style;
        }else{
            dd("Plaese Select Style");
        }
        
    }
}
