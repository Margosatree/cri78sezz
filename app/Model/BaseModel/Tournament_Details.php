<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model;

class Tournament_Details extends Model
{
    use SoftDeletingTrait;
    protected $table = 'tournament_details';
    
    protected $fillable = [
        'specification','value', 'range_from', 'range_to'
        
    ];
    protected $hidden = [
        'created_at','updated_at'
    ];
    public function rules(){
        return $this->belongsTo(Tournament_Rules::class,'rule_id','id');
    }
}
