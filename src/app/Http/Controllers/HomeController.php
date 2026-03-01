<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\Categorie;
use App\Models\Colocation;
use App\Models\Expense;
use App\Models\Membership;
use App\Models\Payment;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = User::where('id', Auth::id())->first();

        $membership = $user->memberships()->whereNull('left_at')->first();

        if (!$membership) {
            return view('user.index');
        }

        $owner = Membership::where('role', 1)->first('user_id');

        $colocation = $membership->colocation;

        $members = $colocation->memberships()->whereNull('left_at')->with('user')->get()->map(fn($m) => $m->user);

        $memberss = $colocation->memberships()->with('user')->get()->map(fn($m) => $m->user);

        $expenses = Expense::with('category')
            ->where('colocation_id', $colocation->id)
            ->get()->sortByDesc('created_at');

        $bals = Balance::where('colocation_id', $colocation->id)->where('status', 1)->get();

        $balances = [];
        foreach ($bals as $bal) {
            $balances[ucfirst(substr($bal->user->firstname, 0, 1)) . '.' . ucwords($bal->user->lastname)] = $bal->balance;
        }

        $category = Categorie::where('colocation_id', Membership::where('user_id', Auth::id())->first('colocation_id')->colocation_id)->get();

        return view('user.index', compact('user', 'colocation', 'members', 'memberss', 'expenses', 'balances', 'owner', 'category'));
    }
}
