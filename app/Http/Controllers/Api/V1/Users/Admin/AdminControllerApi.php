<?php

namespace App\Http\Controllers\Api\V1\Users\Admin;
use Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminControllerApi extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        return view('adminhome');
    }
    
    public function test()
    {
        dd(Auth::user()->user_master_id);
    }
}
