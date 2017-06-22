<?php

namespace App\Model;
use App\Model\BaseModel\UpdateFielder;
use App\Model\Balldata_model;
use App\Model\Fielder_model;
class UpdateFielder_model {
    protected $Balldata_Model;

    public function __construct() {
        $this->Balldata_Model = new Balldata_model();
        $this->Fielder_Model = new Fielder_model(); 
    }

    public function calFielderChanger($request){
    	$where_array = [
            'match_id' => $request->match_id,            
            'innings' => $request->innings,
        ];        
        $Fielder_Summery = $this->Balldata_Model->overwiseFielderInfo($where_array);
        if(count($Fielder_Summery) > 0)
        {
        	return response()->json($Fielder_Summery);
        }

        return 'No data exist for the given Match Inning';        
    }

    public function fielderChangeMaker($request){
    	$where_array = [
            'match_id' => $request->match_id,            
            'innings' => $request->innings,
            'old_fielder_id' => $request->old_fielder_id,
            'new_fielder_id' => $request->new_fielder_id,
            'ball_no' => $request->ball_no
        ]; 

        $Fielder_Summery = $this->Balldata_Model->updateFielderInfo($where_array);
        //$bowler_obj = new Bowler();
       // dd($Bowler_Summery);
        if($Fielder_Summery > 0)
        {	
        	$where_data1 = [
            'match_id' => $request->match_id,            
            'innings' => $request->innings,
            'fielder_id' => $request->old_fielder_id           
        	]; 

        	$fielder_exists = $this->Fielder_Model->isFielderExists($where_data1);
        	//dd($bowler_exists);
        	if($fielder_exists != null){
        	$flag =$this->Balldata_Model->isFielderRecordExists($where_data1);
        	if($flag != null){
        	$Fielder_Summery = $this->Balldata_Model->getFilderSummery($where_data1);
        	$this->Fielder_Model->saveFielderMaster(true,$Fielder_Summery);
        	}
        	else{
        	$fielder_drop = $this->Fielder_Model->dropFielder($where_data1);
        	}
            }
        	$where_data2 = [
	            'match_id' => $request->match_id,            
	            'innings' => $request->innings,
	            'fielder_id' => $request->new_fielder_id           
        	]; 

        	$fielder_exists = $this->Fielder_Model->isFielderExists($where_data2);
        	$Fielder_Summery = $this->Balldata_Model->getFilderSummery($where_data2);
        	$result = $this->Fielder_Model->saveFielderMaster($fielder_exists,$Fielder_Summery);
            return $result;
        }
    	
    }
}