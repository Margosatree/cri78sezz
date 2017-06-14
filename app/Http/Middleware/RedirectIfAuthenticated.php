<?php

namespace App\Http\Middleware;

use Session;
use Closure;
use Illuminate\Support\Facades\Auth;

use App\Model\RoleUser_model;

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
      $this->RoleUser_model = new RoleUser_model;
      // dd($guard);
        switch ($guard){
            case 'admin':
                if (Auth::guard($guard)->check())
                {
                    $id = Auth::guard($guard)->user()->id;
                    $is_admin = 1;
                    $get_perms = $this->RoleUser_model->getPermissionsByUserId($id,$is_admin);
                    
                    if(!is_null($get_perms)) {
                        return redirect()->to('/admin/home');
                    }
                }
                break;

            default:
                if (Auth::guard($guard)->check()) {
                    $id = Auth::guard($guard)->user()->id;
                    $get_perms = $this->RoleUser_model->getPermissionsByUserId($id);

                    if(!is_null($get_perms)) {
                        return redirect()->to('/home');
                    }
                }
                break;
        }

        return $next($request);
    }
}
