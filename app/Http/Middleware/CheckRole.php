<?php

namespace App\Http\Middleware;
use Illuminate\Http\Request;
use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next,...$roles)
    {
        if(in_array($request->user()->role_id, $roles)){
            return $next($request);
        };
        return redirect('/');
    }

}
