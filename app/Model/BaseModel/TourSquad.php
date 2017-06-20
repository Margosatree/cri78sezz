<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
class TourSquad extends Model
{
    use SoftDeletes;
    protected $table = 'tour_squad';
    protected $guarded = [];

}
