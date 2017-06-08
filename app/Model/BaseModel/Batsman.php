<?php

namespace App\Model\BaseModel;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Model\BaseModel\Balldata;
class Batsman extends Authenticatable
{
    use Notifiable;
    protected $table = 'batsman_master';
    protected $primaryKey = 'trans_id';
    protected $guarded = [];
    public $timestamps = false;
    
    protected $Balldata_Model;
    
    public function __construct() {
        $this->Balldata_Model = new Balldata();
    }
    
    private function isBastsmanExists($where_array){
        return Batsman::where($where_array)->value('trans_id');
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
            $Batsman = Batsman::find($update);//Update
            //dd($Batsman);
        }else{
            $Batsman = new Batsman();//Add
        }
        $Batsman->match_id = $BatsmanTick->match_id;
        $Batsman->order_id = $BatsmanTick->order_id; //find
        $Batsman->innings = $BatsmanTick->innings;
        $Batsman->batsman_id = $BatsmanTick->batsman_id;
        $Batsman->batsman_name = $BatsmanTick->batsman_name;
        $Batsman->batsman_type = $BatsmanTick->batsman_type;
        $Batsman->balls = $BatsmanTick->balls;
        $Batsman->runs = $BatsmanTick->runs;
        $Batsman->run0 = $BatsmanTick->run0;
        $Batsman->run1 = $BatsmanTick->run1;
        $Batsman->run2 = $BatsmanTick->run2;
        $Batsman->run3 = $BatsmanTick->run3;
        $Batsman->run4 = $BatsmanTick->run4;
        $Batsman->run6 = $BatsmanTick->run6;
        $Batsman->run_ext = $BatsmanTick->run_ext; //NA
        $Batsman->strike_rate = $BatsmanTick->strike_rate;
        $Batsman->bowler_id = $BatsmanTick->bowler_id; 
        $Batsman->fielder_id = $BatsmanTick->fielder_id;
        $Batsman->wicket_type = $BatsmanTick->wicket_type; //NA
        $Batsman->area_id = $BatsmanTick->area_id; //NA
        $Batsman->out = $BatsmanTick->out; //NA
        $Batsman->index = $BatsmanTick->index; 
       // dd($Batsman);//NA
        $Batsman->save();
    }
}