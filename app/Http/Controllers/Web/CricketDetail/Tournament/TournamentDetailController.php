<?php

namespace App\Http\Controllers\Web\CricketDetail\Tournament;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Model\TournamentDetails_model;
use App\Model\TournamentRules_model;
use App\Model\OrganisationMaster_model;


class TournamentDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $OrganisationMaster_model;
    protected $TournamentDetails_model;
    protected $TournamentRules_model;
    
    public function __construct(){
//        $this->middleware('auth:admin',['only'=>['index']]);
//        $this->middleware('auth',['except'=>['index']]);
        $this->_initModel();
    }
    
    protected function _initModel(){
        $this->OrganisationMaster_model = new OrganisationMaster_model();
        $this->TournamentDetails_model = new TournamentDetails_model();
        $this->TournamentRules_model = new TournamentRules_model();
    }
    
    public function index($Tournament)
    {
        
        $Tour_Dets = $this->TournamentDetails_model->getTourDetById($Tournament);
        return view('user.tourdet.index',compact('Tour_Dets','Tournament'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($Tournament)
    {
        $Rule_id = $this->TournamentDetails_model->getRulesByTourId($Tournament);
        $Rules = $this->TournamentRules_model->getAllNotIn($Rule_id);
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
            'rule_id' => 'required|numeric|max:190',
            'specification' => 'max:190',
            'value' => 'required|max:190',
            'range_from' => 'date|before:end_date',
            'range_to' => 'date|after:start_date',
        ]);
        $request->request->add(['tournament_id' => $Tournament]);
        $Tour_Det = $this->TournamentDetails_model->SaveTourDetail($request);
        
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
        $Tour_Det = $this->TournamentDetails_model->getTourDetByIdRuleId($Tournament,$id);
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
            'rule_id' => 'required|numeric|max:190',
            'specification' => 'max:190',
            'value' => 'required|max:190',
            'range_from' => 'date|before:end_date',
            'range_to' => 'date|after:start_date',
        ]);
        $request->request->add(['update' => 1,'tournament_id' => $Tournament]);
        $Tour_Det = $this->TournamentDetails_model->SaveTourDetail($request);
        
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
        $Tour_Dets = $this->TournamentDetails_model->getTourDetByIdRuleId($Tournament, $id);
        if($Tour_Dets){
            $this->TournamentDetails_model->deleteRuleByRuleId($Tournament,$id);
        }else{
            dd('Not Exist');
        }
        return redirect()->route('tourdet.index',$Tournament);
    }
}