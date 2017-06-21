<?php

namespace App\Model\BaseModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BowlerPowerplay extends Model
{
    use SoftDeletes;
    protected $table = 'bowler_master_powerplay';
    protected $primaryKey = 'trans_id';
    protected $guarded = [];
    protected $Balldata_Model;
    protected $dates = ['deleted_at'];
    
   /* public function __construct() {
        
    }*/
    

}
