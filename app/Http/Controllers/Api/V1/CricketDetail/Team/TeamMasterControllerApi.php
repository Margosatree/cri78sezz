<?php

namespace App\Http\Controllers\Web\CricketDetail\Team;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

use App\Model\TeamMaster_model;
use App\Model\UserMaster_model;
use App\Model\UserOrganisation_model;

class TeamMasterControllerApi extends Controller
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
    
    public function listTeam(Request $request){
        $user_master_id = 1;//have to find user id from login
        $Teams = $this->TeamMaster_model->getTeamDetail($user_master_id);
        if($Teams){
            $output = array('status' => 200 ,'msg' => 'Sucess','data' => $Teams);
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail');
        }
        return response()->json($output);
    }
    
    public function addTeam(Request $request){
        $this->validate($request,[
            'team_name' => 'required|max:190',
            'team_owner_id' => 'required|numeric',
            'team_logo' => 'max:190',
            'team_type' => 'required|max:190',
            'order_id' => 'required|numeric',
            'owner_id' => 'required|numeric',
        ]);

//        if($request->hasFile('image')){
//            $image = $request->file('image');
//            $data = $_POST['imagedata'];
//
//            list($type, $data) = explode(';', $data);
//            list(, $data)      = explode(',', $data);
//            $filename = time().base64_encode($Team->id).'.'.$image->getClientOriginalExtension();
//            $data = base64_decode($data);
//            $request->request->add(['team_logo' => $filename]);
//            file_put_contents(public_path('images/'. $filename), $data);
//        }
        $Team = $this->TeamMaster_model->SaveTeam($request);
        if($Team){
            $output = array('status' => 200 ,'msg' => 'Sucess','data' => $Team);
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail');
        }
        return response()->json($output);
    }

    public function updateTeam(Request $request){
        $this->validate($request,[
            'id' => 'required|numeric|min:1',
            'team_name' => 'required|max:190',
            'team_owner_id' => 'required|numeric',
            'team_logo' => 'max:190',
            'team_type' => 'required|max:190',
            'order_id' => 'required|numeric',
            'owner_id' => 'required|numeric',
        ]);
//        if($request->hasFile('image')){
//            $image = $request->file('image');
//            $data = $_POST['imagedata'];
//
//            list($type, $data) = explode(';', $data);
//            list(, $data)      = explode(',', $data);
//            $filename = time().base64_encode($Team->id).'.'.$image->getClientOriginalExtension();
//            $data = base64_decode($data);
//            file_put_contents(public_path('images/'. $filename), $data);
//        }
        $request->request->add(['update' => 1,'id' => $request->id]);
        $Team = $this->TeamMaster_model->SaveTeam($request);
        if($Team){
            $output = array('status' => 200 ,'msg' => 'Sucess','data' => $Team);
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail');
        }
        return response()->json($output);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteTeam(Request $request){
        $this->validate($request,[
            'id' => 'required|numeric|min:1',
        ]);
        $Team = $this->TeamMaster_model->deleteById($request->id);
        if($Team){
            $output = array('status' => 200 ,'msg' => 'Sucess');
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail');
        }
        return response()->json($output);
    }
}
