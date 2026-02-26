<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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

        return view('user.index', compact(
            'user',
            'membership',
            'roommates',
            'history',
            'ratings',
            'averageRating'
        ));
    }
}
