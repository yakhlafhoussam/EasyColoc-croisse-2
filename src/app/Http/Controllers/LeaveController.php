<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\Expense;
use App\Models\Invitation;
use App\Models\Membership;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Symfony\Component\Clock\now;

class LeaveController extends Controller
{
    public function leave()
    {
        $userId = Auth::id();

        $coloId = Membership::where('user_id', $userId)->where('left_at', null)->first()->colocation_id;

        $members = Membership::where('colocation_id', $coloId)->whereNull('left_at')->pluck('user_id');

        Membership::where('user_id', $userId)->where('left_at', null)->update([
            'left_at' => now()
        ]);

        $balance = Balance::where('user_id', $userId)->where('status', 1)->first();

        if ($balance->balance == 0) {
            Balance::where('user_id', $userId)->where('status', 1)->update([
                'status' => 0
            ]);
            User::where('id', Auth::id())->increment('reputation', 1);
        } elseif ($balance->balance > 0) {
            $div = $balance->balance / (count($members) - 1);
            Balance::whereIn('user_id', $members)
                ->where('user_id', '!=', Auth::id())
                ->where('colocation_id', $coloId)
                ->where('status', 1)
                ->increment('balance', $div);
            Balance::where('user_id', $userId)->where('status', 1)->update([
                'status' => 0
            ]);
            User::where('id', $userId)->increment('reputation', 1);
        } elseif ($balance->balance < 0) {
            $div = $balance->balance / (count($members) - 1);
            Balance::whereIn('user_id', $members)
                ->where('user_id', '!=', Auth::id())
                ->where('colocation_id', $coloId)
                ->where('status', 1)
                ->increment('balance', $div);
            Balance::where('user_id', $userId)->where('status', 1)->update([
                'status' => 0
            ]);
            User::where('id', $userId)->decrement('reputation', 1);
        }

        Invitation::where('email', User::where('id', Auth::id())->first()->email)->update([
            'status' => 2,
        ]);

        return redirect('/')->with('success', 'You have left the colocation');
    }

    public function kick(Request $request)
    {
        $userId = $request->user_id;

        $coloId = Membership::where('user_id', $userId)->where('left_at', null)->first()->colocation_id;

        Membership::where('user_id', $userId)->where('left_at', null)->update([
            'left_at' => now()
        ]);

        $balance = Balance::where('user_id', $userId)->where('status', 1)->first()->balance;
        Balance::where('user_id', Auth::id())
            ->where('colocation_id', $coloId)
            ->where('status', 1)
            ->increment('balance', $balance);
        Balance::where('user_id', $userId)->where('status', 1)->update([
            'status' => 0
        ]);

        return redirect('/')->with('success', 'The user was kicked from the colocation');
    }
}
