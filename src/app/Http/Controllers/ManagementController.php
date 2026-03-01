<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\Colocation;
use App\Models\Expense;
use App\Models\Invitation;
use App\Models\Membership;
use App\Models\Payment;
use App\Models\Rating;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ManagementController extends Controller
{
    public function index()
    {
        // ===== USER STATISTICS =====
        $totalUsers = User::count();
        
        // Count banned users (is_banned = 1)
        $bannedUsers = User::where('is_banned', 1)->count();
        
        // Count new users this month
        $newUsersThisMonth = User::whereMonth('created_at', Carbon::now()->month)
                                 ->whereYear('created_at', Carbon::now()->year)
                                 ->count();
        
        // Calculate banned percentage
        $bannedPercentage = $totalUsers > 0 ? round(($bannedUsers / $totalUsers) * 100, 1) : 0;

        // ===== COLOCATION STATISTICS =====
        $totalColocations = Colocation::count();
        
        // Active colocations (status = 1)
        $activeColocations = Colocation::where('status', 1)->count();
        
        // Cancelled colocations (status = 0)
        $cancelledColocations = Colocation::where('status', 0)->count();

        // ===== EXPENSE STATISTICS =====
        $totalExpenses = Expense::sum('amount');
        $totalExpensesCount = Expense::count();
        
        // Average expense amount
        $averageExpenseAmount = $totalExpensesCount > 0 ? Expense::avg('amount') : 0;

        // ===== PAYMENT STATISTICS =====
        $totalPayments = Payment::sum('amount');
        $pendingPayments = Payment::where('status', 0)->count(); // status 0 = pending
        $completedPayments = Payment::where('status', 1)->count(); // status 1 = completed

        // ===== INVITATION STATISTICS =====
        $pendingInvitations = Invitation::where('status', 0) // status 0 = pending
                                        ->where('expires_at', '>', Carbon::now())
                                        ->count();

        // ===== RATING STATISTICS =====
        $totalRatings = Rating::count();
        $averageRating = $totalRatings > 0 ? round(Rating::avg('stars'), 1) : 0;

        // ===== AVERAGE CALCULATIONS =====
        // Average users per colocation
        $membershipsCount = Membership::whereNull('left_at')->count();
        $avgUsersPerColoc = $activeColocations > 0 
            ? round($membershipsCount / $activeColocations, 1) 
            : 0;

        // Average expense per active colocation
        $avgExpensePerColoc = $activeColocations > 0 
            ? round($totalExpenses / $activeColocations, 2) 
            : 0;

        // ===== PROFILE COMPLETION =====
        // Users with complete profiles (all major fields filled)
        $completedProfiles = User::whereNotNull('firstname')
                                 ->whereNotNull('lastname')
                                 ->whereNotNull('email')
                                 ->whereNotNull('phone')
                                 ->whereNotNull('birth_date')
                                 ->whereNotNull('country')
                                 ->whereNotNull('city')
                                 ->count();
        
        $completionRate = $totalUsers > 0 
            ? round(($completedProfiles / $totalUsers) * 100, 1) 
            : 0;

        // ===== USER LIST WITH RELATIONSHIPS =====
        // Get all users with their relationships for the table
        $users = User::with([
                'memberships' => function ($query) {
                    $query->whereNull('left_at')->with('colocation');
                },
                'ratingsReceived'
            ])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($user) {
                // Calculate average reputation from ratingsReceived
                $user->average_reputation = $user->ratingsReceived->isNotEmpty() 
                    ? round($user->ratingsReceived->avg('stars'), 1) 
                    : null;
                
                // Get active colocation (where membership has no left_at)
                $activeMembership = $user->memberships->first();
                $user->activeColocation = $activeMembership ? $activeMembership->colocation : null;
                
                return $user;
            });

        // ===== COLOCATION LIST WITH STATISTICS =====
        // Get all colocations with their relationships
        $colocations = Colocation::with([
                'memberships' => function ($query) {
                    $query->whereNull('left_at')->with('user');
                },
                'expenses',
                'memberships' => function ($query) {
                    $query->where('role', 1)->with('user');
                } // This might need to be defined in Colocation model
            ])
            ->withCount(['memberships as active_members_count' => function ($query) {
                $query->whereNull('left_at');
            }])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($colocation) {
                // Calculate total expenses for this colocation
                $colocation->total_expenses = $colocation->expenses->sum('amount');
                
                // Find owner (member with role = 1 in memberships)
                $ownerMembership = $colocation->memberships->where('role', 1)->first();
                $colocation->owner = $ownerMembership ? $ownerMembership->user : null;
                
                // Members count
                $colocation->members_count = $colocation->active_members_count;
                
                return $colocation;
            });

        // ===== TOP COLOCATIONS BY EXPENSES =====
        $topColocations = Colocation::with(['expenses'])
            ->where('status', 1) // Only active colocations
            ->get()
            ->map(function ($colocation) {
                $colocation->total_expenses = $colocation->expenses->sum('amount');
                return $colocation;
            })
            ->sortByDesc('total_expenses')
            ->take(5)
            ->values();

        // ===== RECENT ACTIVITIES =====
        // Combine recent users, colocations, expenses, and payments
        $recentActivities = collect();
        
        // Recent user registrations
        $recentUsers = User::latest()->take(3)->get()->map(function ($user) {
            return (object)[
                'description' => 'New user registered: ' . $user->firstname . ' ' . $user->lastname,
                'icon' => 'fa-user-plus',
                'created_at' => $user->created_at
            ];
        });
        
        // Recent colocations created
        $recentColocations = Colocation::latest()->take(3)->get()->map(function ($coloc) {
            return (object)[
                'description' => 'New colocation created: ' . $coloc->name,
                'icon' => 'fa-house-chimney',
                'created_at' => $coloc->created_at
            ];
        });
        
        // Recent expenses
        $recentExpenses = Expense::with(['payer'])->latest()->take(3)->get()->map(function ($expense) {
            return (object)[
                'description' => 'Expense added: ' . $expense->title . ' by ' . ($expense->payer->firstname ?? 'Unknown'),
                'icon' => 'fa-money-bill-wave',
                'created_at' => $expense->created_at
            ];
        });
        
        // Recent payments
        $recentPayments = Payment::with(['payer', 'receiver'])->latest()->take(3)->get()->map(function ($payment) {
            return (object)[
                'description' => 'Payment: ' . $payment->title . ' from ' . ($payment->payer->firstname ?? 'Unknown') . ' to ' . ($payment->receiver->firstname ?? 'Unknown'),
                'icon' => 'fa-hand-holding-heart',
                'created_at' => $payment->created_at
            ];
        });
        
        // Merge all activities and sort by date
        $recentActivities = $recentActivities
            ->concat($recentUsers)
            ->concat($recentColocations)
            ->concat($recentExpenses)
            ->concat($recentPayments)
            ->sortByDesc('created_at')
            ->take(10)
            ->values();

        // ===== ADDITIONAL STATISTICS FOR QUICK STATS ROW =====
        // Total balance across all colocations
        $totalBalance = Balance::sum('balance');
        
        // Users with positive balance (creditors)
        $creditorsCount = Balance::where('balance', '>', 0)->count();
        
        // Users with negative balance (debtors)
        $debtorsCount = Balance::where('balance', '<', 0)->count();

        // Gender distribution
        $maleUsers = User::where('gender', 'male')->count();
        $femaleUsers = User::where('gender', 'female')->count();
        
        // Occupation type distribution
        $workingUsers = User::where('type_occupation', 'work')->count();
        $studentUsers = User::where('type_occupation', 'student')->count();
        $otherUsers = User::where('type_occupation', 'other')->count();

        // Return the view with all data
        return view('admin.management', compact(
            // User statistics
            'totalUsers',
            'bannedUsers',
            'newUsersThisMonth',
            'bannedPercentage',
            'maleUsers',
            'femaleUsers',
            'workingUsers',
            'studentUsers',
            'otherUsers',
            
            // Colocation statistics
            'totalColocations',
            'activeColocations',
            'cancelledColocations',
            
            // Expense statistics
            'totalExpenses',
            'totalExpensesCount',
            'averageExpenseAmount',
            
            // Payment statistics
            'totalPayments',
            'pendingPayments',
            'completedPayments',
            
            // Invitation statistics
            'pendingInvitations',
            
            // Rating statistics
            'totalRatings',
            'averageRating',
            
            // Average calculations
            'avgUsersPerColoc',
            'avgExpensePerColoc',
            
            // Profile completion
            'completionRate',
            
            // Balance statistics
            'totalBalance',
            'creditorsCount',
            'debtorsCount',
            
            // Data collections
            'users',
            'colocations',
            'topColocations',
            'recentActivities'
        ));
    }

    public function ban(Request $request)
    {
        User::where('id', $request->user_id)->where('is_admin', 0)->update([
            'is_banned' => 1
        ]);

        return redirect()->back()->with('success', 'The user was baned successfully!');
    }

    public function unban(Request $request)
    {
        User::where('id', $request->user_id)->where('is_admin', 0)->update([
            'is_banned' => 0
        ]);

        return redirect()->back()->with('success', 'The user was baned successfully!');
    }
}
