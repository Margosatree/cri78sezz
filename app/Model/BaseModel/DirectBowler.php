<?php

namespace App\Model\BaseModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;
class DirectBowler extends Model
{
    //use Notifiable;
    protected $table = 'bowler_master';
    //protected $primaryKey = 'trans_id';
    protected $guarded = [];
    public $timestamps = false;
   // protected $Balldata_Model;

    public function __construct() {
       // $this->Balldata_Model = new Balldata();
    }

    public function storeDirectBowler(Request $request){
        $status = false;
        //$players = explode(",",$request->players);
        $status = DB::table('bowler_master')->insert(['match_id'=>$request->match_id,'innings'=>$request->innings,'order_id'=>$request->order_id,'bowler_id'=>$request->bowler_id,'bowler_name'=>$request->bowler_name,'bowler_type'=>$request->bowler_type,'balls'=>$request->balls,'overs'=>$request->overs,'maiden'=>$request->maiden,'runs'=>$request->runs,'run0'=>$request->run0,'run1'=>$request->run1,'run2'=>$request->run2,'run3'=>$request->run3, 'run4'=>$request->run4,'run6'=>$request->run6,'run_ext'=>$request->run_ext,'run_ext_wd'=>$request->run_ext_wd,'run_ext_nb'=>$request->run_ext_nb,'caught'=>$request->caught,'bowled'=>$request->bowled,'hitwicket'=>$request->hitwicket,'stumping'=>$request->stumping,'lbw'=>$request->lbw,'econ'=>$request->econ,'wicket'=>$request->wicket, 'index'=>$request->index]);        
        
        return $status;
    }
}
