<?php

namespace App\Model;
use App\Model\BaseModel\DirectFielder;
use DB;
class DirectFielder_model {

    public function __construct() {
        
    }

    public function storeDirectFielder($request){
        $status = false;
        //$players = explode(",",$request->players);
        $status = DB::table('fielder_master')->insert(['fielder_id'=>$request->fielder_id,'fielder_name'=>$request->fielder_name,'innings'=>$request->innings,'match_id'=>$request->match_id,'team_id'=>$request->team_id,'caught'=>$request->caught,'stumping'=>$request->stumping,'run_out'=>$request->run_out,'drop_catch'=>$request->drop_catch,'misfield'=>$request->misfield,'over_throw'=>$request->over_throw]);      
        
        return $status;
    }
    
     
}