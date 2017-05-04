<?php

namespace App\Http\Middleware;

use Closure;
use App\System;

class Vote
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
        if(System::mode() != System::MODE_VOTE){
            return redirect(route('home'));
        }
        return $next($request);
    }
}
