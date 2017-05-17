<?php

namespace App\Http\Controllers;
use App\Organisation_Master;
use App\User_Cricket_Profile;
use App\User_Master;
use App\User_Achievement;
use Auth;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function __construct(){
//        $this->middleware('auth:admin');
       // $this->middleware('auth:admin',['only'=>['index']]);
       $this->middleware('auth',['except'=>['show']]);
       $this->middleware('auth:admin',['only'=>['show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "hii";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!Auth::guard('admin')->check()){
            $user_id = Auth::user();
        }else{
            $user_id= Auth::guard('admin')->user();
        }
        // dd();
        $Sr = 0;
        $Bio = User_Master::find($id);
        $Cri_Profile = User_Cricket_Profile::selectRaw('*')->where('user_master_id', $user_id->user_master_id)->get()->first();
        $User_Achieves = User_Achievement::selectRaw('*')->where('user_master_id', $user_id->user_master_id)->get();
        $Org = Organisation_Master::selectRaw('*')->where('id', $user_id->organization_master_id)->get()->first();
        return view('user.profile.show', compact('Bio','Cri_Profile','Org','User_Achieves','Sr'));
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
