<?php

namespace App\Http\Controllers\Api\V1\CricketDetail\Team;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use Validator;
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

    public function __construct(){
        $this->_initModel();
    }

    protected function _initModel(){
        $this->TeamMaster_model = new TeamMaster_model();
        $this->UserMaster_model = new UserMaster_model();
        $this->UserOrganisation_model = new UserOrganisation_model();
    }
    
    public function listTeam(Request $request){
        $user = JWTAuth::parseToken()->authenticate();
            $organization_master_id = $user->organization_master_id;
        $Teams = $this->TeamMaster_model->getTeamDetail($organization_master_id);
        if($Teams){
            $output = array('status_code' => 200 ,'message' => 'Sucess','data' => $Teams);
        }else{
            $output = array('status_code' => 400 ,'message' => 'Transection Fail');
        }
        return response()->json($output,$output['status_code']);
    }
    
    public function addTeam(Request $request){
        $validator = Validator::make($request->all(), [
            'team_name' => 'required|max:190',
            'tournament_id' => 'required|numeric|min:1',
            'team_owner_id' => 'required|numeric|min:1',
            'team_type' => 'required|max:190',
            'order_id' => 'required|numeric|min:1',
            'owner_id' => 'required|numeric|min:1',
            'image'=>'required',
            'mime'=>'required|in:png,jpg,gif,jpeg'
        ]);
        
        if(!$validator->fails()){
            $Team_name = $this->TeamMaster_model->TeamNameExistsByOwner($request->owner_id,$request->team_name);
            if(!$Team_name){
                $data = $request->image;
                $mime_data = $request->mime;
                $rand_str = str_random(40);
                $filename = "$rand_str.$mime_data";
                $data = base64_decode($data);
                file_put_contents(public_path('images/'. $filename), $data);
                $request->request->add(['team_logo' => $filename]);
                $Team = $this->TeamMaster_model->SaveTeam($request);
                if($Team){
                    $output = array('status_code' => 200 ,'message' => 'Sucess');
                }else{
                    $output = array('status_code' => 400 ,'message' => 'Transection Fail');
                }
            }else{
                $output = array('status_code' => 400 ,'message' => 'Team Name Already Exist');
            }
        }else{
            $output = array('status_code' => 400 ,'message' => 'Transection Fail','errors' => $validator->errors()->all());
        }
        return response()->json($output,$output['status_code']);
    }

    public function updateTeam(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|min:1',
            'team_name' => 'required|max:190',
            'team_owner_id' => 'required|numeric',
            'team_type' => 'required|max:190',
            'order_id' => 'required|numeric',
            'owner_id' => 'required|numeric',
            'image'=>'string',
            'mime'=>'in:png,jpg,gif,jpeg'
        ]);

        if(!$validator->fails()){
            $Team_name = $this->TeamMaster_model->TeamNameExistsByOwner($request->owner_id,$request->team_name);
            if(!$Team_name){
                if(isset($request->image) && isset($request->mime) && $request->image && $request->mime){
                        $data = $request->image;
                        $mime_data = $request->mime;
                        $rand_str = str_random(40);
                        $filename = "$rand_str.$mime_data";
                        $data = base64_decode($data);
                        file_put_contents(public_path('images/'. $filename), $data);
                        $params['team_logo'] = $filename;
                        $request->request->add(['team_logo' => $filename]);
                }
                
                $user = JWTAuth::parseToken()->authenticate();
                $request->request->add(['update' => 1,'id' => $request->id,'updated_by' => $user->user_master_id]);
                $Team = $this->TeamMaster_model->SaveTeam($request);
                if($Team){
                    $output = array('status_code' => 200 ,'message' => 'Sucess');
                }else{
                    $output = array('status_code' => 400 ,'message' => 'Transection Fail');
                }
            }else{
                $output = array('status_code' => 400 ,'message' => 'Team Name Already Exist');
            }
        }else{
            $output = array('status_code' => 400 ,'message' => 'Transection Fail','errors' => $validator->errors()->all());
        }
        return response()->json($output,$output['status_code']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteTeam(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|min:1|exists:team_master,id',
        ]);
        if(!$validator->fails()){
            $user = JWTAuth::parseToken()->authenticate();
            $request->request->add(['update' => 1,'deleted_by' => $user->user_master_id]);
            $this->TeamMaster_model->SaveTeam($request);
            $Team = $this->TeamMaster_model->deleteById($request->id);
            if($Team){
                $output = array('status_code' => 200 ,'message' => 'Sucess');
            }else{
                $output = array('status_code' => 400 ,'message' => 'Transection Fail');
            }
        }else{
            $output = array('status_code' => 400 ,'message' => 'Transection Fail','errors' => $validator->errors()->all());
        }
        return response()->json($output,$output['status_code']);
    }

    public function listMyTeam(){
        $user = JWTAuth::parseToken()->authenticate();
        $datas = ['id'=>$user->user_master_id];
        $team_member = $this->TeamMembers_model->getByAny($datas);
        if($team_member){
            $response = array('status' => 200 ,'msg' => 'success','data' => $team_member);
        }else{
            $response = array('status' => 404 ,'msg' => 'transation_failed');
        }
        return response()->json($response,$response['status']);
    }
}
