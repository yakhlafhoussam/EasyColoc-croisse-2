<?php

namespace App\Http\Controllers;

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
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('home');
        }
        return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect .'
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
            'email' => 'required|unique:users,email',
            'phone' => 'required|min:10|unique:users,phone',
            'password' => 'required|min:8|confirmed',
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

        return redirect()->route('login');
    }

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->user();

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
                    'firstname' => $googleUser->getName(),
                    'profile_image' => $googleUser->getAvatar(),
                    'google_id' => $googleUser->getId(),
                ]
            );
        }

        Auth::login($user);

        return redirect('/');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
