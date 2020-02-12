<?php

namespace App\Http\Middleware;

use Closure;

use Auth;

class RoleMiddleware
{


    protected $redirectTo = '/';


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        // Check if user is authed
        if(!Auth::check()){
            return redirect($this->redirectTo);
        }

        // Get authed user
        $user = Auth::user();

        if($user->hasRole($roles)){
            return $next($request);
        } else {
            return redirect($this->redirectTo);
        }

    }
}
