<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //return redirect('https://emigroup.ir',301);
        //return response()->view('comingsoon.index');
        // if (!auth()->check() || auth()->user()->role !== 'admin') {
        //     return response()->view('maintenance');
        // }
        return $next($request);

    }
}
