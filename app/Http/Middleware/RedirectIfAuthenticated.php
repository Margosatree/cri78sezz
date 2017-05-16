<?php

namespace App\Http\Middleware;

use Session;
use DB;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    { 
        switch ($guard){
            case 'admin':
                if (Auth::guard($guard)->check())
                {
                    $id = Auth::guard($guard)->user()->id;
                    $check_roles = DB::table('role_user')
                        ->select('*')
                        ->leftJoin('roles','roles.id','=','role_user.role_id')
                        ->where('role_user.user_id', '=', $id)
                        ->get();

                    foreach($check_roles as $check_role){
                        if($check_role->is_admin == 1){
                           return redirect('/admin/home'); 
                        }
                    }            
                }
                break;
            
            default:
                if (Auth::guard($guard)->check()) {
                    $id = Auth::guard($guard)->user()->id;
                    $check_roles = DB::table('role_user')
                        ->select('*')
                        ->leftJoin('roles','roles.id','=','role_user.role_id')
                        ->where('role_user.user_id', '=', $id)
                        ->get();

                    foreach($check_roles as $check_role){
                        if($check_role->is_admin == 0){
                           return redirect('/home'); 
                        }
                    }
                }
                break;
        }
        
        return $next($request);
    }
}
