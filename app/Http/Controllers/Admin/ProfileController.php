<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('admin.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:6'
        ]);

        $user = Auth::user();

        User::find($user->id)->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Profile Updated!');
    }
}
