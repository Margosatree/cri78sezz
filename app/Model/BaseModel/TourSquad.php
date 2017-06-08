<?php

namespace App\Model\BaseModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;
class TourSquad extends Model
{
    //use Notifiable;
    protected $table = 'tour_squad';
    protected $guarded = [];
    public $timestamps = false;
   // protected $Balldata_Model;

    public function __construct() {
       // $this->Balldata_Model = new Balldata();
    }

    public function storeTourSquad(Request $request){
        $status = false;
        //$players = explode(",",$request->players);
        foreach($players as $player){

        $status = DB::table('tour_squad')->insert(['tournament_id'=>$request->tournament_id,'team_id'=>$request->team_id,'player_id'=>$player]);        
        }
        return $status;
    }
}
