<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

use App\Traits\ApiControllerTrait;

class Admin
{

    use ApiControllerTrait;

    /**
     * @param $request
     * @param Closure $next
     * @param null $guard
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|mixed
     */
    public function handle($request, Closure $next)
    {  
        if ($user = Auth::guard('api')->user() and $user->isAdmin()) {
            return $next($request);        
        }
        
        return response(['result' => false] ,401);
    }
}