<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User_Master;
use App\Tournament_Details;
use App\Tournament_Master;
use App\Tournament_Rules;
use App\Organisation_Master;
class TournamentDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($Tournament)
    {
        $Tour_Dets = Tournament_Details::all();
        return view('user.tourdet.index',compact('Tour_Dets','Tournament'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($Tournament)
    {
        $Rules = Tournament_Rules::all();
        return view('user.tourdet.add',compact('Rules','Tournament'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$Tournament)
    {
        
        $this->validate($request,[
            'rule' => 'required|numeric|max:190',
            'specification' => 'max:190',
            'value' => 'required|max:190',
            'range_from' => 'date|before:end_date',
            'range_to' => 'date|after:start_date',
        ]);
        $Tour_Det = new Tournament_Details();
        $Tour_Det->tournament_id = $Tournament;
        $Tour_Det->rule_id = request('rule');
        $Tour_Det->specification = null;
        $Tour_Det->value = request('value');
        $Tour_Det->range_from = null;
        $Tour_Det->range_to = null;
        $Tour_Det->save();
        return redirect()->route('tourdet.index',$Tournament);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($Tournament,$id)
    {
        $Tour_Dets = Tournament_Details::selectRaw('*')->where('tournament_id',$id)->get();
//        dd($Tour_Dets);
        return view('user.tourdet.index',compact('Tour_Dets'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($Tournament,$id)
    {
//        dd($Tournament.' '.$id);
        $Rules = Tournament_Rules::all();
        $Tour_Det = Tournament_Details::selectRaw('*')->where('tournament_id',$Tournament)->where('rule_id',$id)->get()->first();
        return view('user.tourdet.edit',compact('Tour_Det','Rules','Tournament'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $Tournament, $id)
    {
        
        $this->validate($request,[
            'rule' => 'required|numeric|max:190',
            'specification' => 'max:190',
            'value' => 'required|max:190',
            'range_from' => 'date|before:end_date',
            'range_to' => 'date|after:start_date',
        ]);
        $Tour_Det = Tournament_Details::selectRaw('*')->where('tournament_id',$Tournament)->where('rule_id',$id)->get();
        if($Tour_Det){
            $Tour_Detail = Tournament_Details::where('tournament_id', $Tournament)->where('rule_id', $id);
            $Tour_Detail->update([
                'rule_id'=>request('rule'),
                'specification'=>null,
                'value'=>request('value'),
                'range_from'=>null,
                'range_to'=>null,
            ]);
        }
        
        return redirect()->route('tourdet.index',$Tournament);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($Tournament, $id)
    {
        $Tour_Dets = Tournament_Details::selectRaw('*')->where('tournament_id',$Tournament)->where('rule_id',$id)->get();
        if($Tour_Dets){
            Tournament_Details::where(['tournament_id'=>$Tournament,'rule_id'=>$id])->delete();
        }else{
            dd('Not Exist');
        }
        return redirect()->route('tourdet.index',$Tournament);
    }
}
