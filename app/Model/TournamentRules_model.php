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
    
    public function SaveRule($request) {
        if(isset($request->update) && $request->update == 1){
            $Rules = Rule_Master::find($request->id);
        }else{
            $Rules = new Tournament_Details;
        }
        $Rules->name = $request->name;
        $Rules->specification = $request->specification;
        $Rules->value = $request->value;
        $Rules->range_from = $request->range_from;
        $Rules->range_to = $request->range_to;
        $Rules->save();
        return $Rules;
    }
}