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
            'name.required' => 'Nama tidak boleh Kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.unique' => 'Email sudah terpakai',
            'email.email' => 'Gunakan Format email yang sesuai',
            'password.min' => 'Password minimal 8 karakter',
            'password.regex' => 'Password harus mengandung minimal 1 huruf besar, 1 angka, dan 1 simbol unik',

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
