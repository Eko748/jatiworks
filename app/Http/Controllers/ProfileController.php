<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = Profile::where('id_user', $user->id)->first();
        return view('buyer.pages.profile.index', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . Auth::id(),
            'password' => 'nullable|string|min:6|',
            'phone' => 'nullable|min:11|numeric',
            'address' => 'nullable|string|max:255',
            'rek' => 'nullable|numeric',
        ]);

        $user = Auth::user();

        // Update Users Table jika name, email, atau password dikirim
        $updateUserData = [];
        if ($request->filled('name')) {
            $updateUserData['name'] = $request->name;
        }
        if ($request->filled('email')) {
            $updateUserData['email'] = $request->email;
        }
        if ($request->filled('password')) {
            $updateUserData['password'] = bcrypt($request->password);
        }

        if (!empty($updateUserData)) {
            $user->update($updateUserData);
        }

        // Update or Create Profile Table
        Profile::updateOrCreate(
            ['id_user' => $user->id],
            [
                'phone' => $request->phone,
                'address' => $request->address,
                'rek' => $request->rek
            ]
        );

        return redirect()->route('profile.index')->with('message', 'Profile Updated Successfully.');
    }
}
