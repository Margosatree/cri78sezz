<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User_Master;
use App\Tournament_Details;
use App\Tournament_Master;
use App\Tournament_Rules;
use App\Organisation_Master;
class TournamentRulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Rules = Tournament_Rules::all();
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
