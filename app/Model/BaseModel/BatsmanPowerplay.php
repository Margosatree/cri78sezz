<?php

namespace App\Model\BaseModel;

use Illuminate\Database\Eloquent\Model;
//use App\Model\BaseModel\Balldata;
use Illuminate\Database\Eloquent\SoftDeletes;
class BatsmanPowerplay extends Model
{
    use SoftDeletes;
    protected $table = 'batsman_master_powerplay';
    protected $primaryKey = 'trans_id';
    protected $guarded = [];   
    protected $dates = ['deleted_at'];
    protected $Balldata_Model;
    
   /* public function __construct() {
        $this->Balldata_Model = new Balldata();
    }
*/
    
}
