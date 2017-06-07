<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Balldata;
use App\BallArea;
class BatsmanDetail extends Model
{
    protected $table = 'batsman_details';
  //protected $primaryKey = 'trans_id';
     protected $primaryKey ='match_id';

    protected $guarded = [];
    public $timestamps = false;

    protected $Balldata_Model;
    
    public function __construct() {
        $this->Balldata_Model = new Balldata();
    }

     private function isBatAreaExists($where_data){
        return BatsmanDetail::where($where_data)->first();
    }

    public function saveBatsmanDetail($request){

    $where_data = [
            'match_id' => $request->match_id,
            'batsman_id' => $request->batsman_id,
            'innings' => $request->innings,
            'ball_area_id' => $request->ball_area_id
        ];

    $bat_area_exists = $this->isBatAreaExists($where_data);
    // dd($bat_area_exists);
    $Bat_Details = $this->Balldata_Model->getBatsmanDetails($where_data);       
    $this->saveBatsmanDetailMaster($bat_area_exists, $request, $Bat_Details);

    }

    public function saveBatsmanDetailMaster($update, $request, $BatsmanTick){
       // dd($BatsmanTick);
        if(count($update)){
        	//dd($update);
            $BatsmanDetail = $update;//Update
            //dd($Batsman);
        }else{
            $BatsmanDetail = new BatsmanDetail();//Add
        }
        $ball_area = BallArea::where('id',$request->ball_area_id)->value('name');
        // dd($ball_area);        
        $BatsmanDetail->match_id = $request->match_id;
        //$BatsmanDetail->order_id = $BatsmanTick->order_id; //find
        $BatsmanDetail->innings = $request->innings;
        $BatsmanDetail->batsman_id = $request->batsman_id;
        $BatsmanDetail->run_score = $BatsmanTick->run_score;
        $BatsmanDetail->shot_count = $BatsmanTick->shot_count;
        $BatsmanDetail->ball_area_id = $request->ball_area_id;
        $BatsmanDetail->ball_area = $ball_area;
       /* $BatsmanDetail->type = $BatsmanTick->type;
        $BatsmanDetail->other = $BatsmanTick->other;
        $BatsmanDetail->remark = $BatsmanTick->remark; */       
       // dd($BatsmanDetail);//NA
        $BatsmanDetail->save();
    }

}
