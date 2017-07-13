<?php

namespace App\Model;
use App\Model\BaseModel\Tournament_Details;

class TournamentDetails_model {

    public function __construct(){
        //parent::__construct();
    }
        
        public function getById($id) {
            return Tournament_Details::find($id);
        }
        
        public function deleteById($id) {
            return Tournament_Details::where(['tournament_id'=>$id])->delete();
        }
        
        public function deleteRuleByRuleId($tour_id,$id) {
            return Tournament_Details::where(['tournament_id'=>$tour_id,'rule_id'=>$id])->delete();
        }
        
        public function getTourDetById($id) {
            return Tournament_Details::where('tournament_id',$id)->get();
        }
        public function getTourDetByIdRuleId($tour_id,$rule_id) {
            return Tournament_Details::where('tournament_id',$tour_id)->where('rule_id',$rule_id)->get()->first();
        }
        
        public function getRulesByTourId($tour_id) {
            return Tournament_Details::select('rule_id')
                    ->where('tournament_id',$tour_id)->get();
        }
        
        public function RulsExists($tour_id,$rule_id) {
            return Tournament_Details::where('tournament_id',$tour_id)
                    ->where('rule_id',$rule_id)->value('rule_id');
        }
        
        public function SaveTourDetail($request) {
//            dd(request()->all());
            if(isset($request->update) && $request->update == 1){
                $Tour_Detail = Tournament_Details::where('tournament_id', $request->tournament_id)->where('rule_id', $request->rule_id);
                $Tour_Detail->update([
                    'rule_id' => $request->rule_id,
                    'specification' => $request->specification,
                    'value' => $request->value,
                    'range_from' => $request->range_from,
                    'range_to' => $request->range_to,
                    'updated_by' => $request->updated_by,
                    'deleted_by' => $request->deleted_by,
                ]);
            }else{
                $Tour_Detail = new Tournament_Details;
                if(isset($request->tournament_id) && $request->tournament_id){
                    $Tour_Detail->tournament_id = $request->tournament_id;
                }
                if(isset($request->rule_id) && $request->rule_id){
                    $Tour_Detail->rule_id = $request->rule_id;
                }
                if(isset($request->specification) && $request->specification){
                    $Tour_Detail->specification = $request->specification;
                }
                if(isset($request->value) && $request->value){
                    $Tour_Detail->value = $request->value;
                }
                if(isset($request->range_from) && $request->range_from){
                    $Tour_Detail->range_from = $request->range_from;
                }
                if(isset($request->range_to) && $request->range_to){
                    $Tour_Detail->range_to = $request->range_to;
                }
                $Tour_Detail->save();
            }
            return $Tour_Detail;
        }
}