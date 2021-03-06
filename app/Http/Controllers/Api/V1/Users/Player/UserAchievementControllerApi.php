<?php

namespace App\Http\Controllers\Web\Users\Player;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

use App\Model\UserMaster_model;
use App\Model\UserAchievement_model;
use App\Model\OrganisationMaster_model;

class UserAchievementControllerApi extends Controller{
    protected $UserMaster_model;
    protected $UserAchievement_model;
    protected $OrganisationMaster_model;
    
    public function __construct(){
        $this->middleware('auth:admin',['only'=>['index']]);
        $this->middleware('auth',['except'=>['index']]);
        $this->_initModel();
    }
    
    protected function _initModel(){
        $this->UserMaster_model = new UserMaster_model();
        $this->UserAchievement_model = new UserAchievement_model();
        $this->OrganisationMaster_model = new OrganisationMaster_model();
    }
    
    public function listAchievement(){
        $User_Achieve = $this->UserMaster_model->getAll();
        if($User_Achieve){
            $output = array('status' => 200 ,'msg' => 'Sucess','data' => $User_Achieve);
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail');
        }
        return response()->json($output);
    }

    public function addAchievement(Request $request){
        $this->validate($request,[
            'title' => 'required|max:190',
            'location' => 'required|max:190',
            '$organization_master_id' => 'required|numeric|min:1',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
        ]);
        $user_master_id = 1; //have to find
        $request->request->add(['user_master_id' => $user_master_id]);
        $User_Achieve = $this->UserAchievement_model->SaveAchievement($request);
        if($User_Achieve){
            $output = array('status' => 200 ,'msg' => 'Sucess');
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail');
        }
        return response()->json($output);
    }

    public function updateAchievement(Request $request) {
        $this->validate($request,[
            'id' => 'required|numeric|min:1',
            '$organization_master_id' => 'required|numeric|min:1',
            'title' => 'required|max:190',
            'location' => 'required|max:190',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
        ]);
        $user_master_id = 1; //have to find
        $request->request->add(['user_master_id' => $user_master_id,'update' => 1,'id' => $request->id]);
        $User_Achieve = $this->UserAchievement_model->SaveUserBio($request);
        if($User_Achieve){
            $output = array('status' => 200 ,'msg' => 'Sucess');
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail');
        }
        return response()->json($output);
    }

    public function deleteAchievement(Request $request){
        $this->validate($request,[
            'id' => 'required|numeric|min:1',
        ]);
        $User_Achieve = $this->UserAchievement_model->getById($request->id);
        if($User_Achieve){
            $User_Achieve->delete();
            $output = array('status' => 200 ,'msg' => 'Sucess');
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail');
        }
        return response()->json($output);
    }
}
