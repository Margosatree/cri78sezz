<?php

namespace App\Model;
use App\User_Cricket_Profile;

class UserCricketProfile_model {

	public function __construct(){
		//parent::__construct();
	}
        
        public function getAll() {
            return User_Master::all();
        }
        
        public function getBioByUserMasterId($id) {
            return User_Cricket_Profile::selectRaw('*')->where('user_master_id', $id)->get()->first();
        }
        
        public function getCriProfileCountByUserMasterId($id) {
            return User_Cricket_Profile::selectRaw('count(id) as count')->where('user_master_id',$id)->get()->first();
        }
        
        public function SaveCriProfile($data) {
            if(isset($data['id']) && $data['id'] > 0){
                $User_Cri_Profile = User_Master::find($data['id']);
            }else{
                $User_Cri_Profile = new User_Master;
            }
            $User_Cri_Profile->user_master_id = Auth::user()->user_master_id;
            $User_Cri_Profile->your_role = $data['your_role'];
            $User_Cri_Profile->batsman_style = $data['batsman_style'];
            $User_Cri_Profile->batsman_order = $data['batsman_order'];
            $User_Cri_Profile->bowler_style = $data['bowler_style'];
            $User_Cri_Profile->player_type = $data['player_type'];
            $User_Cri_Profile->description = $data['description'];
            $User_Cri_Profile->save();
            return $User_Cri_Profile;
        }
}