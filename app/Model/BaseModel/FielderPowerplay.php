<?php

namespace App\Model\BaseModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
//use App\Model\BaseModel\Balldata;
class FielderPowerplay extends Model
{
    use SoftDeletes;
    protected $table = 'fielder_master_powerplay';
    protected $primaryKey = 'trans_id';
    protected $guarded = [];
    protected $dates = ['deleted_at']; 

    protected $hidden = [
        'created_at','updated_at','deleted_by','updated_by','deleted_at'
    ];

    /*public function __construct() {
        $this->Balldata_Model = new Balldata();
    }  */  
    
}
