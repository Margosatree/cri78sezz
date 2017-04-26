<?php

namespace App\Http\Controllers;
use App\User_Organisation;
use Illuminate\Http\Request;
use Auth;
use Session;
use Hash;
//use Illuminate\Support\Facades\Crypt;
//use \Crypt;
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
//        dd('in');
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
        
        $User = User_Organisation::selectRaw('*')->where('id',Auth::user()->id)->get()->first();
        if($User){
            if(password_verify(request('current_password'), $User->password)) {
                $User = User_Organisation::find(Auth::user()->id);
                $User->password = Hash::make(request('password'));
                $User->save();
                Session::flash('message', 'Password Save Sucessfuly');
//                dd('save Sucess');
                return redirect()->route('home');
            }else{
//                dd('Password Not Match');
                return redirect()->back();
            }
        }else{
            Session::flash('message', 'You Are Not Valid User');
//            dd('Not Valid User');
        }
        return redirect()->route();
    }
    
}
