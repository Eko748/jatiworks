<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function post_login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        Log::info('User logged in: ' . $user->email);

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil!',
            'redirect_url' => $user->role == 1 ? route('admin.dashboard') : url('/')
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'Email atau password salah.'
    ], 401);
}

    public function logout()
    {
        Auth::logout();

        return redirect('/auth.login');
    }
}
