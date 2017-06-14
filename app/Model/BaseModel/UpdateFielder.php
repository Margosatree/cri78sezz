<?php

namespace App\Model\BaseModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Model\BaseModel\Balldata;
use App\Model\BaseModel\Fielder;

class UpdateFielder extends Model
{
    use Notifiable;
    protected $table = 'fielder_master';
    protected $primaryKey = 'trans_id';
    protected $guarded = [];
    public $timestamps = false;
    protected $Balldata_Model;
    protected $Fielder_Model;

    public function __construct() {
        $this->Balldata_Model = new Balldata();
        $this->Fielder_Model = new Fielder(); 
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
        if($Fielder_Summery > 0)
        {	
    $where_data1 = [
            'match_id' => $request->match_id,            
            'innings' => $request->innings,
            'fielder_id' => $request->old_fielder_id           
        	]; 
    $fielder_exists = $this->Fielder_Model->isFielderExists($where_data1);
        	
        	if($fielder_exists != null){
        	$flag =$this->Balldata_Model->isFielderRecordExists($where_data1);
            //dd($flag);
        	if($flag != null){

        	$Fielder_Summery = $this->Balldata_Model->getFilderSummery($where_data1);

            //dd("Hello".$Fielder_Summery);
            $this->Fielder_Model->saveFielderMaster($fielder_exists,$Fielder_Summery);
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
            //dd($result);
            return $result;
        }
    	
    }
}
