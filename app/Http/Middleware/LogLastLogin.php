<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LogLastLogin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Perbarui last_login_at tanpa mengubah updated_at
            DB::table('users')
                ->where('id', $user->id)
                ->update(['last_login_at' => now()]);

            Log::info("User {$user->email} login pada " . now());
        }

        return $next($request);
    }
}
