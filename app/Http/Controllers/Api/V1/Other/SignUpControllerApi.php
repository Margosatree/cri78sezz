<?php

namespace App\Http\Controllers\Api\V1\Other;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Validator;
class SignUpControllerApi extends Controller
{
    public function signup(){
        return view('auth.signup');
    }
}
