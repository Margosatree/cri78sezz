<?php

namespace App\Model;
use App\Model\BaseModel\Tournament_Details;

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
        
        public function deleteRuleByRuleId($tour_id,$id) {
            return Tournament_Details::where(['tournament_id'=>$tour_id,'rule_id'=>$id])->delete();
        }
        
        public function getTourDetById($id) {
            return Tournament_Details::selectRaw('*')->where('tournament_id',$id)->get();
        }
        public function getTourDetByIdRuleId($tour_id,$rule_id) {
            return Tournament_Details::selectRaw('*')->where('tournament_id',$tour_id)->where('rule_id',$rule_id)->get()->first();
        }
        public function getRulesByTourId($tour_id) {
            return Tournament_Details::selectRaw('rule_id')
                    ->where('tournament_id',$tour_id)->get();
        }
        
        public function SaveTourDetail($request) {
            if(isset($request->update) && $request->update == 1){
                $Tour_Detail = Tournament_Details::where('tournament_id', $request->tournament_id)->where('rule_id', $request->rule_id);
                $Tour_Detail->update([
                    'rule_id' => $request->rule_id,
                    'specification' => $request->specification,
                    'value' => $request->value,
                    'range_from' => $request->range_from,
                    'range_to' => $request->range_to,
                ]);
            }else{
                $Tour_Detail = new Tournament_Details;
                $Tour_Detail->tournament_id = $request->tournament_id;
                $Tour_Detail->rule_id = $request->rule_id;
                $Tour_Detail->specification = $request->specification;
                $Tour_Detail->value = $request->value;
                $Tour_Detail->range_from = $request->range_from;
                $Tour_Detail->range_to = $request->range_to;
                $Tour_Detail->save();
            }
            return $Tour_Detail;
        }
}