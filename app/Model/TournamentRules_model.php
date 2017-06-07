<?php

namespace App\Model;
use App\Model\BaseModel\Tournament_Rules;

class TournamentRules_model {

	public function __construct(){
		//parent::__construct();
	}
        
        public function getAll() {
            return Tournament_Rules::all();
        }
        
        public function getAllNotIn($Rule_id) {
            return Tournament_Rules::selectRaw('*')->whereNotIn('id',$Rule_id)->get();
        }
        
        public function getById($id) {
            return Tournament_Rules::find($id);
        }
}