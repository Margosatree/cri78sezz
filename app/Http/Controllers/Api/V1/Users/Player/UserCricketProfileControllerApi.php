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
        $this->_initModel();
    }
    
    protected function _initModel(){
        $this->UserMaster_model = new UserMaster_model();
        $this->UserCricketProfile_model = new UserCricketProfile_model();
    }
    
    public function listCriProfile(Request $request){
        $Cri_Profiles = $this->UserCricketProfile_model->getAll();
        if($Cri_Profiles){
            $output = array('status' => 200 ,'msg' => 'Sucess','data' => $Cri_Profiles);
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail');
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
            'image'=>'required',
            'mime'=>'required|in:png,jpg,gif,jpeg'
//            'display_img' => 'required|max:255',
//            'is_completed' => 'required|numeric',
        ]);
        if(!$validator->fails()){

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
            
            $data = $request->image;
            $mime_data = $request->mime;
            $rand_str = str_random(40);

            $filename = "$rand_str.$mime_data";
            $data = base64_decode($data);
            file_put_contents(public_path('images/'. $filename), $data);
            $params['display_img'] = $filename;
            $request->request->add(['display_img' => $filename]);
            
            $user_master_id = 1;
            $request->request->add(['user_master_id' => $user_master_id]);
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
            'your_role' => 'required|numeric',
            'batsman_style' => 'required|in:Lefthand,Righthand',
            'batsman_order' => 'required|numeric',
            'bowler_style' => 'required|in:Lefthand,Righthand',
            'player_type' => 'required|max:255',
            'description' => 'required|max:255',
            'image'=>'required',
            'mime'=>'required|in:png,jpg,gif,jpeg'
//            'display_img' => 'required|max:255',
//            'is_completed' => 'required|numeric',
        ]);
        if(!$validator->fails()){
<<<<<<< HEAD
//        $data = $request->image;
           $mime_data = $request->mime;
           $rand_str = str_random(40);
           
           $filename = "$rand_str.$mime_data";
           $data = base64_decode($data);
           file_put_contents(public_path('images/'. $filename), $data);
           $params['display_img'] = $filename;
           $request->request->add(['display_img' => $filename]);
           
=======
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
            $mime_data = $request->mime;
            $rand_str = str_random(40);

            $filename = "$rand_str.$mime_data";
            $data = base64_decode($data);
            file_put_contents(public_path('images/'. $filename), $data);
            $params['display_img'] = $filename;
            $request->request->add(['display_img' => $filename]);
            
>>>>>>> 6dec3553beaff956f06e74f531f5e218ae5ec20c
            $user_master_id = 1;
            $request->request->add(['user_master_id' => $user_master_id,'update' => 1,'id' => $id]);
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

    public function deleteCriProfile(Request $request){
        //
    }
}
