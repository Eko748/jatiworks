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
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            $user->update([
                'ip_login' => $request->ip(),
                'last_activity' => Carbon::now(),
            ]);

            $route = '';
            if ($user->id_role == 1) {
                $route = route('dashboard.index');
            } elseif ($user->role_name == 'petugas') {
                $route = redirect('/petugas/dashboard');
            } else {
                $route = route('dashboard.index');
            }
            return response()->json([
                'status_code'   => 200,
                'error'         => false,
                'message'       => "Successfully",
                'data'          => array(
                    'route_redirect'    => $route
                )
            ], 200);
        } else {
            return response()->json([
                'status_code'   => 300,
                'error'         => true,
                'message'       => "Terjadi Kesalahan",
            ], 300);
        }
    }

    public function dashboard()
    {
        $title = 'Dashboard';

        return view('admin.dashboard.index', compact('title', 'toko'));
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
