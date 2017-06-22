<?php

namespace App\Model;
use App\Model\BaseModel\Fielder;
use App\Model\Balldata_model;
class Fielder_model {

    protected $Balldata_Model;
    public function __construct() {
        $this->Balldata_Model = new Balldata_model();
    }
    
    public function isFielderExists($where_array){
        return Fielder::where($where_array)->value('trans_id');
    }
    
    public function saveFielderTickData($request){
        $where_array = [
            'match_id' => $request->match_id,
            'fielder_id' => $request->fielder_id,
            'innings' => $request->innings,
        ];
        $fielder_exists = $this->isFielderExists($where_array);
    $fielder_Summery = $this->Balldata_Model->getFilderSummery($where_array);
//        $Ball_Summery->bowlerid = $request->BatsmanID;
//        $Ball_Summery->fielderid = $request->fielder_id;
//        $Bat_Summery->BatsmanName = $request->username;
        $this->saveFielderMaster($fielder_exists,$fielder_Summery);
        
    }
    public function dropFielder($where_data1)
    {
        Fielder::where('match_id', $where_data1['match_id'])
        ->where('innings', $where_data1['innings'])
        ->where('fielder_id', $where_data1['fielder_id'])
        ->delete();
    }
    public function saveFielderMaster($update,$BowlerTick){
        if($BowlerTick != null){            
        if($update){
            $Fielder = Fielder::find($update);//Update
        }else{
            $Fielder = new Fielder();//Add
        }
        //dd($BowlerTick->match_id);
        $Fielder->match_id = $BowlerTick->match_id;
        //dd($Fielder->match_id);
        $Fielder->innings = $BowlerTick->innings;
        $Fielder->fielder_id = $BowlerTick->fielder_id;
        $Fielder->fielder_name = $BowlerTick->fielder_name;
        $Fielder->team_id = $BowlerTick->team_id;
        $Fielder->caught = $BowlerTick->caught;
        $Fielder->stumping = $BowlerTick->stumping;
        $Fielder->run_out = $BowlerTick->run_out;
        $Fielder->drop_catch = $BowlerTick->drop_catch;
        $Fielder->misfield = $BowlerTick->misfield;
        $Fielder->over_throw = $BowlerTick->over_throw;
        //$Fielder->batsman_id = $BowlerTick->batsman_id;
        //$Fielder->bowler_id = $BowlerTick->bowler_id;
        $data = $Fielder->save();
        return $data;
    }}
}