<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User_Master;
use Auth;

class UsersBioController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth:admin');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $User_Bios = User_Master::all();
//        dd($User_Bios);
        return view('user.bioshowall',compact('User_Bios'));
//        return view('user.bioshowall');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.bio');
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
            'address' => 'required|max:255',
            'suburb' => 'required|max:255',
            'city' => 'required|max:255',
            'state' => 'required|max:255',
            'country' => 'required|max:255',
            'pin' => 'required|digits:6|numeric',
        ]);
//        dd($request->all());
        $id = Auth::user()->user_master_id;
        $bio = User_Master::find($id);
        $bio->address = request('address');
        $bio->suburb = request('suburb');
        $bio->city = request('city');
        $bio->state = request('state');
        $bio->country = request('country');
        $bio->pin = request('pin');
        $bio->save();
        return redirect()->route('criProfile.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = Auth::user()->user_master_id;
        $Bio = User_Master::find($id);
        if($Bio == null){
            return view('user.bioshow');
        }else{
            return view('user.bioshow', compact('Bio'));
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $Bio = User_Master::find($id);
        return view('user.bioshow', compact('Bio'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        
        $this->validate(request(), [
            'address' => 'required|max:255',
            'suburb' => 'required|max:255',
            'city' => 'required|max:255',
            'state' => 'required|max:255',
            'country' => 'required|max:255',
            'pin' => 'required|digits:6|numeric',
        ]);
        $bio = User_Master::find($id);
        
        $bio->address = request('address');
        $bio->suburb = request('suburb');
        $bio->city = request('city');
        $bio->state = request('state');
        $bio->country = request('country');
        $bio->pin = request('pin');
        $bio->save();
        return redirect()->route('userBio.index');
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
