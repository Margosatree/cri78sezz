<?php

namespace App\Model\BaseModel;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Model\BaseModel\Balldata;
class BowlerPowerplay extends Authenticatable
{
    use Notifiable;
    protected $table = 'bowler_master_powerplay';
    protected $primaryKey = 'trans_id';
    protected $guarded = [];
    public $timestamps = false;
    protected $Balldata_Model;
    public function __construct() {
        $this->Balldata_Model = new Balldata();
    }
    
    public function isBowlerExists($where_array){
        return BowlerPowerplay::where($where_array)->value('trans_id');
    }
    
    public function saveBowlerTickData($request){
        $where_array = [
            'match_id' => $request->match_id,
            'bowler_id' => $request->bowler_id,
            'innings' => $request->innings,
        ];
        $bowler_exists = $this->isBowlerExists($where_array);
        $Ball_Summery = $this->Balldata_Model->getBowlerSummery($where_array);

//        $Ball_Summery->bowlerid = $request->BatsmanID;
//        $Ball_Summery->fielderid = $request->FilderID;
//        $Bat_Summery->BatsmanName = $request->username;

        $this->saveBowlerMaster($bowler_exists,$Ball_Summery);
        
    }
    public function dropBowler($where_data1)
    {
        BowlerPowerplay::where('match_id', $where_data1['match_id'])
        ->where('innings', $where_data1['innings'])
        ->where('bowler_id', $where_data1['bowler_id'])
        ->delete();
    }
    public function saveBowlerMaster($update,$BowlerTick){
        if($BowlerTick != null){
        if($update){
            $Bowler = BowlerPowerplay::find($update);//Update
        }else{
            $Bowler = new BowlerPowerplay();//Add
        }
        $Bowler->match_id = $BowlerTick->match_id;
        $Bowler->order_id = $BowlerTick->order_id; //find
        $Bowler->innings = $BowlerTick->innings;
        $Bowler->bowler_id = $BowlerTick->bowler_id;
        $Bowler->bolwer_name = $BowlerTick->bolwer_name;
        $Bowler->bolwer_type = $BowlerTick->bolwer_type;
        $Bowler->balls = $BowlerTick->balls;
        $Bowler->overs = $BowlerTick->overs;
        $Bowler->maiden = $BowlerTick->maiden;
        $Bowler->runs = $BowlerTick->runs;
        $Bowler->run0 = $BowlerTick->run0;
        $Bowler->run1 = $BowlerTick->run1;
        $Bowler->run2 = $BowlerTick->run2;
        $Bowler->run3 = $BowlerTick->run3;
        $Bowler->run4 = $BowlerTick->run4;
        $Bowler->run6 = $BowlerTick->run6;
        $Bowler->run_ext = $BowlerTick->run_ext;
        $Bowler->run_ext_wd = $BowlerTick->run_ext_wd;
        $Bowler->run_ext_nb = $BowlerTick->run_ext_nb;
        $Bowler->caught = $BowlerTick->caught;
        $Bowler->bowled = $BowlerTick->bowled;
        $Bowler->hitwicket = $BowlerTick->hitwicket;
        $Bowler->stumping = $BowlerTick->stumping;
        $Bowler->lbw = $BowlerTick->lbw;
        $Bowler->econ = $BowlerTick->econ;
        $Bowler->wicket = $BowlerTick->wicket;
//        $Bowler->bowlerid = $BowlerTick->bowlerid; 
//        $Bowler->fielderid = $BowlerTick->fielderid;
//        $Bowler->wickettype = $BowlerTick->wickettype; //NA
//        $Bowler->areaid = $BowlerTick->areaid; //NA
//        $Bowler->OUT = $BowlerTick->OUT; //NA
        $Bowler->index = $BowlerTick->index; //NA
        $data = $Bowler->save();
        return $data;
//        dd('saved');
    } 
  }
}
