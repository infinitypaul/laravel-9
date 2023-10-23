<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AddTokenToHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->has('api_token')){
            $request->headers->set('Authorization', 'Bearer ' . $request->get('api_token'));
        }
        return $next($request);
    }
}
