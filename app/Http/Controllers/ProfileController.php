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
        return view('profile.index', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'phone' => 'required|min:11|numeric',
            'address' => 'required|string|max:255',
            'rek' => 'required|numeric|',
        ]);

        Profile::updateOrCreate(
            ['id_user' => Auth::id()],
            ['phone' => $request->phone,
            'address' => $request->address,
            'rek' => $request->rek]
        );

        return redirect()->route('profile.index')->with('message', 'Profile Updated Successfully.');
    }
}
