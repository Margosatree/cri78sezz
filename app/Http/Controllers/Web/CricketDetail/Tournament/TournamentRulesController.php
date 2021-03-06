<?php

namespace App\Http\Controllers\Web\CricketDetail\Tournament;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\TournamentMaster_model;
use App\Model\TournamentRules_model;

class TournamentRulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('auth:admin',['only'=>['index']]);
        $this->middleware('auth',['except'=>['index']]);
        $this->_initModel();
    }
    
    protected $TournamentMaster_model;
    protected $TournamentRules_model;
    
    protected function _initModel(){
        $this->TournamentMaster_model = new TournamentMaster_model();
        $this->TournamentRules_model = new TournamentRules_model();
    }
    
    public function index()
    {
        
        $Rules = $this->TournamentRules_model->getAll();
        return view('user.rule.index',compact('Rules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('user.rule.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|max:190',
            'specification' => 'required|max:190',
            'value' => 'max:190',
            'range_from' => 'required|date|before:end_date',
            'range_to' => 'required|date|after:start_date',
        ]);
        
        $Rule = new Tournament_Master;
        $Rule->name = request('name');
        $Rule->specification = request('specification');
        $Rule->value = request('value');
        $Rule->range_from = request('range_from');
        $Rule->range_to = request('range_to');
        $Rule->save();
        return redirect()->route('rule.index');
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
