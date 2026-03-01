<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\Payment;
use Illuminate\Http\Request;

class PayController extends Controller
{
    public function addnew(Request $request)
    {
        $request->validate([
            'colocation_id' => 'required',
            'payer_id' => 'required',
            'title' => 'required|max:50',
            'receiver_id' => 'required',
            'amount' => 'required',
            'payment_date' => 'required',
        ]);

        Payment::create([
            'colocation_id' => $request->colocation_id,
            'payer_id' => $request->payer_id,
            'title' => $request->title,
            'receiver_id' => $request->receiver_id,
            'amount' => $request->amount,
            'payment_date' => $request->payment_date
        ]);

        Balance::where('user_id', $request->payer_id)->increment('balance', $request->amount);
        Balance::where('user_id', $request->receiver_id)->decrement('balance', $request->amount);

        return redirect()->route('home')->with('success', 'The payement was added successfully!');
    }
}
