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
        if (Auth::attempt(["email" => $request->email, "password" => $request->password])){
            Log::info('User logged in: ' . Auth::user()->email);
            return redirect()->route('ds_admin')->with('message', 'Login Success');
        } else {
            Log::error('Login failed for email: ' . $request->email);
            return back()->with('error', 'Login failed');
        }
    }

    public function logout(){
        Auth::logout();

        return redirect('/auth.login');
    }
}
