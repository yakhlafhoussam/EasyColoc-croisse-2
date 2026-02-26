<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function showForm()
    {
        $user = User::find(Auth::id());
        return view('auth.complete', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'firstname' => 'required|min:2',
            'lastname' => 'required|min:2',
            'profile_image' => 'url',
            'gender' => 'required|in:male,female',
            'cin' => 'required|min:6|unique:users,cin',
            'country' => 'required|min:2',
            'city' => 'required|min:3',
            'birth_date' => 'required|date|before:today',
            'type_occupation' => 'required|in:work,student',
            'occupation' => 'required|min:5',
            'phone' => 'required|min:10|unique:users,phone',
            'password' => 'required|min:8|confirmed',
        ]);

        User::where('id', Auth::id())->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'profile_image' => $request->profile_image,
            'gender' => $request->gender,
            'cin' => $request->cin,
            'country' => $request->country,
            'city' => $request->city,
            'birth_date' => $request->birth_date,
            'type_occupation' => $request->type_occupation,
            'occupation' => $request->occupation,
            'phone' => $request->phone,
            'password' => Hash::make($request->password)
        ]);

        return redirect('/');
    }
}
