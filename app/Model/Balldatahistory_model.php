<?php

namespace App\Model;
use App\Model\BaseModel\Balldatahistory;
use App\Model\Balldata_model;
use DB;
class Balldatahistory_model {
	protected $Balldata_Model;
    public function __construct() {
        $this->Balldata_Model = new Balldata_model();
    }

    public function saveBalldata($request)
    {
    	$status = 400;

    	if(isset($request->match_id) && isset($request->complete))
    	{
	    	if($request->complete == "yes")
	    	{
	    		try
	    		{
		    		$datas = $this->Balldata_Model->matchInfo($request);

			    	if(count($datas) > 0)
			    	{
				    	foreach($datas as $data)
				    	{
				    	  $status = Balldatahistory::insert($data);
				    	}

				    	if($status == true)
				    	{
			            	$delete_status = $this->Balldata_Model->deleteMatchInfo($request);
				          	return response()->json(['status'=>200,'message'=>'Records archived Sucessfully']);	
				    	}
				    	else
				    	{
				    	return response()->json(['status'=>400,'message'=>'Records not inserted Sucessfully']);		
				    	}
		    		}
				    else
				    {
				    	return response()->json(['status'=>400,'message'=>'Match Data Does not exist']);
				    }
		    	}
			    catch(\Exception $e)
			    {	
		   			return response()->json(['status'=>$status,'message'=>"Duplicate Data"]);
			    }
	    	}	    
	    	else
	    	{
	        	return response()->json(['status'=>$status,'message'=>'Records not Archived Sucessfully as match is not complete']);	 
	    	} 
  		}
  		else
  		{
  			return response()->json(["status"=>400,"message"=>"Insufficient Input Parameters Given"]);
  		}
      
    }
    
     
}