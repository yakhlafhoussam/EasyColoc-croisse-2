<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\Invitation;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;
use PragmaRX\Countries\Package\Countries;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.welcome');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function submitLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if (session()->has('invite_token')) {
                $token = session('invite_token');

                $invitation = Invitation::where('token', $token)->first();

                Membership::create([
                    'user_id' => Auth::id(),
                    'colocation_id' => $invitation->colocation_id,
                    'role' => 0,
                    'join_at' => now(),
                ]);

                Balance::create([
                    'user_id' => Auth::id(),
                    'colocation_id' => $invitation->colocation_id,
                ]);

                $invitation->update([
                    'status' => 1
                ]);

                return redirect('/')->with('success', 'Invitation accepted');

                session()->forget('invite_token');
            }
            return redirect()->route('home');
        }
        return back()->withErrors([
            'email' => 'Email or password incorrect.'
        ])->onlyInput('email');
    }

    public function signup()
    {
        $countries = new Countries();

        $allCountries = $countries->all()
            ->sortBy('name.common')
            ->mapWithKeys(function ($country) {
                return [$country['cca2'] => $country['name']['common']];
            });
        return view('auth.signup', compact('allCountries'));
    }

    public function submitSignup(Request $request)
    {
        $request->validate([
            'firstname' => 'required|min:2|max:50',
            'lastname' => 'required|min:2|max:50',
            'gender' => 'required|in:male,female',
            'cin' => 'required|min:6|unique:users,cin|max:50',
            'country' => 'required|min:2|max:50',
            'city' => 'required|min:3|max:50',
            'birth_date' => 'required|date|before:today',
            'type_occupation' => 'required|in:work,student',
            'occupation' => 'required|min:2|max:50',
            'email' => 'required|unique:users,email|max:50',
            'phone' => 'required|min:10|unique:users,phone|max:50',
            'password' => 'required|min:8|max:50|confirmed',
        ]);

        $admin = User::get();

        if (count($admin) == 0) {
            User::create([
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
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'is_admin' => 1
            ]);
        } else {
            User::create([
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
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password)
            ]);
        }

        return redirect()->route('login')->with('success', 'Signup completed successfully!');;
    }

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        if (!$user) {
            $admin = User::get();

            if (count($admin) == 0) {
                $user = User::updateOrCreate(
                    ['email' => $googleUser->getEmail()],
                    [
                        'firstname' => $googleUser->user['given_name'],
                        'lastname'  => $googleUser->user['family_name'],
                        'profile_image' => $googleUser->getAvatar(),
                        'google_id' => $googleUser->getId(),
                        'is_admin' => 1
                    ]
                );
            } else {
                $user = User::updateOrCreate(
                    ['email' => $googleUser->getEmail()],
                    [
                        'firstname' => $googleUser->user['given_name'],
                        'lastname'  => $googleUser->user['family_name'],
                        'profile_image' => $googleUser->getAvatar(),
                        'google_id' => $googleUser->getId(),
                    ]
                );
            }
        } else {
            if (!$user->google_id) {
                $user->google_id = $googleUser->getId();
                $user->save();
            }
        }

        Auth::login($user);

        if (session()->has('invite_token')) {
            $token = session()->pull('invite_token');

            $invitation = Invitation::where('token', $token)->first();

            Membership::create([
                'user_id' => Auth::id(),
                'colocation_id' => $invitation->colocation_id,
                'role' => 0,
                'join_at' => now(),
            ]);

            Balance::create([
                'user_id' => Auth::id(),
                'colocation_id' => $invitation->colocation_id,
            ]);

            $invitation->update([
                'status' => 1
            ]);

            return redirect('/')->with('success', 'Invitation accepted');
        }

        return redirect('/');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
