<?php

namespace App\Http\Controllers\Api\V1\Users\Player;

use Auth;
use Image;
use Storage;
use Session;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\UserCricketProfile_model;
use App\Model\UserMaster_model;


class UserCricketProfileControllerApi extends Controller
{
    protected $UserMaster_model;
    protected $UserCricketProfile_model;

    public function __construct(){
//        $this->middleware('auth:admin',['only'=>['index']]);
//        $this->middleware('auth',['except'=>['index']]);
        $this->_initModel();
    }
    
    protected function _initModel(){
        $this->UserMaster_model = new UserMaster_model();
        $this->UserCricketProfile_model = new UserCricketProfile_model();
    }
    
    public function listCriProfile(Request $request){
        $validator = Validator::make($request->all(), [
            'user_master_id' => 'min:1',
        ]);
        if(!$validator->fails()){
            $where = null;
            if(isset($request->user_master_id) && $request->user_master_id){
                $where['user_master_id'] = $request->user_master_id;
            }
            $Cri_Profiles = $this->UserCricketProfile_model->getAllFilter($where);
            if($Cri_Profiles){
                $output = array('status' => 200 ,'msg' => 'Sucess','data' => $Cri_Profiles);
            }else{
                $output = array('status' => 400 ,'msg' => 'Transection Fail');
            }
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail','errors' => $validator->errors()->all());
        }
        return response()->json($output);
    }
    
    public function addCriProfile(Request $request){
        $validator = Validator::make($request->all(), [
            'your_role' => 'required|numeric',
            'batsman_style' => 'required|in:Lefthand,Righthand',
            'batsman_order' => 'required|numeric',
            'bowler_style' => 'required|in:Lefthand,Righthand',
            'player_type' => 'required|max:255',
            'description' => 'required|max:255',
            // 'image'=>'required',
            // 'mime'=>'required|in:png,jpg,gif,jpeg'
        ]);
        if(!$validator->fails()){

            // $data = $request->image;
            // $mime_data = $request->mime;
            // $rand_str = str_random(40);
            // $filename = "$rand_str.$mime_data";
            // $data = base64_decode($data);
            // file_put_contents(public_path('images/'. $filename), $data);
            // $request->request->add(['display_img' => $filename]);

            $user = JWTAuth::parseToken()->authenticate();
            $request->request->add(['user_master_id' => $user->user_master_id]);
            $User_Cri_Profile = $this->UserCricketProfile_model->SaveCriProfile($request);
            if($User_Cri_Profile){
                $output = array('status' => 200 ,'msg' => 'Sucess','data' => $User_Cri_Profile);
            }else{
                $output = array('status' => 400 ,'msg' => 'Transection Fail');
            }
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail','errors' => $validator->errors()->all());
        }
        return response()->json($output);
    }

    public function updateCriProfile(Request $request){
        $validator = Validator::make($request->all(), [
            'user_master_id' => 'min:1',
            'your_role' => 'required|numeric',
            'batsman_style' => 'required|in:Lefthand,Righthand',
            'batsman_order' => 'required|numeric',
            'bowler_style' => 'required|in:Lefthand,Righthand',
            'player_type' => 'required|max:255',
            'description' => 'required|max:255',
            // 'image'=>'required',
            // 'mime'=>'required|in:png,jpg,gif,jpeg'
        ]);
        if(!$validator->fails()){

            if(isset($request->image) && isset($request->mime) && $request->image && $request->mime){
                $data = $request->image;
                $mime_data = $request->mime;
                $rand_str = str_random(40);
                $filename = "$rand_str.$mime_data";
                $data = base64_decode($data);
                file_put_contents(public_path('images/'. $filename), $data);
                $request->request->add(['display_img' => $filename]);
            }
            $user = JWTAuth::parseToken()->authenticate();
            $user = $this->UserCricketProfile_model->getCriProfileByUserMasterId($request->user_master_id);
            if($user){
                $request->request->add(['user_master_id' => $user->user_master_id,'update' => 1,'id' => $user->id]);
                $User_Cri_Profile = $this->UserCricketProfile_model->SaveCriProfile($request);
                if($User_Cri_Profile){
                    $output = array('status' => 200 ,'msg' => 'Sucess','data' => $User_Cri_Profile);
                }else{
                    $output = array('status' => 400 ,'msg' => 'Transection Fail');
                }
            }else{
                $output = array('status' => 400 ,'msg' => 'Transection Fail');
            }
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail','errors' => $validator->errors()->all());
        }
        return response()->json($output);
    }

    public function deleteCriProfile(Request $request){
        $validator = Validator::make($request->all(), [
            'user_master_id' => 'required|numeric|min:1',
        ]);
        if(!$validator->fails()){
            $user_exists = $this->UserCricketProfile_model->getCriProfileByUserMasterId($request->user_master_id);
            if($user_exists){
                $User = $this->UserCricketProfile_model->getById($user_exists->id);
                $User->delete();
                $output = array('status' => 200 ,'msg' => 'Sucess');
            }else{
                $output = array('status' => 400 ,'msg' => 'Transection Fail');
            }
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail','errors' => $validator->errors()->all());
        }
        return response()->json($output);
    }
}
