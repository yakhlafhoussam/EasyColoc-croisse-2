<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RateController extends Controller
{
    public function addnew(Request $request)
    {
        $request->validate([
            'to_user_id' => 'required',
            'stars' => 'required',
            'comment' => 'required|max:50'
        ]);

        $check = Rating::where('from_user_id', Auth::id())->where('to_user_id', $request->to_user_id)->first();

        if ($check) {
            $check->update([
                'stars' => $request->stars,
                'comment' => $request->comment,
                'colocation_id' => Membership::where('user_id', Auth::id())->first()->colocation_id
            ]);
        } else {
            Rating::create([
                'from_user_id' => Auth::id(),
                'to_user_id' => $request->to_user_id,
                'stars' => $request->stars,
                'comment' => $request->comment,
                'colocation_id' => Membership::where('user_id', Auth::id())->first()->colocation_id
            ]);
        }

        return redirect()->route('home')->with('success', 'The rate was added successfully!');;
    }
}
