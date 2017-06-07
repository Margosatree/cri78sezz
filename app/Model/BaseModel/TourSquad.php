<?php

namespace App\Model\BaseModel;

use Illuminate\Database\Eloquent\Model;

class TourSquad extends Model
{
    //use Notifiable;
    protected $table = 'tour_squad';
    protected $primaryKey = 'tournament_id';
    protected $guarded = [];
    public $timestamps = false;
   // protected $Balldata_Model;

    public function __construct() {
       // $this->Balldata_Model = new Balldata();
    }

    public function storeTourSquad(Request $request){

    }
}
