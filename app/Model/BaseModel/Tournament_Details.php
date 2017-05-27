<?php

namespace App\Model\BaseModel;

use Illuminate\Database\Eloquent\Model;

class Tournament_Details extends Model
{
    protected $table = 'tournament_details';
    
    protected $fillable = [
        'specification','value', 'range_from', 'range_to'
        
    ];
    public function rules(){
        return $this->belongsTo(Tournament_Rules::class,'rule_id','id');
    }
}
