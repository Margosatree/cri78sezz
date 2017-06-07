<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Balldata;
use App\BallArea;

class PartnershipDetail extends Model
{
    protected $table = 'partnership_details';
  //protected $primaryKey = 'trans_id';
    protected $primaryKey ='match_id';

    protected $guarded = [];
    public $timestamps = false;

    protected $Balldata_Model;
    
    public function __construct() {
        $this->Balldata_Model = new Balldata();
    }

     private function isPartnerAreaExists($where_data){
        return PartnershipDetail::where($where_data)->first();
    }

    public function savePartnershipDetail($request){

    $where_data = [
            'match_id' => $request->match_id,
            'batsman_id' => $request->batsman_id,
            'innings' => $request->innings,
            'ball_area_id' => $request->ball_area_id,
            'for_wicket' => $request->for_wicket,
        ];

   /* $where_data1 = [
            'match_id' => $request->match_id,
            'batsman_id' => $request->batsman_id,
            'innings' => $request->innings,
            'ball_area_id' => $request->ball_area_id,
            'wicket_count' => $request->wicket_count,
        ];*/

    $partner_area_exists = $this->isPartnerAreaExists($where_data);
    // dd($bat_area_exists);
    $Partner_Details = $this->Balldata_Model->getPartnerDetails($where_data);       
    $this->saveBatsmanDetailMaster($partner_area_exists, $request, $Partner_Details);

    }

    public function saveBatsmanDetailMaster($update, $request, $BatsmanTick){
       // dd($BatsmanTick);
        if(count($update)){
        	//dd($update);
            $PartnerDetail = $update;//Update
            //dd($Batsman);
        }else{
            $PartnerDetail = new PartnershipDetail();//Add
        }
        $ball_area = BallArea::where('id',$request->ball_area_id)->value('name');
         //dd($BatsmanTick->wicket_count);        
        $PartnerDetail->match_id = $request->match_id;
        //$BatsmanDetail->order_id = $BatsmanTick->order_id; //find
        $PartnerDetail->innings = $request->innings;
        $PartnerDetail->for_wicket = $BatsmanTick->wicket_count;
        $PartnerDetail->batsman_id = $request->batsman_id;
        $PartnerDetail->run_score = $BatsmanTick->run_score;
        $PartnerDetail->shot_count = $BatsmanTick->shot_count;
        $PartnerDetail->ball_area_id = $request->ball_area_id;
        $PartnerDetail->ball_area = $ball_area;
       /* $PartnerDetail->type = $BatsmanTick->type;
        $PartnerDetail->other = $BatsmanTick->other;
        $PartnerDetail->remark = $BatsmanTick->remark; */       
       // dd($PartnerDetail);//NA
        $PartnerDetail->save();
    }

}
