<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Team_Master;
use App\User_Master;
use App\User_Organisation;
class TeamMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $Teams = Team_Master::where('team_owner_id',Auth::user()->organization_master_id);
        $Teams = Team_Master::selectRaw('*')->where('team_owner_id',Auth::user()->user_master_id)->get();
        return view('user.teammst.index',compact('Teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Users = User_Organisation::selectRaw('user_master_id')
                    ->where('organization_master_id',Auth::user()->organization_master_id)->get();
        $Owners = User_Master::selectRaw('id,CONCAT(first_name," ",last_name) AS Owner_Name')
                    ->whereIn('id',$Users)->get();
//        dd($Owners);
        return view('user.teammst.add', compact('Owners'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd(request()->all());
        $this->validate($request,[
            'team_name' => 'required|max:190',
            'team_owner_id' => 'required|numeric',
            'team_logo' => 'max:190',
            'team_type' => 'required|max:190',
            'order_id' => 'required|numeric',
            'owner_id' => 'required|numeric',
        ]);
        
        $Team = new Team_Master;
        $Team->team_name = request('team_name');
        $Team->team_owner_id = request('team_owner_id');
        $Team->team_type = request('team_type');
        $Team->order_id = request('order_id');
        $Team->owner_id = request('owner_id');
//        dd($Team->id);
        if($request->hasFile('image')){
//            dd('Image');
            $image = $request->file('image');
            $data = $_POST['imagedata'];
            
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $filename = time().base64_encode($Team->id).'.'.$image->getClientOriginalExtension();
            $data = base64_decode($data);
            file_put_contents(public_path('images/'. $filename), $data);
            
            $Team->team_logo = $filename;
//            dd($Team->team_logo);
//            $request->session()->put('user_img', $Team->team_logo);
        }
        $Team->save();
        return redirect()->route('team.index');
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
        $Users = User_Organisation::selectRaw('user_master_id')
                    ->where('organization_master_id',Auth::user()->organization_master_id)->get();
        $Owners = User_Master::selectRaw('id,CONCAT(first_name," ",last_name) AS Owner_Name')
                    ->whereIn('id',$Users)->get();
        $Team = Team_Master::find($id);
        return view('user.teammst.edit',compact('Team','Owners'));
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
            'team_name' => 'required|max:190',
            'team_owner_id' => 'required|numeric',
            'team_logo' => 'max:190',
            'team_type' => 'required|max:190',
            'order_id' => 'required|numeric',
            'owner_id' => 'required|numeric',
        ]);
        
        $Team = Team_Master::find($id);
        $Team->team_name = request('team_name');
        $Team->team_owner_id = request('team_owner_id');
        $Team->team_type = request('team_type');
        $Team->order_id = request('order_id');
        $Team->owner_id = request('owner_id');
//        dd(request('image'));
        if($request->hasFile('image')){
            dd('Image');
            $image = $request->file('image');
            $data = $_POST['imagedata'];
            
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $filename = time().base64_encode($Team->id).'.'.$image->getClientOriginalExtension();
            $data = base64_decode($data);
            file_put_contents(public_path('images/'. $filename), $data);
            
            $Team->team_logo = $filename;
//            dd($Team->team_logo);
//            $request->session()->put('user_img', $Team->team_logo);
        }
        $Team->save();
        return redirect()->route('team.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Team = Team_Master::find($id);
        if($Team){
            $Team->delete();
        }else{
            dd('Not Exist');
        }
        return redirect()->route('team.index');
    }
}
