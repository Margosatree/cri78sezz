<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User_Master;
use App\Tournament_Details;
use App\Tournament_Master;
use App\Tournament_Rules;
use App\Organisation_Master;
class TournamentMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $Tournaments = Tournament_Master::where('organization_master_id',Auth::user()->organization_master_id);
        $Tournaments = Tournament_Master::selectRaw('*')->where('organization_master_id',Auth::user()->user_master_id)->get();
        return view('user.tourmst.index',compact('Tournaments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.tourmst.add');
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
            'tournament_name' => 'required|max:190',
            'tournament_location' => 'required|max:190',
            'tournament_logo' => 'max:190',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
            'reg_start_date' => 'required|date|before:end_date',
            'reg_end_date' => 'required|date|after:start_date',
        ]);
        
        $Tournament = new Tournament_Master;
        $Tournament->tournament_name = request('tournament_name');
        $Tournament->tournament_location = request('tournament_location');
        $Tournament->tournament_logo = request('name');
        $Tournament->organization_master_id = Auth::user()->organization_master_id;
        $Tournament->start_date = request('start_date');
        $Tournament->end_date = request('end_date');
        $Tournament->reg_start_date = request('reg_start_date');
        $Tournament->reg_end_date = request('reg_end_date');
        if($request->hasFile('image')){
//            dd('Image');
            $image = $request->file('image');
            $data = $_POST['imagedata'];
            
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $filename = time().base64_encode($Tournament->id).'.'.$image->getClientOriginalExtension();
            $data = base64_decode($data);
            file_put_contents(public_path('images/'. $filename), $data);
            
            $Tournament->tournament_logo = $filename;
//            $request->session()->put('user_img', $Tournament->tournament_logo);
        }
        $Tournament->save();
        return redirect()->route('tourmst.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Tournament = Tournament_Master::find($id);
        return view('user.tourmst.edit',compact('Tournament'));
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
            'tournament_name' => 'required|max:190',
            'tournament_location' => 'required|max:190',
            'tournament_logo' => 'max:190',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
            'reg_start_date' => 'required|date|before:end_date',
            'reg_end_date' => 'required|date|after:start_date',
        ]);
        $Tournament = Tournament_Master::find($id);
        $Tournament->tournament_name = request('tournament_name');
        $Tournament->tournament_location = request('tournament_location');
        $Tournament->start_date = request('start_date');
        $Tournament->end_date = request('end_date');
        $Tournament->reg_start_date = request('reg_start_date');
        $Tournament->reg_end_date = request('reg_end_date');
//        dd(request()->all());
        if($request->hasFile('image')){
            $image = $request->file('image');
            $data = $_POST['imagedata'];
            
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $filename = time().base64_encode($Tournament->id).'.'.$image->getClientOriginalExtension();
            $data = base64_decode($data);
            file_put_contents(public_path('images/'. $filename), $data);
            
            $Tournament->tournament_logo = $filename;
//            $request->session()->put('user_img', $Tournament->tournament_logo);
        }
        $Tournament->save();
        return redirect()->route('tourmst.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Tour_Dets = Tournament_Master::find($id);
        if($Tour_Dets){
            $Tour_Dets->delete();
            Tournament_Details::where(['tournament_id'=>$id])->delete();
        }else{
            dd('Not Exist');
        }
        return redirect()->route('tourmst.index');
        
    }
}
