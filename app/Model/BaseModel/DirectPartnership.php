<?php

namespace App\Model\BaseModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
class DirectPartnership extends Model
{
    use SoftDeletes;
    protected $table = 'partnership_master';
    //protected $primaryKey = 'trans_id';
    protected $guarded = [];
    // protected $Balldata_Model;
    protected $dates = ['deleted_at'];

    protected $hidden = [
        'created_at','updated_at','deleted_by','updated_by','deleted_at'
    ];
    
    public function __construct() {
       // $this->Balldata_Model = new Balldata();
    }

    
}
