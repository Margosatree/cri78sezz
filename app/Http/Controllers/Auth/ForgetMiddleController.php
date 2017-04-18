<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ForgetMiddleController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }


    public function checkData(Request $request){

    	if(is_numeric($request->email)){
    		$this->validate($request,[
    			'email'=>'required|numeric|min:10',
    		]);
    		dd('number');
    	}else{
    		$this->validate($request,[
    			'email'=>'required|email',
    		]);
    		dd('email');
    		// return redirect('password.email');
    	}
    }
}
