<?php

namespace App\Http\Controllers\Auth;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AdminLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/adminhome';

    public function __construct()
    {
        $this->middleware('guest.admins', ['except' => 'logout']);
    }

    protected $guard = 'admin';

    public function showLoginForm() {
        return view('admin.adminlogin');
    }

    protected function guard(){
        return Auth::guard($this->guard);
    }
}
