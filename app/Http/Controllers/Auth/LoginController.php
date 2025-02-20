<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function index()
    {
        $title = 'Login';
        return view('auth.login', compact('title'));
    }

    public function postLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            $route = $user->id_role == 1 ? route('dashboard.index') : url('/');

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
            'message'       => "Email or Password Wrong, Please Check it again !",
        ], 401);
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Ubah status menjadi offline saat logout
            DB::table('users')
                ->where('id', $user->id)
                ->update(['status' => 'Offline']);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.index')->with('message', 'Youre Logouted.');
    }
}
