<?php

namespace App\Model\BaseModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;
class MatchSquad extends Model
{
    protected $table = 'match_squad';
    protected $guarded = [];
    public $timestamps = false;
   // protected $Balldata_Model;

    public function __construct() {
       // $this->Balldata_Model = new Balldata();
    }

    public function storeMatchSquad(Request $request){
        $status = false;
        //$players = explode(",",$request->players);
      //  dd($request->players[0]['player']);
        foreach($request->players as $data){

        $status = DB::table('match_squad')->insert(['tournament_id'=>$request->tournament_id,'team_id'=>$request->team_id,'match_id'=>$request->match_id,'player_id'=>$data['player'],'playing'=>$data['playing']]);        
        }
        return $status;
    }
}
