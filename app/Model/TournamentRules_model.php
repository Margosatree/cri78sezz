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
    
    public function deleteById($id) {
        return $this->getById($id)->delete();
    }
    
    public function SaveRule($request) {
        if(isset($request->update) && $request->update == 1){
            $Rules = Tournament_Rules::find($request->id);
        }else{
            $Rules = new Tournament_Rules;
        }
        if(isset($request->name) && $request->name){
            $Rules->name = $request->name;
        }
        if(isset($request->specification) && $request->specification){
            $Rules->specification = $request->specification;
        }
        if(isset($request->user_master_id) && $request->user_master_id){
            $Rules->user_master_id = $request->user_master_id;
        }
        if(isset($request->value) && $request->value){
            $Rules->value = $request->value;
        }
        if(isset($request->range_from) && $request->range_from){
            $Rules->range_from = $request->range_from;
        }
        if(isset($request->range_to) && $request->range_to){
            $Rules->range_to = $request->range_to;
        }
        if(isset($request->deleted_by) && $request->deleted_by){
            $Rules->deleted_by = $request->deleted_by;
        }
        if(isset($request->updated_by) && $request->updated_by){
            $Rules->updated_by = $request->updated_by;
        }
        $Rules->save();
        return $Rules;
    }
}