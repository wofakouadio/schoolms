<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
//use Illuminate\Support\Facades\Auth;
//use Illuminate\Foundation\Auth;
class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::guard("admin")->check()){
            return redirect()->route('platform')->withErrors(['message'=>'You do not have access']);
        }
        return $next($request);
    }
}
