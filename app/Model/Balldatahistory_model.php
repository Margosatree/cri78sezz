<?php

namespace App\Model;
use App\Model\BaseModel\Balldatahistory;
use DB;
class Balldatahistory_model {

    public function __construct() {
        
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
		    		$datas = Balldata::where('match_id',$request->match_id)->get()->toArray();

			    	if(count($datas) > 0)
			    	{
				    	foreach($datas as $data)
				    	{
				    	  $status = Balldatahistory::insert($data);
				    	}

				    	if($status == true)
				    	{
			            	$delete_status = Balldata::where('match_id',$request->match_id)->delete();
				          	return response()->json(['status'=>200,'message'=>'Records inserted Sucessfully']);	
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
	        	return response()->json(['status'=>$status,'message'=>'Records not inserted Sucessfully as match is not complete']);	 
	    	} 
  		}
  		else
  		{
  			return response()->json(["status"=>400,"message"=>"Insufficient Input Parameters Given"]);
  		}
      
    }
    
     
}