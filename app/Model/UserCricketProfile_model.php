<?php

namespace App\Model;
use App\Model\BaseModel\User_Cricket_Profile;

class UserCricketProfile_model {

    public function __construct(){
        //parent::__construct();
    }
        
        public function getAll() {
            return User_Cricket_Profile::all();
        }
        public function getAllFilter($where_array = false) {
            if($where_array){
                return User_Cricket_Profile::selectRaw('*')->where($where_array)->get();
            }else{
                return User_Cricket_Profile::all();
            }
        }
        
        public function getById($id) {
            return User_Cricket_Profile::find($id);
        }
        
        public function getCriProfileCountByUserMasterId($id) {
            return User_Cricket_Profile::selectRaw('count(id) as count')->where('user_master_id',$id)->get()->first();
        }
        public function getCriProfileByUserMasterId($id) {
            return User_Cricket_Profile::selectRaw('*')->where('user_master_id',$id)->get()->first();
        }
        
        public function SaveCriProfile($request) {
            if(isset($request->update) && $request->update == 1){
                $User_Cri_Profile = User_Cricket_Profile::find($request->id);
            }else{
                $User_Cri_Profile = new User_Cricket_Profile;
            }
            if(isset($request->user_master_id) && $request->user_master_id){
                $User_Cri_Profile->user_master_id = $request->user_master_id;
            }
            if(isset($request->your_role) && $request->your_role){
                $User_Cri_Profile->your_role = $request->your_role;
            }
            if(isset($request->batsman_style) && $request->batsman_style){
                $User_Cri_Profile->batsman_style = $request->batsman_style;
            }
            if(isset($request->physically_challenged) && $request->physically_challenged){
                $User_Cri_Profile->physically_challenged = $request->physically_challenged;
            }
            if(isset($request->batsman_order) && $request->batsman_order){
                $User_Cri_Profile->batsman_order = $request->batsman_order;
            }
            if(isset($request->bowler_style) && $request->bowler_style){
                $User_Cri_Profile->bowler_style = $request->bowler_style;
            }
            if(isset($request->player_type) && $request->player_type){
                $User_Cri_Profile->player_type = $request->player_type;
            }
            if(isset($request->description) && $request->description){
                $User_Cri_Profile->description = $request->description;
            }
            if(isset($request->display_img) && $request->display_img){
                $User_Cri_Profile->display_img = $request->display_img;
            }
            $User_Cri_Profile->save();
            return $User_Cri_Profile;
        }
}