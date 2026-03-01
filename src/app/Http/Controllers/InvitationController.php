<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invitation;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvitationMail;
use App\Models\Balance;
use App\Models\Colocation;
use App\Models\Membership;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use function Symfony\Component\Clock\now;

class InvitationController extends Controller
{
    public function sendInvitation(Request $request)
    {
        if (Membership::where('user_id', Auth::id())->first('role')->role != 1) {
            abort(403, 'You are not the owner to send the invitation');
        }

        $request->validate([
            'email' => 'required|email'
        ]);

        $check = Invitation::where('email', $request->email)->where('status', '!=', 2)->first();

        $expires = $check->expires_at->getTimestamp();

        $now = time();

        if ($check) {
            if ($check && $check->status == 0 && $expires >= $now) {
                return back()->with('warning', 'Invitation already sent and still pending');
            } elseif ($check && $check->status == 1) {
                return back()->with('warning', 'This user is already in the colocation');
            }
        }

        $colocationId = Membership::where('user_id', Auth::id())->first('colocation_id');

        $invitation = Invitation::create([
            'colocation_id' => $colocationId->colocation_id,
            'sender_id' => Auth::id(),
            'email' => $request->email,
            'token' => Str::uuid(),
            'expires_at' => Carbon::now()->addDays(7),
        ]);

        Mail::to($invitation->email)
            ->send(new InvitationMail($invitation));

        return back()->with('success', 'Invitation sent successfully');
    }

    public function accept($token)
    {
        $invitation = Invitation::where('token', $token)
            ->firstOrFail();

        if (!$invitation) {
            abort(404);
        }

        if ($invitation->expires_at < now() || (Auth::check() && $invitation->email != Auth::user()->email)) {
            abort(403, 'Invitation expired or the email not match');
        }

        if (!Auth::check()) {
            session(['invite_token' => $token]);
            return redirect('/login')->with('info', 'You need to login first !');
        }

        $max = Colocation::where('id', $invitation->colocation_id)->first()->max_members;
        $member = Membership::where('colocation_id', $invitation->colocation_id)->whereNull('left_at')->get();

        if ($max <= count($member)) {
            return redirect('/')->with('error', 'This colocation is full!');
        }

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
}
