<?php

namespace App\Model;
use App\Model\BaseModel\TournamentUser;

class TournamentUser_model {

        public function __construct(){
            //parent::__construct();
        }
        
        public function getAll() {
            return TournamentUser::all();
        }
        public function getById($id) {
            return TournamentUser::find($id);
        }
        public function getAllByGet(){
            return TournamentUser::get();
        }
        
        public function allCondtion($where_data){
            return TournamentUser::where($where_data)->get();
        }
    
        public function insertUserTour($insert_data){
            return TournamentUser::insert($insert_data);
        }

        public function removeUserFromTour($id){
           $delete_data =  $this->getById($id);
           return $delete_data->delete();
        }

        public function getUserByTourDetails($tour_id){
            return TournamentUser::leftJoin('tournament_master AS tm'
                                        ,'tm.id','=','tournament_users.tour_id')
                                 ->leftJoin('user_masters AS um'
                                        ,'um.id','=','tournament_users.user_id')
                                 ->where('tournament_users.tour_id','=',$tour_id)
                                 ->get();
        }


        
        
        
}