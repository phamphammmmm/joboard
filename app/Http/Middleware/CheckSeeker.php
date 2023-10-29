<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSeeker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    // CheckSeeker.php
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->type == 'seeker') {
            return $next($request);
        }
        return redirect()->route('login'); // Hoặc điều hướng tới trang khác
    }

}