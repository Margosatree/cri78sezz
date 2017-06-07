<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Balldata;
use App\BallArea;
class FielderDetail extends Model
{
   protected $table = 'fielder_details';
 	protected $primaryKey = 'match_id';
    protected $guarded = [];
    public $timestamps = false;

    protected $Balldata_Model;
    
    public function __construct() {
        $this->Balldata_Model = new Balldata();
    }

     private function isFielderAreaExists($where_data){
        return FielderDetail::where($where_data)->get();
    }

    public function saveFielderDetail($request){

    $where_data = [
            'match_id' => $request->match_id,
            'fielder_id' => $request->fielder_id,
            'innings' => $request->innings,
            'ball_area_id' => $request->ball_area_id
        ];

    $fielder_area_exists = $this->isFielderAreaExists($where_data);
    $Fielder_Details = $this->Balldata_Model->getFielderDetails($where_data);       
    $this->saveFielderDetailMaster($fielder_area_exists, $request, $Fielder_Details);

    }

    public function saveFielderDetailMaster($update, $request, $BatsmanTick){
       // dd($BatsmanTick);
        if(count($update) > 0){
            $FielderDetail = $update->first();//Update
            //dd($Batsman);
        }else{
            $FielderDetail = new FielderDetail();//Add
        }
        $ball_area = BallArea::where('id',$request->ball_area_id)->value('name');        
        $FielderDetail->match_id = $request->match_id;
        $FielderDetail->innings = $request->innings;
        $FielderDetail->fielder_id = $request->fielder_id;
        $FielderDetail->run_count = $BatsmanTick->run_count;
        $FielderDetail->catch = $BatsmanTick->catch;
        $FielderDetail->run_out = $BatsmanTick->run_out;
        $FielderDetail->drop_catch = $BatsmanTick->drop_catch;
        $FielderDetail->field_count = $BatsmanTick->field_count;
        $FielderDetail->misfield_count = $BatsmanTick->misfield_count;
        $FielderDetail->ball_area_id = $request->ball_area_id;
        $FielderDetail->ball_area = $ball_area;
       /* $FielderDetail->type = $BatsmanTick->type;
        $FielderDetail->other = $BatsmanTick->other;
        $FielderDetail->remark = $BatsmanTick->remark; */       
       // dd($Batsman);//NA
        $FielderDetail->save();
    } 
}
