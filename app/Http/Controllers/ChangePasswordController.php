<?php

namespace App\Http\Controllers;
use App\User_Organisation;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Crypt;
class ChangePasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    
    public function request(){
        return view('auth.passwords.change');
    }
    
    public function update(Request $request){
        $this->validate($request,[
            'current_password' => [
                'required',
                'max:50'
            ],
            'password' => [
                'required',
                'confirmed',
                'regex:/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/',
            ]
        ]);
//        dd(request()->all());
        $User = User_Organisation::selectRaw('*')->where('id',Auth::user()->id)->get()->first();
        $decrypt = decrypt($User->password); 
        dd($decrypt.' '.request('password'));
        dd($User);
//        
        if($User){
            $User = User_Organisation::find(Auth::user()->id);
            $User->password = bcrypt(request('password'));
        }else{
            Session::flash('message', 'You Are Not Valid User'); 
        }
        return view('auth.passwords.change');
    }
    
}
