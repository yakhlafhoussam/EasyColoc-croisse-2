<?php

namespace App\Http\Controllers;

use App\Mail\VerifierMail;
use App\Models\Membership;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

use function Symfony\Component\Clock\now;

class ProfileController extends Controller
{

    public function index()
    {
        $user = User::where('id', Auth::id())->first();

        $membership = Membership::with('colocation')
            ->where('user_id', $user->id)
            ->whereNull('left_at')
            ->first();

        $roommates = collect();

        if ($membership) {

            $roommates = Membership::with('user')
                ->where('colocation_id', $membership->colocation_id)
                ->where('user_id', '!=', $user->id)
                ->whereNull('left_at')
                ->get()
                ->pluck('user');
        }

        $history = Membership::with('colocation')
            ->where('user_id', $user->id)
            ->orderByDesc('join_at')
            ->get();

        $ratings = Rating::with([
            'fromUser',
            'colocation'
        ])->where('to_user_id', $user->id)
            ->latest()
            ->get();

        $averageRating = round($user->ratingsReceived()->avg('stars'), 1);

        return view('user.profile', compact(
            'user',
            'membership',
            'roommates',
            'history',
            'ratings',
            'averageRating'
        ));
    }

    public function showForm()
    {
        $user = User::find(Auth::id());
        return view('auth.complete', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'firstname' => 'required|min:2|max:50',
            'lastname' => 'required|min:2|max:50',
            'gender' => 'required|in:male,female',
            'cin' => 'required|min:6|max:50|unique:users,cin',
            'country' => 'required|min:2',
            'city' => 'required|min:3',
            'birth_date' => 'required|date|before:today',
            'type_occupation' => 'required|in:work,student',
            'occupation' => 'required|min:2|max:50',
            'phone' => 'required|min:8|max:50|unique:users,phone',
            'password' => 'required|min:8|max:50|confirmed',
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

        return redirect('/')->with('success', 'The profile was completed successfully!');
    }

    public function showVerifier()
    {
        $code = mt_rand(100000, 999999);
        session(['code' => $code]);
        $firstname = User::where('id', Auth::id())->first()->firstname;
        $info = [
            'code' => $code,
            'firstname' => $firstname
        ];
        Mail::to(User::where('id', Auth::id())->first()->email)
            ->send(new VerifierMail($info));
        return view('auth.verifier');
    }

    public function submitVerifier(Request $request)
    {
        if (session('code') == $request->code) {
            session()->forget('code');
            User::where('id', Auth::id())->update([
                'email_verified_at' => now(),
            ]);
            return redirect('/')->with('success', 'The email was verified successfully!');
        } else {
            return redirect('/verifier-profile')->with('error', 'The code is incorrect we send another one!');
        }
    }
}
