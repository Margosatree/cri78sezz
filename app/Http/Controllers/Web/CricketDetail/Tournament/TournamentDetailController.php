<?php

namespace App\Http\Controllers\Web\CricketDetail\Tournament;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Model\BasicModel\UserMaster_model;
use App\Model\BasicModel\TournamentDetails_model;
use App\Model\BasicModel\TournamentMaster_model;
use App\Model\BasicModel\TournamentRules_model;
use App\Model\BasicModel\OrganisationMaster_model;


class TournamentDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $UserMaster_model;
    protected $OrganisationMaster_model;
    protected $TournamentDetails_model;
    protected $TournamentMaster_model;
    protected $TournamentRules_model;
    
    public function __construct(){
        $this->middleware('auth:admin',['only'=>['index']]);
        $this->middleware('auth',['except'=>['index']]);
        $this->_initModel();
    }
    
    protected function _initModel(){
        $this->UserMaster_model = new UserMaster_model();
        $this->OrganisationMaster_model = new OrganisationMaster_model();
        $this->TournamentDetails_model = new TournamentDetails_model();
        $this->TournamentMaster_model = new TournamentMaster_model();
        $this->TournamentRules_model = new TournamentRules_model();
    }
    
    public function index($Tournament)
    {
        
        $Tour_Dets = Tournament_Details::selectRaw('*')
                    ->where('tournament_id',$Tournament)->get();
        return view('user.tourdet.index',compact('Tour_Dets','Tournament'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($Tournament)
    {
        $Rule_id = Tournament_Details::selectRaw('rule_id')
                    ->where('tournament_id',$Tournament)->get();
        $Rules = Tournament_Rules::selectRaw('*')->whereNotIn('id',$Rule_id)->get();
//        $Rules = Tournament_Rules::all();
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
        
        $params = array();
        $params['tournament_id'] = $Tournament;
        $params['rule_id'] = $request->rule_id;
        $params['specification'] = null;
        $params['value'] = $request->value;
        $params['range_from'] = null;
        $params['range_to'] = null;
        $Tour_Det = $this->TournamentDetails_model->SaveUserBio($params);
        
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
        $Tour_Dets = $this->TournamentDetails_model->getTourDetById($id);
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
        $Rules = $this->TournamentRules_model->getAll();
        $Tour_Det = getTourDetByIdRuleId($Tournament,$id);
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
