<?php

namespace App\Http\Middleware;

use App\System;
use Closure;

class Nominate
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
        if(System::mode() != System::MODE_NOMINATE){
            return redirect(route('home'));
        }
        return $next($request);
    }
}
