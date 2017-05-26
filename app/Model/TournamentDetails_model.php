<?php

namespace App\Model;
use App\Tournament_Details;

class TournamentDetails_model {

	public function __construct(){
		//parent::__construct();
	}
        
        public function getById($id) {
            return Tournament_Master::find($id);
        }
        
        public function deleteById($id) {
            return Tournament_Details::where(['tournament_id'=>$id])->delete();
        }
        
        public function getTourDetById($id) {
            return Tournament_Details::selectRaw('*')->where('tournament_id',$id)->get();
        }
        public function getTourDetByIdRuleId($tour_id,$rule_id) {
            return Tournament_Details::selectRaw('*')->where('tournament_id',$tour_id)->where('rule_id',$rule_id)->get()->first();
        }
        
        public function SaveTourDetail($data) {
            if(isset($data['id']) && $data['id'] > 0){
                $Tour_Detail = Tournament_Details::find($data['id']);
            }else{
                $Tour_Detail = new Tournament_Details;
            }
            $Tour_Detail->tournament_id = $data['tournament_id'];
            $Tour_Detail->rule_id = $data['rule_id'];
            $Tour_Detail->specification = $data['specification'];
            $Tour_Detail->value = $data['value'];
            $Tour_Detail->range_from = $data['range_from'];
            $Tour_Detail->range_to = $data['range_to'];
            $Tour_Detail->save();
            
            return $Tour_Detail;
        }
}