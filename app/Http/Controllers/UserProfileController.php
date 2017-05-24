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
       $this->middleware('auth',['except'=>['showUser']]);
       $this->middleware('auth:admin',['only'=>['showUser']]);
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
      // dd($id);
        $data=$this->_show($id);
        return view('user.profile.show', $data);


    }

    public function showUser($id){
      // dd($id);
          $data=$this->_show($id);
          return view('user.profile.show', $data);

    }


    private function _show($id){

      if(!Auth::guard('admin')->check()){
          $user_id = Auth::user();
      }else{
          $user_id= Auth::guard('admin')->user();
      }

      $Sr = 0;
      $Bio = User_Master::find($id);
      $Cri_Profile = User_Cricket_Profile::selectRaw('*')->where('user_master_id', $user_id->user_master_id)->get()->first();
      $User_Achieves = User_Achievement::selectRaw('*')->where('user_master_id', $user_id->user_master_id)->get();
      $Org = Organisation_Master::selectRaw('*')->where('id', $user_id->organization_master_id)->get()->first();
      $data=['Bio'=> $Bio,'Cri_Profile'=> $Cri_Profile,'User_Achieves'=> $User_Achieves,'Org'=> $Org];
      return $data;
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
