<?php

namespace App\Http\Controllers\Web\Users\Player;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\UserMaster_model;

class UsersBioController extends Controller
{

    protected $UserMaster_model;
    
    public function __construct(){
        $this->middleware('auth:admin',['only'=>['index']]);
        $this->middleware('auth',['except'=>['index']]);
        $this->_initModel();
    }

    protected function _initModel(){
        $this->UserMaster_model = new UserMaster_model();
    }
    
    public function listUsersBio(){
        $User_Bios = $this->getAll();
        if($User_Bios){
            $output = array('status' => 200 ,'msg' => 'sucess','data' => $User_Bios);
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail');
        }
        return response()->json($output);
    }

    public function addUsersBio(Request $request){
        $this->validate(request(), [
            'first_name' => 'required|max:50|alpha',
            'middle_name' => 'required|max:50|alpha',
            'last_name' => 'required|max:50|alpha',
            'date_of_birth' => 'required|date|before:'.date('Y-m-d', strtotime('-5 year')),
            'gender' => 'in:female,male',
            'physically_challenged' => 'in:no,yes',
        ]);
        $User_Bio = $this->UserMaster_model->SaveUserBio($request);
        if($User_Bio){
            $output = array('status' => 200 ,'msg' => 'sucess','data' => $User_Bio);
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail');
        }
        return response()->json($output);
    }

    public function addUsersBioInfo(Request $request){
        $this->validate(request(), [
            'address' => 'required|max:255',
            'suburb' => 'required|max:255',
            'city' => 'required|max:255',
            'state' => 'required|max:255',
            'country' => 'required|max:255',
            'pin' => 'required|digits:6|numeric',
        ]);
        $User_Bio = $this->UserMaster_model->SaveUserAddress($request);
        if($User_Bio){
            $output = array('status' => 200 ,'msg' => 'sucess','data' => $User_Bio);
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail');
        }
        return response()->json($output);
    }

    public function updateUsersBio(Request $request){
        $callfrom = "";
        if($request->first_name || $request->middle_name || $request->last_name ||
           $request->date_of_birth || $request->gender || $request->physically_challenged){
            $this->validate(request(), [
                'id' => 'numeric|min:1',
                'first_name' => 'required|max:255',
                'middle_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'date_of_birth' => 'required|date',
                'gender' => 'required|in:female,male,others',
                'physically_challenged' => 'required|in:no,yes',
            ]);
            $callfrom = 'info';
        }else{
            $this->validate(request(), [
                'id' => 'numeric|min:1',
                'address' => 'required|max:255',
                'suburb' => 'required|max:255',
                'city' => 'required|max:255',
                'state' => 'required|max:255',
                'country' => 'required|max:255',
                'pin' => 'required|digits:6|numeric',
            ]);
        }
        
        $Bio = User_Master::find($request->id);
        if($Bio){
            if($callfrom == 'info'){
                $request->request->add([ 'update' => 1,'id' => $request->id ]);
                $User_Bio = $this->UserMaster_model->SaveUserBio($request);
                $output = array('status' => 200 ,'msg' => 'sucess','data' => $User_Bio);
            }else{
                $request->request->add([ 'update' => 1,'id' => $request->id ]);
                $User_Address = $this->UserMaster_model->SaveUserAddress($request);
                $output = array('status' => 200 ,'msg' => 'sucess','data' => $User_Address);
            }
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail');
        }
        return response()->json($output);
    }
}
