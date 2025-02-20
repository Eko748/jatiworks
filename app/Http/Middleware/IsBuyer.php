<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsBuyer
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->id_role == 2) {
            return $next($request);
        }
        return redirect('/')->with('error', 'Access Deniedss.');
    }
}
