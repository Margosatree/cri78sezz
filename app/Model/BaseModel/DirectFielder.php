<?php

namespace App\Model\BaseModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;
class DirectFielder extends Model
{
    //use Notifiable;
    protected $table = 'fielder_master';
    //protected $primaryKey = 'trans_id';
    protected $guarded = [];
    public $timestamps = false;
   // protected $Balldata_Model;

    public function __construct() {
       // $this->Balldata_Model = new Balldata();
    }

    public function storeDirectFielder(Request $request){
        $status = false;
        //$players = explode(",",$request->players);
        $status = DB::table('fielder_master')->insert(['fielder_id'=>$request->fielder_id,'fielder_name'=>$request->fielder_name,'innings'=>$request->innings,'match_id'=>$request->match_id,'team_id'=>$request->team_id,'caught'=>$request->caught,'stumping'=>$request->stumping,'run_out'=>$request->run_out,'drop_catch'=>$request->drop_catch,'misfield'=>$request->misfield,'over_throw'=>$request->over_throw]);      
        
        return $status;
    }
}
