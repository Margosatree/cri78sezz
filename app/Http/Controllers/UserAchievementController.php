<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User_Master;
use App\User_Achievement;
use App\Organisation_Master;
class UserAchievementController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth:admin',['only'=>['index']]);
        $this->middleware('auth',['except'=>['index']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $User_Achieve = User_Achievement::all();
        return view('user.achieve.index',compact('User_Achieve'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Orgs = Organisation_Master::selectRaw('id,name')->get();
        return view('user.achieve.add',compact('Orgs'));
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
            'title' => 'required|max:190',
            'name' => 'required|numeric',
//            'orgname' => 'required|max:190',
            'location' => 'required|max:190',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
        ]);
        
//        dd(request()->all());
//        $OrganisationId = 0;
//        
//        if(request('name') == -1 ){
//            $Org = new Organisation_Master;
//            $Org->name = request('orgname');
//            $Org->address = null;
//            $Org->city = null;
//            $Org->state = null;
//            $Org->country = null;
//            $Org->pincode = null;
//            $Org->business_type = null;
//            $Org->business_operation = null;
//            $Org->spoc = null;
//            $Org->is_verified = 0;
//            $Org->save();
//            $OrganisationId = $Org->id;
//        }else{
//            $OrganisationId = request('name');
//        }
        $User_Achieve = new User_Achievement;
//        $User_Achieve->user_master_id = Auth::user()->user_master_id;
        $User_Achieve->title = request('title');
        $User_Achieve->organization_master_id = request('name');
        $User_Achieve->location = request('location');
        $User_Achieve->start_date = request('start_date');
        $User_Achieve->end_date = request('end_date');
        $User_Achieve->save();
        
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
        
        $User_Exists = User_Achievement::selectRaw('count(id) as count')->where('user_master_id',Auth::user()->user_master_id)->get()->first();
//        dd($User_Exists->count);
        if($User_Exists->count){
            $Bio = User_Master::find(Auth::user()->user_master_id);
            $User_Achieve = User_Achievement::select('*')->where('user_master_id',Auth::user()->user_master_id)->get()->first();
            return view('user.achieve.show',compact('User_Achieve','Bio'));
        }else{
            return view('user.achieve.add');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Orgs = Organisation_Master::all();
        $User_Achieve = User_Achievement::find($id);
        return view('user.achieve.edit',compact('User_Achieve','Orgs'));
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
        $this->validate($request,[
            'title' => 'required|max:190',
            'name' => 'required|numeric',
//            'orgname' => 'required|max:190',
            'location' => 'required|max:190',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
        ]);
//        $OrganisationId = 0;
        
//        if(request('name') == -1 ){
//            $Org = new Organisation_Master;
//            $Org->name = request('orgname');
//            $Org->is_verified = 0;
//            $Org->save();
//            $OrganisationId = $Org->id;
//        }else{
//            $OrganisationId = request('name');
//        }
        $User_Achieve = User_Achievement::find($id);
        $User_Achieve->user_master_id = Auth::user()->user_master_id;
        $User_Achieve->title = request('title');
        $User_Achieve->organization_master_id = request('name');
        $User_Achieve->location = request('location');
        $User_Achieve->start_date = request('start_date');
        $User_Achieve->end_date = request('end_date');
        $User_Achieve->save();
        
        if(Auth::user()->role == "admin"){
            return redirect()->route('achieve.index');
        }else{
            $Bio = User_Master::find(Auth::User()->user_master_id);
            return view('user.achieve.show',compact('User_Achieve','Bio'));
        }
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
