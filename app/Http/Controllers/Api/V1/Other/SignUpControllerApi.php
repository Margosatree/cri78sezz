<?php

namespace App\Http\Controllers\Web\Other;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class SignUpControllerApi extends Controller
{
    public function signup(){
        return view('auth.signup');
    }
}
