<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }

    public function post_register(Request $request)
    {
        // Validasi data input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'
            ],
        ], [
            'name.required' => 'Name can not be empty',
            'email.required' => 'Email can not be empty',
            'email.unique' => 'Email already taken',
            'email.email' => 'Use the correct email format',
            'password.min' => 'Password atleast 8 character',
            'password.regex' => 'The password must contain at least 1 uppercase letter, 1 number, and 1 unique symbol',

        ]);

        // Simpan user ke database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'id_role' => '2',
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('login.index')->with('message', 'Register berhasil, silakan login.');
    }
}
