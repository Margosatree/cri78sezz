<?php

namespace App\Model\BaseModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Model\BaseModel\Balldata;
use App\Model\BaseModel\Bowler;
class UpdateBowler extends Model
{
   use Notifiable;
    protected $table = 'bowler_master';
    protected $primaryKey = 'trans_id';
    protected $guarded = [];
    public $timestamps = false;
    protected $Balldata_Model;
    protected $Bowler_Model;
    public function __construct() {
        $this->Balldata_Model = new Balldata();
        $this->Bowler_Model = new Bowler(); 
    }

    public function calBowlerChanger($request){
    	$where_array = [
            'match_id' => $request->match_id,            
            'innings' => $request->innings,
        ];        
        $Bowler_Summery = $this->Balldata_Model->overwiseBallerInfo($where_array);
        if(count($Bowler_Summery) > 0)
        {
        	return response()->json($Bowler_Summery);
        }

        return 'No data exist for the given Match Inning';        
    }

    public function checkConstraint($request, $max_over, $max_match_overs)
    {   
        $checkPlaying = $this->Balldata_Model->checkInPlayers($request);
        //dd($checkPlaying);
        if(count($checkPlaying) > 0 && $checkPlaying->first()->playing == 'yes')
        { //dd("Hi");
            $over_count = $this->Balldata_Model->checkBowlerOversCount($request);

            if($over_count < $max_over)
            { 
                if($request->over_no > 1)
                {
                    $up = $this->Balldata_Model->checkUp($request);
                    if($up == false)
                    {
                      return ['status'=>400,'message'=>'Bowler have already bowled the previous over'];              
                    }      
                }

                if($request->over_no < $max_match_overs)
                {
                    $down = $this->Balldata_Model->checkDown($request);
                    if($down == false)
                    {
                        return ['status'=>400,'message'=>'Bowler have already bowled the next over'];
                    }
                }
              return ['status'=>200,'message'=>'OK'];    
            }
            else
            {
               return ['status'=>400,'message'=>'Bowler have already bowled for his maximum overs']; 
            }
        }
        else
        {
            return ['status'=>400,'message'=>'The new bowler_id does not belong to playing 11'];
        }
        
    }

    public function bowlerChangeMaker($request){
    	$where_array = [
            'match_id' => $request->match_id,            
            'innings' => $request->innings,
            'old_id' => $request->old_id,
            'over_no' => $request->over_no,
            'new_id' => $request->new_id
        ]; 

        $Bowler_Summery = $this->Balldata_Model->updateBallerInfo($where_array);
        if($Bowler_Summery > 0)
        {	
        	$where_data1 = [
            'match_id' => $request->match_id,            
            'innings' => $request->innings,
            'bowler_id' => $request->old_id           
        	]; 

        	$bowler_exists = $this->Bowler_Model->isBowlerExists($where_data1);
        	//dd($bowler_exists);
        	if($bowler_exists != null){
        	$flag =$this->Balldata_Model->isBowlerRecordExists($where_data1);
        	if($flag != null){
        	$Ball_Summery = $this->Balldata_Model->getBowlerSummery($where_data1);
        	$this->Bowler_Model->saveBowlerMaster($bowler_exists,$Ball_Summery);
        	}
        	else{
        	$bowler_drop = $this->Bowler_Model->dropBowler($where_data1);	
        	}
            }
        	$where_data2 = [
	            'match_id' => $request->match_id,            
	            'innings' => $request->innings,
	            'bowler_id' => $request->new_id           
        	]; 

        	$bowler_exists = $this->Bowler_Model->isBowlerExists($where_data2);
        	$Ball_Summery = $this->Balldata_Model->getBowlerSummery($where_data2);
        	$result = $this->Bowler_Model->saveBowlerMaster($bowler_exists,$Ball_Summery);
            //dd($result);
            return $result;
        }
    	
    }
}
