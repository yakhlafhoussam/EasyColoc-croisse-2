<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\Expense;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function addnew(Request $request)
    {
        $request->validate([
            'colocation_id' => 'required',
            'categorie_id' => 'required',
            'title' => 'required|max:50',
            'amount' => 'required|max:255',
        ]);

        $members = Membership::where('colocation_id', $request->colocation_id)->whereNull('left_at')->pluck('user_id');

        $newBalance = $request->amount / count($members);

        Expense::create([
            'colocation_id' => $request->colocation_id,
            'payer_id' => Auth::id(),
            'categorie_id' => $request->categorie_id,
            'title' => $request->title,
            'amount' => $request->amount
        ]);

        Balance::where('user_id', Auth::id())->where('colocation_id', $request->colocation_id)->where('status', 1)->increment('balance', $request->amount - $newBalance);

        Balance::whereIn('user_id', $members)
            ->where('user_id', '!=', Auth::id())
            ->where('colocation_id', $request->colocation_id)
            ->where('status', 1)
            ->decrement('balance', $newBalance);

        return redirect()->route('home')->with('success', 'Expense added completed successfully!');;
    }
}
