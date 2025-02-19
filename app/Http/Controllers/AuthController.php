<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Tentukan route tujuan berdasarkan id_role
            $route = $user->id_role == 1 ? route('admin.dashboard.index') : url('/');

            return response()->json([
                'status_code'   => 200,
                'error'         => false,
                'message'       => "Successfully logged in",
                'data'          => [
                    'route_redirect' => $route
                ]
            ], 200);
        }

        return response()->json([
            'status_code'   => 401,
            'error'         => true,
            'message'       => "Email atau password salah",
        ], 401);
    }

    public function dashboard()
    {
        $title = 'Dashboard';

        return view('admin.dashboard.index', compact('title',));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function index(Request $request)
    {
        $menu = ['Dashboard'];
        $user = Auth::user();
        return view('dashboard', compact('menu', 'user'));
    }
}
