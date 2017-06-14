<?php

namespace App\Model\BaseModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;
class DirectBatsman extends Model
{
    //use Notifiable;
    protected $table = 'batsman_master';
    //protected $primaryKey = 'trans_id';
    protected $guarded = [];
    public $timestamps = false;
   // protected $Balldata_Model;

    public function __construct() {
       // $this->Balldata_Model = new Balldata();
    }

    public function storeDirectBatsman(Request $request){
        $status = false;
        //$players = explode(",",$request->players);
        $status = DB::table('batsman_master')->insert(['match_id'=>$request->match_id,'order_id'=>$request->order_id,'innings'=>$request->innings,'batsman_id'=>$request->batsman_id,'batsman_name'=>$request->batsman_name,'batsman_type'=>$request->batsman_type,'balls'=>$request->balls,'runs'=>$request->runs,'run0'=>$request->run0,'run1'=>$request->run1,'run2'=>$request->run2,'run3'=>$request->run3, 'run4'=>$request->run4,'run6'=>$request->run6,'run_ext'=>$request->run_ext,'strike_rate'=>$request->strike_rate,'bowler_id'=>$request->bowler_id,'fielder_id'=>$request->fielder_id,'wicket_type'=>$request->wicket_type,'ball_length_id'=>$request->ball_length_id,'area_id'=>$request->area_id,'out'=>$request->out, 'index'=>$request->index]);        
        
        return $status;
    }
}
