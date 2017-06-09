<?php

namespace App\Model\BaseModel;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Model\BaseModel\Balldata;
class FielderPowerplay extends Authenticatable
{
    use Notifiable;
    protected $table = 'fielder_master_powerplay';
    protected $primaryKey = 'trans_id';
    protected $guarded = [];
    public $timestamps = false;
    
    protected $Balldata_Model;
    public function __construct() {
        $this->Balldata_Model = new Balldata();
    }
    
    public function isFielderExists($where_array){
        return FielderPowerplay::where($where_array)->value('trans_id');
    }
    
    public function saveFielderTickData($request){
        $where_array = [
            'match_id' => $request->match_id,
            'fielder_id' => $request->fielder_id,
            'innings' => $request->innings,
        ];
        $fielder_exists = $this->isFielderExists($where_array);
    $fielder_Summery = $this->Balldata_Model->getFilderSummery($where_array);
//        $Ball_Summery->bowlerid = $request->BatsmanID;
//        $Ball_Summery->fielderid = $request->fielder_id;
//        $Bat_Summery->BatsmanName = $request->username;
        $this->saveFielderMaster($fielder_exists,$fielder_Summery);
        
    }
    public function dropFielder($where_data1)
    {
        FielderPowerplay::where('match_id', $where_data1['match_id'])
        ->where('innings', $where_data1['innings'])
        ->where('fielder_id', $where_data1['fielder_id'])
        ->delete();
    }
    public function saveFielderMaster($update,$BowlerTick){
        if($BowlerTick != null){            
        if($update){
            $Fielder = FielderPowerplay::find($update);//Update
        }else{
            $Fielder = new FielderPowerplay();//Add
        }
        //dd($BowlerTick->match_id);
        $Fielder->match_id = $BowlerTick->match_id;
        //dd($Fielder->match_id);
        $Fielder->innings = $BowlerTick->innings;
        $Fielder->fielder_id = $BowlerTick->fielder_id;
        $Fielder->fielder_name = $BowlerTick->fielder_name;
        $Fielder->team_id = $BowlerTick->team_id;
        $Fielder->caught = $BowlerTick->caught;
        $Fielder->stumping = $BowlerTick->stumping;
        $Fielder->run_out = $BowlerTick->run_out;
        $Fielder->drop_catch = $BowlerTick->drop_catch;
        $Fielder->misfield = $BowlerTick->misfield;
        $Fielder->over_throw = $BowlerTick->over_throw;
        //$Fielder->batsman_id = $BowlerTick->batsman_id;
        //$Fielder->bowler_id = $BowlerTick->bowler_id;
        $data = $Fielder->save();
        return $data;
    }}
}
