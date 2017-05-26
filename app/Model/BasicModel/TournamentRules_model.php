<?php

namespace App\Model;
use App\Tournament_Rules;

class TournamentRules_model {

	public function __construct(){
		//parent::__construct();
	}
        
        public function getAll() {
            return Tournament_Rules::all();
        }
        
        public function getById($id) {
            return Tournament_Rules::find($id);
        }
}