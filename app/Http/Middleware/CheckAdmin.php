<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // CheckAdmin.php
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->type == 'admin') {
            return $next($request);
        }
        return redirect()->route('login');
    }

}