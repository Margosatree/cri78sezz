<?php

namespace App\Model\BaseModel;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Model\BaseModel\Balldata;

class BatsmanPowerplay extends Authenticatable
{
    use Notifiable;
    protected $table = 'batsman_master_powerplay';
    protected $primaryKey = 'trans_id';
    protected $guarded = [];
    public $timestamps = false;
    
    protected $Balldata_Model;
    
    public function __construct() {
        $this->Balldata_Model = new Balldata();
    }

    private function isBastsmanExists($where_array){
        return BatsmanPowerplay::where($where_array)->value('trans_id');
    }

     
    public function saveBatsmanTickData($request){
        $where_array = [
            'match_id' => $request->match_id,
            'batsman_id' => $request->batsman_id,
            'innings' => $request->innings,
        ];
        
        $batsman_exists = $this->isBastsmanExists($where_array);
        
        $Bat_Summery = $this->Balldata_Model->getBatsmanSummery($where_array);
        $Bat_Summery->bowler_id = $request->bowler_id;
        $Bat_Summery->fielder_id = $request->fielder_id;
//        $Bat_Summery->batsman_name = $request->username;
        
        $this->saveBastsmanMaster($batsman_exists,$Bat_Summery);
        
    }
    
    public function saveBastsmanMaster($update,$BatsmanTick){
       // dd($BatsmanTick);
        if($update){
            $BatsmanPowerplay = BatsmanPowerplay::find($update);//Update
            //dd($Batsman);
        }else{
            $BatsmanPowerplay = new BatsmanPowerplay();//Add
        }
        $BatsmanPowerplay->match_id = $BatsmanTick->match_id;
        $BatsmanPowerplay->order_id = $BatsmanTick->order_id; //find
        $BatsmanPowerplay->innings = $BatsmanTick->innings;
        $BatsmanPowerplay->batsman_id = $BatsmanTick->batsman_id;
        $BatsmanPowerplay->batsman_name = $BatsmanTick->batsman_name;
        $BatsmanPowerplay->batsman_type = $BatsmanTick->batsman_type;
        $BatsmanPowerplay->balls = $BatsmanTick->balls;
        $BatsmanPowerplay->runs = $BatsmanTick->runs;
        $BatsmanPowerplay->run0 = $BatsmanTick->run0;
        $BatsmanPowerplay->run1 = $BatsmanTick->run1;
        $BatsmanPowerplay->run2 = $BatsmanTick->run2;
        $BatsmanPowerplay->run3 = $BatsmanTick->run3;
        $BatsmanPowerplay->run4 = $BatsmanTick->run4;
        $BatsmanPowerplay->run6 = $BatsmanTick->run6;
        $BatsmanPowerplay->run_ext = $BatsmanTick->run_ext; //NA
        $BatsmanPowerplay->strike_rate = $BatsmanTick->strike_rate;
        $BatsmanPowerplay->bowler_id = $BatsmanTick->bowler_id; 
        $BatsmanPowerplay->fielder_id = $BatsmanTick->fielder_id;
        $BatsmanPowerplay->wicket_type = $BatsmanTick->wicket_type; //NA
        $BatsmanPowerplay->area_id = $BatsmanTick->area_id; //NA
        $BatsmanPowerplay->out = $BatsmanTick->out; //NA
        $BatsmanPowerplay->index = $BatsmanTick->index; 
       // dd($Batsman);//NA
        $BatsmanPowerplay->save();
    }
}
