<?php

namespace App\Http\Controllers;
use App\User_Cricket_Profile;
use Illuminate\Http\Request;
use Auth;
class UserCricketProfileController extends Controller
{
    
    public function __construct(){
//        $this->middleware('auth:admin');
//        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Cri_Profiles = User_Cricket_Profile::all();
        return view('user.criprofile.index',compact('Cri_Profiles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.criprofile');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
//        dd($request->all());
        $this->validate($request,[
            'your_role' => 'required|numeric',
            'batsman_style' => 'required|in:Lefthand,Righthand',
            'batsman_order' => 'required|numeric',
            'bowler_style' => 'required|in:Lefthand,Righthand',
            'player_type' => 'required|max:255',
            'description' => 'required|max:255',
//            'display_img' => 'required|max:255',
//            'is_completed' => 'required|numeric',
        ]);
        
        $User_Cri_Profile = new User_Cricket_Profile;
        $User_Cri_Profile->user_master_id = Auth::user()->user_master_id;
        $User_Cri_Profile->your_role = request('your_role');
        $User_Cri_Profile->batsman_style = request('batsman_style');
        $User_Cri_Profile->batsman_order = request('batsman_order');
        $User_Cri_Profile->player_type = request('player_type');
        $User_Cri_Profile->description = request('description');
        $User_Cri_Profile->save();
        
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Cri_Profile = User_Cricket_Profile::find($id);
        return view('user.criprofile.show',compact('Cri_Profile'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Cri_Profile = User_Cricket_Profile::find($id);
        return view('user.criprofile.edit',compact('Cri_Profile'));
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
        
//        dd(request()->all());
        $this->validate($request,[
            'your_role' => 'required|numeric',
            'batsman_style' => 'required|in:Lefthand,Righthand',
            'batsman_order' => 'required|numeric',
            'bowler_style' => 'required|in:Lefthand,Righthand',
            'player_type' => 'required|max:255',
            'description' => 'required|max:255',
//            'display_img' => 'required|max:255',
//            'is_completed' => 'required|numeric',
        ]);
        
        $Cri_Profile = User_Cricket_Profile::find($id);
        $Cri_Profile->your_role = request('your_role');
        $Cri_Profile->batsman_style = request('batsman_style');
        $Cri_Profile->batsman_order = request('batsman_order');
        $Cri_Profile->bowler_style = request('bowler_style');
        $Cri_Profile->player_type = request('player_type');
        $Cri_Profile->description = request('description');
        $Cri_Profile->save();
        return redirect()->route('criProfile.index');
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
