@extends('layouts.main')

@push('styles')
    <style>
        /* Additional polish */
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .hover-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
        }
        
        .status-badge {
            @apply px-3 py-1 rounded-full text-xs font-semibold;
        }
        .status-badge-active {
            @apply bg-green-100 text-green-700;
        }
        .status-badge-banned {
            @apply bg-red-100 text-red-700;
        }
        .status-badge-pending {
            @apply bg-yellow-100 text-yellow-700;
        }
        .status-badge-completed {
            @apply bg-blue-100 text-blue-700;
        }
        
        .role-badge {
            @apply px-2 py-1 rounded-full text-xs font-semibold;
        }
        .role-badge-admin {
            @apply bg-purple-100 text-purple-700;
        }
        .role-badge-user {
            @apply bg-gray-100 text-gray-600;
        }
        .role-badge-owner {
            @apply bg-amber-100 text-amber-700;
        }
    </style>
@endpush

@section('content')
    <div class="max-w-[1400px] mx-auto p-6 space-y-8">
        
        {{-- Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold flex items-center gap-3">
                    <i class="fas fa-shield-alt text-indigo-500"></i>
                    Admin Dashboard
                </h1>
                <p class="text-gray-500 mt-1">Manage users, monitor colocation statistics, and oversee platform activity</p>
            </div>
            <div class="flex gap-3">
                <div class="bg-white/70 backdrop-blur-sm px-4 py-2 rounded-xl text-sm shadow-sm">
                    <i class="fas fa-calendar-alt text-indigo-500 mr-2"></i>
                    {{ now()->format('l, d M Y') }}
                </div>
            </div>
        </div>

        {{-- Statistics Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Total Users --}}
            <div class="glass-card rounded-3xl p-6 hover-card">
                <div class="flex items-center gap-4">
                    <div class="bg-indigo-100 w-14 h-14 rounded-2xl flex items-center justify-center text-indigo-600 text-2xl">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Users</p>
                        <p class="text-3xl font-bold">{{ $totalUsers ?? 0 }}</p>
                        <p class="text-xs text-green-600 mt-1">
                            <i class="fas fa-arrow-up"></i> {{ $newUsersThisMonth ?? 0 }} this month
                        </p>
                    </div>
                </div>
                <div class="mt-3 flex gap-2 text-xs text-gray-500">
                    <span><i class="fas fa-mars text-blue-500"></i> {{ $maleUsers ?? 0 }}</span>
                    <span><i class="fas fa-venus text-pink-500"></i> {{ $femaleUsers ?? 0 }}</span>
                </div>
            </div>

            {{-- Active Colocations --}}
            <div class="glass-card rounded-3xl p-6 hover-card">
                <div class="flex items-center gap-4">
                    <div class="bg-green-100 w-14 h-14 rounded-2xl flex items-center justify-center text-green-600 text-2xl">
                        <i class="fas fa-house-chimney"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Active Colocations</p>
                        <p class="text-3xl font-bold">{{ $activeColocations ?? 0 }}</p>
                        <p class="text-xs text-gray-500 mt-1">Total: {{ $totalColocations ?? 0 }}</p>
                    </div>
                </div>
                <div class="mt-3 flex gap-2 text-xs text-gray-500">
                    <span class="text-red-500"><i class="fas fa-ban"></i> {{ $cancelledColocations ?? 0 }} cancelled</span>
                </div>
            </div>

            {{-- Total Expenses --}}
            <div class="glass-card rounded-3xl p-6 hover-card">
                <div class="flex items-center gap-4">
                    <div class="bg-amber-100 w-14 h-14 rounded-2xl flex items-center justify-center text-amber-600 text-2xl">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Expenses</p>
                        <p class="text-3xl font-bold">{{ number_format($totalExpenses ?? 0, 2) }} DH</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $totalExpensesCount ?? 0 }} transactions</p>
                    </div>
                </div>
                <div class="mt-3 text-xs text-gray-500">
                    <span>Avg: {{ number_format($averageExpenseAmount ?? 0, 2) }} DH</span>
                </div>
            </div>

            {{-- Banned Users --}}
            <div class="glass-card rounded-3xl p-6 hover-card">
                <div class="flex items-center gap-4">
                    <div class="bg-red-100 w-14 h-14 rounded-2xl flex items-center justify-center text-red-600 text-2xl">
                        <i class="fas fa-ban"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Banned Users</p>
                        <p class="text-3xl font-bold">{{ $bannedUsers ?? 0 }}</p>
                        <p class="text-xs text-red-600 mt-1">{{ $bannedPercentage ?? 0 }}% of users</p>
                    </div>
                </div>
                <div class="mt-3 text-xs text-gray-500">
                    <span><i class="fas fa-gavel"></i> {{ $debtorsCount ?? 0 }} debtors</span>
                </div>
            </div>
        </div>

        {{-- Quick Stats Row --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white/50 rounded-2xl p-4 text-center">
                <p class="text-2xl font-bold text-indigo-600">{{ $avgUsersPerColoc ?? 0 }}</p>
                <p class="text-xs text-gray-500">Avg users/coloc</p>
            </div>
            <div class="bg-white/50 rounded-2xl p-4 text-center">
                <p class="text-2xl font-bold text-green-600">{{ number_format($avgExpensePerColoc ?? 0, 2) }} DH</p>
                <p class="text-xs text-gray-500">Avg expense/coloc</p>
            </div>
            <div class="bg-white/50 rounded-2xl p-4 text-center">
                <p class="text-2xl font-bold text-purple-600">{{ $completionRate ?? 0 }}%</p>
                <p class="text-xs text-gray-500">Profile completion</p>
            </div>
            <div class="bg-white/50 rounded-2xl p-4 text-center">
                <p class="text-2xl font-bold text-amber-600">{{ $pendingInvitations ?? 0 }}</p>
                <p class="text-xs text-gray-500">Pending invites</p>
            </div>
        </div>

        {{-- User Management Section --}}
        <div class="glass-card rounded-3xl p-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                <h2 class="text-2xl font-bold flex items-center gap-2">
                    <i class="fas fa-user-cog text-indigo-500"></i>
                    User Management
                </h2>
                <div class="flex flex-wrap gap-3">
                    <div class="relative">
                        <input type="text" placeholder="Search users..." id="searchUsers"
                            class="pl-10 pr-4 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-200 outline-none w-full md:w-64">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    <select id="userFilter" class="px-4 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-200 outline-none">
                        <option value="all">All users</option>
                        <option value="active">Active only</option>
                        <option value="banned">Banned only</option>
                        <option value="admin">Admins only</option>
                    </select>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm" id="usersTable">
                    <thead class="text-left text-gray-500 border-b">
                        <tr>
                            <th class="py-3 pl-2">User</th>
                            <th class="py-3">Email / Phone</th>
                            <th class="py-3">Location</th>
                            <th class="py-3">Role</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Reputation</th>
                            <th class="py-3">Colocation</th>
                            <th class="py-3">Joined</th>
                            <th class="py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($users ?? [] as $user)
                            <tr class="hover:bg-white/50 transition" data-status="{{ $user->is_banned ? 'banned' : 'active' }}" data-role="{{ $user->is_admin ? 'admin' : 'user' }}">
                                <td class="py-3 pl-2">
                                    <div class="flex items-center gap-3">
                                        @if($user->profile_image)
                                            <img src="{{ $user->profile_image }}" class="w-8 h-8 rounded-full object-cover">
                                        @else
                                            <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-white text-xs font-bold">
                                                {{ $user->firstname ? substr($user->firstname, 0, 1) : '?' }}{{ $user->lastname ? substr($user->lastname, 0, 1) : '' }}
                                            </div>
                                        @endif
                                        <div>
                                            <span class="font-medium">{{ $user->firstname ?? 'Unknown' }} {{ $user->lastname ?? '' }}</span>
                                            @if($user->cin)
                                                <span class="text-xs text-gray-400 block">CIN: {{ $user->cin }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div>{{ $user->email ?? '—' }}</div>
                                    <div class="text-xs text-gray-400">{{ $user->phone ?? '—' }}</div>
                                </td>
                                <td class="py-3">
                                    @if($user->city || $user->country)
                                        {{ $user->city ?? '' }}{{ $user->city && $user->country ? ', ' : '' }}{{ $user->country ?? '' }}
                                    @else
                                        —
                                    @endif
                                </td>
                                <td class="py-3">
                                    @if($user->is_admin)
                                        <span class="role-badge role-badge-admin">Admin</span>
                                    @else
                                        <span class="role-badge role-badge-user">User</span>
                                    @endif
                                </td>
                                <td class="py-3">
                                    @if($user->is_banned)
                                        <span class="status-badge status-badge-banned">Banned</span>
                                    @else
                                        <span class="status-badge status-badge-active">Active</span>
                                    @endif
                                </td>
                                <td class="py-3">
                                    <div class="flex items-center gap-1">
                                        <i class="fas fa-star text-amber-500 text-xs"></i>
                                        <span>{{ $user->average_reputation ?? 'N/A' }}</span>
                                        @if($user->ratingsReceived->count() > 0)
                                            <span class="text-xs text-gray-400">({{ $user->ratingsReceived->count() }})</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3">
                                    @if($user->activeColocation)
                                        <span class="text-xs bg-indigo-50 text-indigo-700 px-2 py-1 rounded-full">
                                            {{ $user->activeColocation->name }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="py-3">{{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('d M Y') : '—' }}</td>
                                <td class="py-3">
                                    <div class="flex gap-2">
                                        @if($user->is_banned)
                                            <form action="/unban" method="POST" class="inline">
                                                @csrf
                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                <button type="submit" class="text-green-600 hover:text-green-800 p-1" title="Unban">
                                                    <i class="fas fa-check-circle"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form action="/ban" method="POST" class="inline">
                                                @csrf
                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                <button type="submit" class="text-red-600 hover:text-red-800 p-1" title="Ban">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <button class="text-gray-400 hover:text-indigo-600 p-1" title="View details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="py-8 text-center text-gray-400">
                                    <i class="fas fa-users text-4xl mb-3 opacity-30"></i>
                                    <p>No users found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Colocation Statistics Section --}}
        <div class="glass-card rounded-3xl p-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                <h2 class="text-2xl font-bold flex items-center gap-2">
                    <i class="fas fa-chart-pie text-indigo-500"></i>
                    Colocation Statistics
                </h2>
                <div class="flex flex-wrap gap-3">
                    <select id="colocationFilter" class="px-4 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-200 outline-none">
                        <option value="all">All colocations</option>
                        <option value="active">Active only</option>
                        <option value="cancelled">Cancelled only</option>
                    </select>
                    <select id="colocationSort" class="px-4 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-200 outline-none">
                        <option value="newest">Sort by: Newest</option>
                        <option value="oldest">Sort by: Oldest</option>
                        <option value="most_members">Sort by: Most members</option>
                        <option value="highest_expenses">Sort by: Highest expenses</option>
                    </select>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm" id="colocationsTable">
                    <thead class="text-left text-gray-500 border-b">
                        <tr>
                            <th class="py-3 pl-2">Colocation</th>
                            <th class="py-3">Owner</th>
                            <th class="py-3">Location</th>
                            <th class="py-3">Members</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Categories</th>
                            <th class="py-3">Total Expenses</th>
                            <th class="py-3">Avg per Member</th>
                            <th class="py-3">Created</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($colocations ?? [] as $coloc)
                            <tr class="hover:bg-white/50 transition" data-status="{{ $coloc->status ? 'active' : 'cancelled' }}">
                                <td class="py-3 pl-2 font-medium">{{ $coloc->name }}</td>
                                <td class="py-3">
                                    @if($coloc->owner)
                                        {{ $coloc->owner->firstname ?? '' }} {{ $coloc->owner->lastname ?? '' }}
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="py-3">{{ $coloc->city ?? '' }}{{ $coloc->city && $coloc->country ? ', ' : '' }}{{ $coloc->country ?? '' }}</td>
                                <td class="py-3">{{ $coloc->members_count ?? 0 }}/{{ $coloc->max_members ?? 0 }}</td>
                                <td class="py-3">
                                    @if($coloc->status == 1)
                                        <span class="status-badge status-badge-active">Active</span>
                                    @else
                                        <span class="status-badge status-badge-pending">Cancelled</span>
                                    @endif
                                </td>
                                <td class="py-3">{{ $coloc->categories_count ?? 0 }}</td>
                                <td class="py-3 font-medium">{{ number_format($coloc->total_expenses ?? 0, 2) }} DH</td>
                                <td class="py-3">{{ $coloc->members_count > 0 ? number_format(($coloc->total_expenses ?? 0) / $coloc->members_count, 2) : 0 }} DH</td>
                                <td class="py-3">{{ $coloc->created_at ? \Carbon\Carbon::parse($coloc->created_at)->format('d M Y') : '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="py-8 text-center text-gray-400">
                                    <i class="fas fa-house-chimney text-4xl mb-3 opacity-30"></i>
                                    <p>No colocations found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Additional Charts / Insights --}}
        <div class="grid md:grid-cols-2 gap-6">
            {{-- Top Colocations by Expenses --}}
            <div class="glass-card rounded-3xl p-6">
                <h3 class="text-xl font-bold mb-4 flex items-center gap-2">
                    <i class="fas fa-trophy text-amber-500"></i>
                    Top Colocations by Expenses
                </h3>
                <div class="space-y-4">
                    @forelse($topColocations ?? [] as $index => $coloc)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="w-6 h-6 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center text-xs font-bold">
                                    {{ $index + 1 }}
                                </span>
                                <span class="font-medium">{{ $coloc->name }}</span>
                                <span class="text-xs text-gray-400">({{ $coloc->members_count ?? 0 }} members)</span>
                            </div>
                            <span class="font-semibold">{{ number_format($coloc->total_expenses ?? 0, 2) }} DH</span>
                        </div>
                    @empty
                        <p class="text-gray-400 text-center py-4">No data available</p>
                    @endforelse
                </div>
            </div>

            {{-- Recent Activity --}}
            <div class="glass-card rounded-3xl p-6">
                <h3 class="text-xl font-bold mb-4 flex items-center gap-2">
                    <i class="fas fa-chart-line text-indigo-500"></i>
                    Recent Activity
                </h3>
                <div class="space-y-4 max-h-[300px] overflow-y-auto pr-2">
                    @forelse($recentActivities ?? [] as $activity)
                        <div class="flex items-start gap-3 pb-3 border-b border-gray-100 last:border-0">
                            <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 shrink-0">
                                <i class="fas {{ $activity->icon ?? 'fa-circle' }} text-xs"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm">{{ $activity->description ?? 'New activity' }}</p>
                                <p class="text-xs text-gray-400">{{ $activity->created_at ? \Carbon\Carbon::parse($activity->created_at)->diffForHumans() : 'Just now' }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-400 text-center py-4">No recent activity</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // User filtering functionality
            const userFilter = document.getElementById('userFilter');
            const searchUsers = document.getElementById('searchUsers');
            const userRows = document.querySelectorAll('#usersTable tbody tr');
            
            function filterUsers() {
                const filterValue = userFilter.value;
                const searchTerm = searchUsers.value.toLowerCase();
                
                userRows.forEach(row => {
                    const status = row.dataset.status;
                    const role = row.dataset.role;
                    const userName = row.querySelector('td:first-child .font-medium')?.textContent.toLowerCase() || '';
                    const userEmail = row.querySelector('td:nth-child(2) div:first-child')?.textContent.toLowerCase() || '';
                    
                    let showRow = true;
                    
                    // Filter by status/role
                    if (filterValue === 'active' && status !== 'active') showRow = false;
                    if (filterValue === 'banned' && status !== 'banned') showRow = false;
                    if (filterValue === 'admin' && role !== 'admin') showRow = false;
                    
                    // Filter by search term
                    if (searchTerm && !userName.includes(searchTerm) && !userEmail.includes(searchTerm)) {
                        showRow = false;
                    }
                    
                    row.style.display = showRow ? '' : 'none';
                });
            }
            
            if (userFilter) userFilter.addEventListener('change', filterUsers);
            if (searchUsers) searchUsers.addEventListener('input', filterUsers);
            
            // Colocation filtering functionality
            const colocationFilter = document.getElementById('colocationFilter');
            const colocationSort = document.getElementById('colocationSort');
            const colocationRows = document.querySelectorAll('#colocationsTable tbody tr');
            const colocationTbody = document.querySelector('#colocationsTable tbody');
            
            function filterColocations() {
                const filterValue = colocationFilter.value;
                
                colocationRows.forEach(row => {
                    const status = row.dataset.status;
                    
                    if (filterValue === 'all' || 
                        (filterValue === 'active' && status === 'active') ||
                        (filterValue === 'cancelled' && status === 'cancelled')) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
                
                sortColocations();
            }
            
            function sortColocations() {
                const sortValue = colocationSort.value;
                const visibleRows = Array.from(colocationRows).filter(row => row.style.display !== 'none');
                
                visibleRows.sort((a, b) => {
                    switch(sortValue) {
                        case 'newest':
                            const dateA = new Date(a.cells[8].textContent.trim());
                            const dateB = new Date(b.cells[8].textContent.trim());
                            return dateB - dateA;
                        case 'oldest':
                            const dateOldA = new Date(a.cells[8].textContent.trim());
                            const dateOldB = new Date(b.cells[8].textContent.trim());
                            return dateOldA - dateOldB;
                        case 'most_members':
                            const membersA = parseInt(a.cells[3].textContent.split('/')[0]);
                            const membersB = parseInt(b.cells[3].textContent.split('/')[0]);
                            return membersB - membersA;
                        case 'highest_expenses':
                            const expensesA = parseFloat(a.cells[6].textContent.replace(/[^0-9.-]+/g, ''));
                            const expensesB = parseFloat(b.cells[6].textContent.replace(/[^0-9.-]+/g, ''));
                            return expensesB - expensesA;
                        default:
                            return 0;
                    }
                });
                
                // Reorder rows in the table
                visibleRows.forEach(row => colocationTbody.appendChild(row));
            }
            
            if (colocationFilter) colocationFilter.addEventListener('change', filterColocations);
            if (colocationSort) colocationSort.addEventListener('change', sortColocations);
            
            // Initial sort
            if (colocationSort) sortColocations();
        });
        
        // Placeholder functions for view details
        function viewUserDetails(userId) {
            // You can implement this to show a modal with user details
            alert('View user details for ID: ' + userId);
            // window.location.href = '/admin/users/' + userId;
        }
        
        function viewColocationDetails(colocationId) {
            alert('View colocation details for ID: ' + colocationId);
            // window.location.href = '/admin/colocations/' + colocationId;
        }
        
        function viewColocationExpenses(colocationId) {
            alert('View expenses for colocation ID: ' + colocationId);
            // window.location.href = '/admin/colocations/' + colocationId + '/expenses';
        }
    </script>
@endpush