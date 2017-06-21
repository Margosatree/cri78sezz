<?php

namespace App\Model\BaseModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DirectBowler extends Model
{
    use SoftDeletes;
    //use Notifiable;
    protected $table = 'bowler_master';
    //protected $primaryKey = 'trans_id';
    protected $guarded = [];
    protected $dates = ['deleted_at'];
    
   // protected $Balldata_Model;

    public function __construct() {
       // $this->Balldata_Model = new Balldata();
    }

    
}
