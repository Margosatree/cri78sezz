<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scoreboard extends Model
{
	
    protected $table = 'scoremaster';
    protected $guarded = [];
    public $timestamps = False;
}
