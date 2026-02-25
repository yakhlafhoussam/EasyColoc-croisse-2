<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function showForm()
    {
        $user = User::find(Auth::id());
        return view('auth.complete', compact('user'));
    }

    public function updateProfile()
    {
        return view('auth.complete');
    }
}
