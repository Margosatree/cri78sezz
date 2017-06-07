<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Batsmanmaster extends Model
{
	protected $primaryKey = 'TransId';
    protected $table = 'batsmanmaster';
    protected $guarded = [];
    public $timestamps = False;
}
