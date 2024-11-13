<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 

class ProfilController extends Controller
{
    public function index()
    {
        $title = 'Profile';
        $breadcrumbs = [
            ['name' => 'Home', 'url' => '/home'],
            ['name' => 'User Profil', 'url' => ''],
        ];

        return view('pages.profil.index', compact('title', 'breadcrumbs') );
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'password' => 'nullable|min:8',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        if($request->hasFile('profile_picture')) {
            if($user->profile_picture && Storage::exists('public/profile_picture/'. $user->profile_picture)) {
                Storage::delete('public/profile_pictures/'.$user->profile_picture);
            }
            $file = $request->file('profile_picture');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->storeAs('public/profile_pictures', $filename);

            $user->profile_picture = $filename;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
