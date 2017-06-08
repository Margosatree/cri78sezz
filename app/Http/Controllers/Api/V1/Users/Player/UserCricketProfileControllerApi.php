<?php

namespace App\Http\Controllers\Web\Users\Player;

use Auth;
use Image;
use Storage;
use Session;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\UserCricketProfile_model;
use App\Model\UserMaster_model;


class UserCricketProfileControllerApi extends Controller
{
    protected $UserMaster_model;
    protected $UserCricketProfile_model;

    public function __construct(){
        $this->middleware('auth:admin',['only'=>['index']]);
        $this->middleware('auth',['except'=>['index']]);
        $this->_initModel();
    }
    
    protected function _initModel(){
        $this->UserMaster_model = new UserMaster_model();
        $this->UserCricketProfile_model = new UserCricketProfile_model();
    }
    
    function listCriProfile(Request $request){
        $Cri_Profiles = $this->UserCricketProfile_model->getAll();
        if($Cri_Profiles){
            $output = array('status' => 200 ,'msg' => 'Sucess','data' => $Cri_Profiles);
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail');
        }
        return response()->json($output);
    }
    
    public function addCriProfile(Request $request){
        $this->validate($request,[
            'your_role' => 'required|numeric',
            'batsman_style' => 'required|in:Lefthand,Righthand',
            'batsman_order' => 'required|numeric',
            'bowler_style' => 'required|in:Lefthand,Righthand',
            'player_type' => 'required|max:255',
            'description' => 'required|max:255',
            'image'=>'required|image',
//            'display_img' => 'required|max:255',
//            'is_completed' => 'required|numeric',
        ]);
//        if($request->hasFile('image')){
//            $image = $request->file('image');
//            $data = $_POST['imagedata'];
//            list($type, $data) = explode(';', $data);
//            list(, $data)      = explode(',', $data);
//            $filename = time().'.'.$image->getClientOriginalExtension();
//            $data = base64_decode($data);
//            file_put_contents(public_path('images/'. $filename), $data);
//            $params['display_img'] = $filename;
//            $request->request->add(['display_img' => $filename,]);
//            $request->session()->put('user_img', $params['display_img']);
//        }
        $user_master_id = 1;
        $request->request->add(['user_master_id' => $user_master_id]);
        $User_Cri_Profile = $this->UserCricketProfile_model->SaveCriProfile($request);
        if($User_Cri_Profile){
            $output = array('status' => 200 ,'msg' => 'Sucess','data' => $User_Cri_Profile);
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail');
        }
        return response()->json($output);
    }

    public function updateCriProfile(Request $request){
        $this->validate($request,[
            'your_role' => 'required|numeric',
            'batsman_style' => 'required|in:Lefthand,Righthand',
            'batsman_order' => 'required|numeric',
            'bowler_style' => 'required|in:Lefthand,Righthand',
            'player_type' => 'required|max:255',
            'description' => 'required|max:255',
            'image'=>'required|image',
//            'display_img' => 'required|max:255',
//            'is_completed' => 'required|numeric',
        ]);
//        if($request->hasFile('image')){
//            $image = $request->file('image');
//            $data = $_POST['imagedata'];
//            list($type, $data) = explode(';', $data);
//            list(, $data)      = explode(',', $data);
//            $filename = time().'.'.$image->getClientOriginalExtension();
//            $data = base64_decode($data);
//            file_put_contents(public_path('images/'. $filename), $data);
//            $request->request->add(['display_img' => $filename,]);
//            $request->session()->put('user_img', $params['display_img']);
//        }
        $user_master_id = 1;
        $request->request->add(['user_master_id' => $user_master_id,'update' => 1,'id' => $id]);
        $User_Cri_Profile = $this->UserCricketProfile_model->SaveCriProfile($request);
        if($User_Cri_Profile){
            $output = array('status' => 200 ,'msg' => 'Sucess','data' => $User_Cri_Profile);
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail');
        }
        return response()->json($output);
    }

    public function deleteCriProfile(Request $request){
        //
    }
}
