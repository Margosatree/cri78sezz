<?php

namespace App\Http\Controllers\Web\CricketDetail\Team;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Model\BasicModel\TeamMaster_model;
use App\Model\BasicModel\UserMaster_model;
use App\Model\BasicModel\UserOrganisation_model;

class TeamMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $TeamMaster_model;
    protected $UserMaster_model;
    protected $UserOrganisation_model;

    public function __constructor(){
        $this->_initModel();
    }

    protected function _initModel(){
        $this->TeamMaster_model = new TeamMaster_model();
        $this->UserMaster_model = new UserMaster_model();
        $this->UserOrganisation_model = new UserOrganisation_model();
    }
    public function index()
    {
        $master_id = Auth::user()->user_master_id;
        $Teams = $this->TeamMaster_model->getTeamDetail($master_id);
        return view('user.teammst.index',compact('Teams'));
    }

    public function create()
    {
        $id = Auth::user()->organization_master_id;
        $Users = $this->UserOrganisation_model->getOrgById($id);
        $Owners = $this->UserMaster_model->checkUserId($Users);
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
        $this->validate($request,[
            'team_name' => 'required|max:190',
            'team_owner_id' => 'required|numeric',
            'team_logo' => 'max:190',
            'team_type' => 'required|max:190',
            'order_id' => 'required|numeric',
            'owner_id' => 'required|numeric',
        ]);

        if($request->hasFile('image')){
            $image = $request->file('image');
            $data = $_POST['imagedata'];

            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $filename = time().base64_encode($Team->id).'.'.$image->getClientOriginalExtension();
            $data = base64_decode($data);
            file_put_contents(public_path('images/'. $filename), $data);

            $this->TeamMaster_model->insert($request,$filename);
        }
        
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
        $id = Auth::user()->organization_master_id;
        $Users = $this->UserOrganisation_model->getOrgById($id);
        $Owners = $this->UserMaster_model->checkUserId($Users);
        $Team = $this->TeamMaster_model->getAll($id);;
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
        // dd($request->hasFile('image'));
        $this->validate($request,[
            'team_name' => 'required|max:190',
            'team_owner_id' => 'required|numeric',
            'team_logo' => 'max:190',
            'team_type' => 'required|max:190',
            'order_id' => 'required|numeric',
            'owner_id' => 'required|numeric',
        ]);

        if($request->hasFile('image')){
            $image = $request->file('image');
            $data = $_POST['imagedata'];

            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $filename = time().base64_encode($Team->id).'.'.$image->getClientOriginalExtension();
            $data = base64_decode($data);
            file_put_contents(public_path('images/'. $filename), $data);
            $this->TeamMaster_model->insert($request,$filename,$id);
        }
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
        $this->TeamMaster_model->deleteById($id);
        return redirect()->route('team.index');
    }
}
