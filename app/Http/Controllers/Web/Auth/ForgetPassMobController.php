<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForgetPassMobController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    
}
