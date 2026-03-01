<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\Colocation;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewColocationController extends Controller
{
    public function index()
    {
        return view('user.newcolo');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'max_members' => 'required|integer|min:1',
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'desc' => 'required|string|max:2000',
        ]);

        $colocation = Colocation::create([
            'name' => $request->name,
            'max_members' => $request->max_members,
            'country' => $request->country,
            'city' => $request->city,
            'desc' => $request->desc,
            'status' => 1,
        ]);

        Membership::create([
            'user_id' => Auth::id(),
            'colocation_id' => $colocation->id,
            'role' => 1,
            'join_at' => now(),
        ]);

        Balance::create([
            'user_id' => Auth::id(),
            'colocation_id' => $colocation->id,
        ]);

        return redirect('/')->with('success', 'The colocation create successfully!');
    }
}
