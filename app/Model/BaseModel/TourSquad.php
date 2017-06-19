<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model;
class TourSquad extends Model
{
    use SoftDeletingTrait;
    protected $table = 'tour_squad';
    protected $guarded = [];

}
