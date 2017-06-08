<?php
namespace App\Http\Middleware;
use Closure;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Illuminate\Support\Facades\Response;

use App\Model\RoleUser_model;
class VerifyJWTToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->RoleUser_model = new RoleUser_model;
        $controllerAction = class_basename($request->route()->getActionName());
        //$routeArray = $request->route()->getAction();
        list($controller, $action) = explode('@', $controllerAction);
        try{
            $user = JWTAuth::parseToken()->authenticate();
            if($user){
                $get_perms = $this->RoleUser_model->getPermissionsByUserIdAPI($user->id);
                    if(!in_array("$controller.$action", $get_perms)) {
                        return Response::json(
                            ['error'=>[
                                        'message'=>'UnauthorizedHttpException',
                                        'status_code'=>403
                                ]],403);
                    }
            }

        }catch (JWTException $e) {
            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return Response::json([
                        'error'=>[
                                    'message'=>'token_expired',
                                    'status_code'=>$e->getStatusCode()
                        ]],$e->getStatusCode());
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return Response::json([
                        'error'=>[
                                    'message'=>'token_invalid',
                                    'status_code'=>$e->getStatusCode()
                        ]],$e->getStatusCode());
            }else{
                return Response::json([
                        'error'=>[
                                    'message'=>'Token is required',
                                    'status_code'=>403
                        ]],403);
            }
        }
       return $next($request);
    }
}