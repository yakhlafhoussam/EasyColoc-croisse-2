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

        /* Popup styles */
        .invite-popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(5px);
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .invite-popup.active {
            display: flex;
        }

        .popup-content {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: 2rem;
            padding: 2rem;
            max-width: 600px;
            width: 90%;
            box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.3);
            animation: popupSlide 0.3s ease;
        }

        @keyframes popupSlide {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Category popup styles */
        .category-popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(5px);
            align-items: center;
            justify-content: center;
            z-index: 1001;
        }

        .category-popup.active {
            display: flex;
        }

        .category-popup .popup-content {
            max-width: 650px;
        }

        .category-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 15px;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 16px;
            margin-bottom: 8px;
            border: 1px solid rgba(79, 70, 229, 0.1);
            transition: all 0.2s;
        }

        .category-item:hover {
            background: white;
            border-color: rgba(79, 70, 229, 0.3);
            transform: translateX(4px);
        }

        .category-badge {
            width: 24px;
            height: 24px;
            border-radius: 8px;
            display: inline-block;
            margin-right: 12px;
            border: 2px solid white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .color-option {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            cursor: pointer;
            border: 3px solid transparent;
            transition: all 0.2s;
        }

        .color-option.selected {
            border-color: #4f46e5;
            transform: scale(1.1);
        }

        .icon-option {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.8);
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.2s;
            font-size: 1.2rem;
            color: #4f46e5;
        }

        .icon-option.selected {
            border-color: #4f46e5;
            background: white;
            transform: scale(1.05);
            box-shadow: 0 5px 10px rgba(79, 70, 229, 0.2);
        }

        /* Expense popup styles */
        .expense-popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(5px);
            align-items: center;
            justify-content: center;
            z-index: 1002;
        }

        .expense-popup.active {
            display: flex;
        }

        /* Settle popup styles */
        .settle-popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(5px);
            align-items: center;
            justify-content: center;
            z-index: 1003;
        }

        .settle-popup.active {
            display: flex;
        }

        /* Rating popup styles */
        .rating-popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(5px);
            align-items: center;
            justify-content: center;
            z-index: 1004;
        }

        .rating-popup.active {
            display: flex;
        }

        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
            gap: 0.5rem;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            font-size: 2.5rem;
            color: #ddd;
            cursor: pointer;
            transition: all 0.2s;
        }

        .star-rating label:hover,
        .star-rating label:hover~label,
        .star-rating input:checked~label {
            color: #fbbf24;
        }

        /* Quit and Kick buttons */
        .quit-btn {
            transition: all 0.2s;
        }

        .quit-btn:hover {
            background: #fee2e2;
            color: #dc2626;
            border-color: #fecaca;
        }

        .kick-btn {
            transition: all 0.2s;
        }

        .kick-btn:hover {
            background: #fee2e2;
            color: #dc2626;
            border-color: #fecaca;
        }

        /* Confirm Quit Popup */
        .confirm-quit-popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(5px);
            align-items: center;
            justify-content: center;
            z-index: 1005;
        }

        .confirm-quit-popup.active {
            display: flex;
        }

        .confirm-quit-popup .popup-content {
            max-width: 450px;
            text-align: center;
        }

        /* Confirm Kick Popup */
        .confirm-kick-popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(5px);
            align-items: center;
            justify-content: center;
            z-index: 1006;
        }

        .confirm-kick-popup.active {
            display: flex;
        }

        .confirm-kick-popup .popup-content {
            max-width: 450px;
            text-align: center;
        }

        .warning-icon {
            width: 70px;
            height: 70px;
            background: #fee2e2;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: #dc2626;
            font-size: 2rem;
        }

        .kick-icon {
            width: 70px;
            height: 70px;
            background: #fee2e2;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: #dc2626;
            font-size: 2rem;
        }
    </style>
@endpush

@section('content')
    <div class="max-w-[1200px] mx-auto p-6 space-y-8">

        {{-- Check if user has no colocation --}}
        @if (!isset($colocation) || !$colocation)
            {{-- No colocation message with creative design --}}
            <div class="min-h-[70vh] flex items-center justify-center">
                <div
                    class="bg-white/70 backdrop-blur-sm rounded-3xl p-12 shadow-xl border border-white/60 max-w-2xl w-full text-center">
                    <div class="relative inline-block mb-6">
                        <div class="absolute inset-0 bg-amber-300/30 blur-3xl rounded-full"></div>
                        <i class="fas fa-piggy-bank text-8xl text-amber-400 relative z-10"></i>
                        <i
                            class="fas fa-plus-circle absolute -bottom-2 -right-2 text-4xl text-indigo-500 bg-white rounded-full"></i>
                    </div>

                    <h2
                        class="text-4xl md:text-5xl font-bold mb-4 bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                        No colocation yet?
                    </h2>

                    <p class="text-xl text-gray-600 mb-8 max-w-md mx-auto">
                        Start your shared living journey today — create a colocation and invite your roommates!
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('colocation') }}"
                            class="group bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-8 py-4 rounded-xl font-bold text-lg shadow-xl hover:shadow-2xl hover:scale-105 transition flex items-center justify-center gap-3">
                            <i class="fas fa-plus-circle text-xl group-hover:rotate-90 transition"></i>
                            Create your first colocation
                        </a>
                        <a href="#"
                            class="bg-white border-2 border-indigo-200 text-indigo-700 px-8 py-4 rounded-xl font-bold text-lg hover:bg-indigo-50 transition flex items-center justify-center gap-3">
                            <i class="fas fa-question-circle"></i>
                            Learn more
                        </a>
                    </div>

                    {{-- Fun facts / steps --}}
                    <div class="grid grid-cols-3 gap-4 mt-12 pt-8 border-t border-gray-200">
                        <div class="text-center">
                            <div
                                class="bg-indigo-100 w-12 h-12 rounded-2xl flex items-center justify-center text-indigo-600 text-xl mx-auto mb-3">
                                <i class="fas fa-users"></i>
                            </div>
                            <p class="text-sm font-semibold">Add roommates</p>
                        </div>
                        <div class="text-center">
                            <div
                                class="bg-indigo-100 w-12 h-12 rounded-2xl flex items-center justify-center text-indigo-600 text-xl mx-auto mb-3">
                                <i class="fas fa-receipt"></i>
                            </div>
                            <p class="text-sm font-semibold">Track expenses</p>
                        </div>
                        <div class="text-center">
                            <div
                                class="bg-indigo-100 w-12 h-12 rounded-2xl flex items-center justify-center text-indigo-600 text-xl mx-auto mb-3">
                                <i class="fas fa-star"></i>
                            </div>
                            <p class="text-sm font-semibold">Build reputation</p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            {{-- User has colocation - show full dashboard --}}
            {{-- Header with quick actions --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold flex items-center gap-3">
                        <i class="fas fa-house-chimney text-indigo-500"></i>
                        <span>{{ $colocation->name }}</span>
                    </h1>
                    <p class="text-gray-500 mt-1 flex items-center gap-2">
                        <i class="fas fa-map-pin"></i> {{ $colocation->city }}, {{ $colocation->country }}
                        <span class="mx-2">•</span>
                        <i class="fas fa-users"></i> {{ $members->count() }}/{{ $colocation->max_members }} members
                    </p>
                </div>
                <div class="flex gap-3">
                    <button id="addExpenseBtn"
                        class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl shadow-md hover:bg-indigo-700 transition flex items-center gap-2 text-sm font-semibold">
                        <i class="fas fa-plus-circle"></i> Add expense
                    </button>
                    @if ($owner->user_id == Auth::id())
                        <button id="manageCategoriesBtn"
                            class="bg-white border border-gray-200 text-gray-700 px-5 py-2.5 rounded-xl hover:bg-gray-50 transition flex items-center gap-2 text-sm font-semibold">
                            <i class="fas fa-tags"></i> Manage categories
                        </button>
                        <button id="inviteButton"
                            class="bg-white border border-gray-200 text-gray-700 px-5 py-2.5 rounded-xl hover:bg-gray-50 transition flex items-center gap-2 text-sm font-semibold">
                            <i class="fas fa-user-plus"></i> Invite
                        </button>
                    @else
                        {{-- Quit Colocation Button for all members --}}
                        <button id="openQuitConfirmBtn"
                            class="bg-white border border-red-200 text-red-600 px-5 py-2.5 rounded-xl hover:bg-red-50 transition flex items-center gap-2 text-sm font-semibold quit-btn">
                            <i class="fas fa-sign-out-alt"></i> Quit colocation
                        </button>
                    @endif
                </div>
            </div>

            {{-- Colocation Info Card (status & description) --}}
            <div
                class="bg-white/70 backdrop-blur-sm rounded-3xl p-6 shadow-lg border border-white/60 hover:shadow-xl transition">
                <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                    <div class="flex items-center gap-4">
                        <div
                            class="bg-indigo-100 w-14 h-14 rounded-2xl flex items-center justify-center text-indigo-600 text-2xl">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            <span
                                class="px-4 py-1.5 rounded-full text-sm font-semibold inline-block
                                {{ $colocation->status == 1 ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600' }}">
                                {{ $colocation->status == 1 ? 'Active' : 'Cancelled' }}
                            </span>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Created</p>
                        <p class="font-semibold">{{ \Carbon\Carbon::parse($colocation->created_at)->format('d M Y') }}</p>
                    </div>
                </div>
                <p class="text-gray-600 leading-relaxed">{{ $colocation->desc }}</p>
            </div>

            {{-- Members Grid --}}
            <div class="bg-white/70 backdrop-blur-sm rounded-3xl p-6 shadow-lg border border-white/60">
                <h3 class="text-xl font-bold mb-6 flex items-center gap-2 border-b border-gray-200 pb-3">
                    <i class="fas fa-users text-indigo-500"></i>
                    Roommates <span class="text-sm font-normal text-gray-400 ml-2">({{ $members->count() }})</span>
                </h3>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                    @foreach ($members as $member)
                        <div class="text-center group">
                            <div class="relative inline-block">
                                @if ($member->profile_image)
                                    @if ($owner->user_id == $member->id)
                                        <img src="{{ $member->profile_image }}"
                                            onerror="if(this.src !== '{{ asset('image/shopping.png') }}') this.src='{{ asset('image/shopping.png') }}'"
                                            class="w-20 h-20 rounded-2xl mx-auto object-cover border-4 border-yellow-500 shadow-lg group-hover:scale-105 transition">
                                    @else
                                        <img src="{{ $member->profile_image }}"
                                            onerror="if(this.src !== '{{ asset('image/shopping.png') }}') this.src='{{ asset('image/shopping.png') }}'"
                                            class="w-20 h-20 rounded-2xl mx-auto object-cover border-4 border-white shadow-lg group-hover:scale-105 transition">
                                    @endif
                                @else
                                    @if ($owner->user_id == $member->id)
                                        <div id="profiles"
                                            class="w-20 h-20 rounded-full flex items-center justify-center bg-yellow-500 text-3xl text-white font-bold">
                                            {{ ucfirst(substr($member->firstname, 0, 1)) . ucfirst(substr($member->lastname, 0, 1)) }}
                                        </div>
                                    @else
                                        <div id="profiles"
                                            class="w-20 h-20 rounded-full flex items-center justify-center bg-indigo-600 text-3xl text-white font-bold">
                                            {{ ucfirst(substr($member->firstname, 0, 1)) . ucfirst(substr($member->lastname, 0, 1)) }}
                                        </div>
                                    @endif
                                @endif
                                @if ($member->role == 1)
                                    <span
                                        class="absolute -top-2 -right-2 bg-amber-500 text-white text-xs w-6 h-6 rounded-full flex items-center justify-center border-2 border-white">
                                        <i class="fas fa-crown text-xs"></i>
                                    </span>
                                @endif
                            </div>
                            <p class="font-semibold mt-3">{{ $member->firstname }} {{ $member->lastname }}</p>
                            <div class="flex items-center justify-center gap-1 text-sm text-gray-500">
                                <i class="fas fa-star text-amber-500 text-xs"></i>
                                <span>
                                    {{ $member->ratingsReceived->count() ? round($member->ratingsReceived->avg('stars'), 1).'/5' : 'N/A' }}
                                </span>
                            </div>
                            <span class="text-xs text-gray-400">
                                @if ($owner->user_id == $member->id)
                                    Owner
                                @else
                                    Member
                                @endif
                            </span>

                            {{-- Action buttons for each member --}}
                            <div class="flex flex-col gap-1 mt-2">
                                @if ($member->id != Auth::id())
                                    <button
                                        onclick="openRatingPopup({{ $member->id }}, '{{ $member->firstname }} {{ $member->lastname }}')"
                                        class="text-xs bg-indigo-50 hover:bg-indigo-100 text-indigo-600 px-3 py-1 rounded-full transition flex items-center justify-center gap-1 mx-auto">
                                        <i class="fas fa-star text-xs"></i> Rate
                                    </button>

                                    {{-- Kick Out button for owner (only shows for non-owner members) --}}
                                    @if ($owner->user_id == Auth::id() && $member->id != Auth::id())
                                        <button
                                            onclick="openKickPopup({{ $member->id }}, '{{ $member->firstname }} {{ $member->lastname }}')"
                                            class="text-xs bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1 rounded-full transition flex items-center justify-center gap-1 mx-auto kick-btn">
                                            <i class="fas fa-user-minus text-xs"></i> Kick out
                                        </button>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Expenses & Balances 2-column layout --}}
            <div class="grid lg:grid-cols-3 gap-6">
                {{-- Expenses table (takes 2 cols) --}}
                {{-- Expenses table (takes 2 cols) --}}
                <div class="lg:col-span-2 bg-white/70 backdrop-blur-sm rounded-3xl p-6 shadow-lg border border-white/60">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold flex items-center gap-2">
                            <i class="fas fa-money-bill-wave text-indigo-500"></i>
                            Shared Expenses
                        </h3>
                    </div>

                    @if ($expenses->count())
                        <div class="expenses-container relative">
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead class="text-left text-gray-500 border-b">
                                        <tr>
                                            <th class="py-3 pl-2">Title</th>
                                            <th class="py-3">Amount</th>
                                            <th class="py-3">Category</th>
                                            <th class="py-3">Payer</th>
                                            <th class="py-3">Date</th>
                                            <th class="py-3"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y" id="expensesTableBody">
                                        @foreach ($expenses as $index => $exp)
                                            <tr class="expense-item hover:bg-white/50 transition {{ $index >= 6 ? 'hidden' : '' }}"
                                                data-index="{{ $index }}">
                                                <td class="py-3 pl-2 font-medium">{{ $exp->title }}</td>
                                                <td class="py-3">{{ number_format($exp->amount, 2) }} DH</td>
                                                <td class="py-3">
                                                    <span
                                                        class="bg-[{{ $exp->category->color }}]/20 text-[{{ $exp->category->color }}] px-2 py-1 rounded-full text-xs">
                                                        <i class="fas {{ $exp->category->icon }} mr-1"
                                                            style="color: {{ $exp->category->color }};"></i>
                                                        <span
                                                            class="font-medium text-[{{ $exp->category->color }}]">{{ $exp->category->name }}</span>
                                                    </span>
                                                </td>
                                                <td class="py-3 flex gap-1 items-center">
                                                    @if ($exp->payer->profile_image)
                                                        <img src="{{ $exp->payer->profile_image }}"
                                                            class="w-10 h-10 rounded-full border-2 {{ $exp->payer->is_admin == 1 ? 'border-yellow-500' : 'border-white' }} shadow-xl"
                                                            onerror="this.src='{{ asset('image/shopping.png') }}'">
                                                    @else
                                                        <div
                                                            class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white text-xs font-bold">
                                                            {{ ucfirst(substr($exp->payer->firstname, 0, 1)) }}{{ ucfirst(substr($exp->payer->lastname, 0, 1)) }}
                                                        </div>
                                                    @endif
                                                    {{ ucfirst(substr($exp->payer->firstname, 0, 1)) }}.{{ ucfirst($exp->payer->lastname) }}
                                                </td>
                                                <td class="py-3">
                                                    {{ \Carbon\Carbon::parse($exp->date)->format('d M Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @if ($expenses->count() > 6)
                                <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-200">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm text-gray-600">Showing <span
                                                id="expensesStartCount">1</span>-<span id="expensesEndCount">6</span> of
                                            <span id="expensesTotalCount">{{ $expenses->count() }}</span></span>
                                    </div>
                                    <div class="flex gap-2">
                                        <button id="expensesPrevPage"
                                            class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl text-sm font-semibold hover:bg-indigo-100 transition flex items-center gap-1 disabled:opacity-50 disabled:cursor-not-allowed"
                                            disabled>
                                            <i class="fas fa-chevron-left text-xs"></i> Previous
                                        </button>
                                        <button id="expensesNextPage"
                                            class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl text-sm font-semibold hover:bg-indigo-100 transition flex items-center gap-1">
                                            Next <i class="fas fa-chevron-right text-xs"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-10 text-gray-400">
                            <i class="fas fa-receipt text-5xl mb-3 opacity-30"></i>
                            <p>No expenses added yet. Be the first to add one!</p>
                        </div>
                    @endif
                </div>

                {{-- Balances & quick settle (1 col) --}}
                {{-- Balances & quick settle (1 col) --}}
                <div class="bg-white/70 backdrop-blur-sm rounded-3xl p-6 shadow-lg border border-white/60">
                    <h3 class="text-xl font-bold mb-6 flex items-center gap-2 border-b border-gray-200 pb-3">
                        <i class="fas fa-scale-balanced text-indigo-500"></i>
                        Balances
                    </h3>

                    @if (count($balances))
                        <div class="balances-container relative">
                            <div class="balances-list space-y-4" id="balancesList">
                                @foreach ($balances as $memberName => $amount)
                                    <div class="balance-item flex justify-between items-center p-3 bg-white/50 rounded-xl"
                                        data-index="{{ $loop->index }}">
                                        <span class="font-semibold">{{ $memberName }}</span>
                                        <span class="font-bold {{ $amount >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $amount >= 0 ? '+' : '' }}{{ number_format($amount, 2) }} DH
                                        </span>
                                    </div>
                                @endforeach
                            </div>

                            @if (count($balances) > 6)
                                <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-200">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm text-gray-600">Showing <span
                                                id="balancesStartCount">1</span>-<span id="balancesEndCount">6</span> of
                                            <span id="balancesTotalCount">{{ count($balances) }}</span></span>
                                    </div>
                                    <div class="flex gap-2">
                                        <button id="balancesPrevPage"
                                            class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl text-sm font-semibold hover:bg-indigo-100 transition flex items-center gap-1 disabled:opacity-50 disabled:cursor-not-allowed"
                                            disabled>
                                            <i class="fas fa-chevron-left text-xs"></i> Previous
                                        </button>
                                        <button id="balancesNextPage"
                                            class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl text-sm font-semibold hover:bg-indigo-100 transition flex items-center gap-1">
                                            Next <i class="fas fa-chevron-right text-xs"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <button id="settleDebtsBtn"
                            class="mt-6 w-full bg-indigo-50 text-indigo-700 py-3 rounded-xl font-medium text-sm hover:bg-indigo-100 transition flex items-center justify-center gap-2">
                            <i class="fas fa-hand-holding-heart"></i> Settle debts
                        </button>
                    @else
                        <div class="text-center py-8 text-gray-400">
                            <i class="fas fa-coins text-4xl mb-2 opacity-30"></i>
                            <p class="text-sm">No balances yet.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- History & Ratings 2-column layout --}}
            <div class="grid md:grid-cols-2 gap-6">
                {{-- Colocation History with Pagination --}}
                <div class="bg-white/70 backdrop-blur-sm rounded-3xl p-6 shadow-lg border border-white/60">
                    <h3 class="text-xl font-bold mb-6 flex items-center gap-2 border-b border-gray-200 pb-3">
                        <i class="fas fa-clock-rotate-left text-indigo-500"></i>
                        Colocation History
                    </h3>

                    @php
                        $history1 = $memberss
                            ->flatMap(
                                fn($m) => $m->paymentsReceived->map(fn($p) => ['type' => 'payment', 'data' => $p]),
                            )
                            ->sortByDesc('created_at');
                        $history2 = $memberss
                            ->flatMap(fn($m) => $m->expenses->map(fn($e) => ['type' => 'expense', 'data' => $e]))
                            ->sortByDesc('created_at');

                        $fullHistory = $history1
                            ->merge($history2)
                            ->sortByDesc(fn($item) => $item['data']->created_at)
                            ->values();
                    @endphp

                    <div class="history-container relative">
                        <div class="history-list max-h-[500px] overflow-y-auto pr-2">
                            @forelse($fullHistory as $index => $hist)
                                @php
                                    $type = $hist['type'];
                                    $data = $hist['data'];
                                @endphp
                                @if ($type === 'payment')
                                    <div class="history-item border-b border-gray-100 last:border-0 py-4 first:pt-0 {{ $index >= 5 ? 'hidden' : '' }}"
                                        data-index="{{ $index }}">
                                        <p class="text-yellow-500 text-sm font-bold mb-2">Payment</p>
                                        <div class="flex justify-between items-start">
                                            <div class="flex items-center gap-2">
                                                @if ($data->payer->profile_image)
                                                    <img src="{{ $data->payer->profile_image }}"
                                                        class="w-10 h-10 rounded-full border-2 {{ $data->payer->is_admin == 1 ? 'border-yellow-500' : 'border-white' }} shadow-xl"
                                                        onerror="this.src='{{ asset('image/shopping.png') }}'">
                                                @else
                                                    <div
                                                        class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white text-xs font-bold">
                                                        {{ ucfirst(substr($data->payer->firstname, 0, 1)) }}{{ ucfirst(substr($data->payer->lastname, 0, 1)) }}
                                                    </div>
                                                @endif

                                                <div>
                                                    <p class="font-semibold text-sm">{{ $data->payer->firstname }}
                                                        {{ $data->payer->lastname }}</p>
                                                </div>

                                                <p class="font-bold">-></p>

                                                @if ($data->receiver->profile_image)
                                                    <img src="{{ $data->receiver->profile_image }}"
                                                        class="w-10 h-10 rounded-full border-2 {{ $data->receiver->is_admin == 1 ? 'border-yellow-500' : 'border-white' }} shadow-xl"
                                                        onerror="this.src='{{ asset('image/shopping.png') }}'">
                                                @else
                                                    <div
                                                        class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                                                        {{ ucfirst(substr($data->receiver->firstname, 0, 1)) }}{{ ucfirst(substr($data->receiver->lastname, 0, 1)) }}
                                                    </div>
                                                @endif

                                                <div>
                                                    <p class="font-semibold text-sm">{{ $data->receiver->firstname }}
                                                        {{ $data->receiver->lastname }}</p>
                                                </div>
                                            </div>
                                            <span
                                                class="text-xs text-gray-400">{{ $data->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="flex gap-2 mt-4">
                                            <span class="font-bold text-green-600">
                                                {{ number_format($data->amount, 2) }} DH
                                            </span>
                                            <p class="text-sm text-gray-600">"{{ $data->title }}"</p>
                                        </div>
                                    </div>
                                @elseif($type === 'expense')
                                    <div class="history-item border-b border-gray-100 last:border-0 py-4 first:pt-0 {{ $index >= 5 ? 'hidden' : '' }}"
                                        data-index="{{ $index }}">
                                        <p class="text-blue-500 text-sm font-bold mb-2">Expense</p>
                                        <div class="flex justify-between items-start">
                                            <div class="flex items-center gap-2">
                                                @if ($data->payer->profile_image)
                                                    <img src="{{ $data->payer->profile_image }}"
                                                        class="w-10 h-10 rounded-full border-2 {{ $data->payer->is_admin == 1 ? 'border-yellow-500' : 'border-white' }} shadow-xl"
                                                        onerror="this.src='{{ asset('image/shopping.png') }}'">
                                                @else
                                                    <div
                                                        class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white text-xs font-bold">
                                                        {{ ucfirst(substr($data->payer->firstname, 0, 1)) }}{{ ucfirst(substr($data->payer->lastname, 0, 1)) }}
                                                    </div>
                                                @endif

                                                <div>
                                                    <p class="font-semibold text-sm">{{ $data->payer->firstname }}
                                                        {{ $data->payer->lastname }}</p>
                                                </div>
                                            </div>
                                            <span
                                                class="text-xs text-gray-400">{{ $data->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="flex gap-2 mt-4">
                                            <span
                                                class="bg-[{{ $data->category->color }}]/20 text-[{{ $data->category->color }}] px-2 py-1 rounded-full text-xs">
                                                <i class="fas {{ $data->category->icon }} mr-1"
                                                    style="color: {{ $data->category->color }};"></i>
                                                <span
                                                    class="font-medium text-[{{ $data->category->color }}]">{{ $data->category->name }}</span>
                                            </span>
                                            <span class="font-bold text-green-600">
                                                {{ number_format($data->amount, 2) }} DH
                                            </span>
                                            <p class="text-sm text-gray-600">"{{ $data->title }}"</p>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <p class="text-gray-400 text-sm text-center py-6">No colocation history yet.</p>
                            @endforelse
                        </div>

                        @if ($fullHistory->count() > 5)
                            <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-200">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-gray-600">Showing <span
                                            id="historyStartCount">1</span>-<span id="historyEndCount">5</span> of <span
                                            id="historyTotalCount">{{ $fullHistory->count() }}</span></span>
                                </div>
                                <div class="flex gap-2">
                                    <button id="historyPrevPage"
                                        class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl text-sm font-semibold hover:bg-indigo-100 transition flex items-center gap-1 disabled:opacity-50 disabled:cursor-not-allowed"
                                        disabled>
                                        <i class="fas fa-chevron-left text-xs"></i> Previous
                                    </button>
                                    <button id="historyNextPage"
                                        class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl text-sm font-semibold hover:bg-indigo-100 transition flex items-center gap-1">
                                        Next <i class="fas fa-chevron-right text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Ratings with Pagination --}}
                <div class="bg-white/70 backdrop-blur-sm rounded-3xl p-6 shadow-lg border border-white/60">
                    <h3 class="text-xl font-bold mb-6 flex items-center gap-2 border-b border-gray-200 pb-3">
                        <i class="fas fa-star text-amber-500"></i>
                        Recent Ratings
                    </h3>

                    @php
                        $ratings = $memberss->flatMap(fn($m) => $m->ratingsReceived)->sortByDesc('created_at');
                    @endphp

                    <div class="ratings-container relative">
                        <div class="ratings-list max-h-[500px] overflow-y-auto pr-2">
                            @forelse($ratings as $index => $rating)
                                <div class="rating-item border-b border-gray-100 last:border-0 py-4 first:pt-0 {{ $index >= 5 ? 'hidden' : '' }}"
                                    data-index="{{ $index }}">
                                    <div class="flex justify-between items-start">
                                        <div class="flex items-center gap-2">
                                            @if ($rating->fromUser->profile_image)
                                                <img src="{{ $rating->fromUser->profile_image }}"
                                                    class="w-10 h-10 rounded-full border-2 {{ $rating->fromUser->is_admin == 1 ? 'border-yellow-500' : 'border-white' }} shadow-xl"
                                                    onerror="this.src='{{ asset('image/shopping.png') }}'">
                                            @else
                                                <div
                                                    class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white text-xs font-bold">
                                                    {{ ucfirst(substr($rating->fromUser->firstname, 0, 1)) }}{{ ucfirst(substr($rating->fromUser->lastname, 0, 1)) }}
                                                </div>
                                            @endif

                                            <div>
                                                <p class="font-semibold text-sm">{{ $rating->fromUser->firstname }}
                                                    {{ $rating->fromUser->lastname }}</p>
                                            </div>

                                            <p class="font-bold">-></p>

                                            @if ($rating->toUser->profile_image)
                                                <img src="{{ $rating->toUser->profile_image }}"
                                                    class="w-10 h-10 rounded-full border-2 {{ $rating->toUser->is_admin == 1 ? 'border-yellow-500' : 'border-white' }} shadow-xl"
                                                    onerror="this.src='{{ asset('image/shopping.png') }}'">
                                            @else
                                                <div
                                                    class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                                                    {{ ucfirst(substr($rating->toUser->firstname, 0, 1)) }}{{ ucfirst(substr($rating->toUser->lastname, 0, 1)) }}
                                                </div>
                                            @endif

                                            <div>
                                                <p class="font-semibold text-sm">{{ $rating->toUser->firstname }}
                                                    {{ $rating->toUser->lastname }}</p>
                                            </div>
                                        </div>
                                        <span
                                            class="text-xs text-gray-400">{{ $rating->updated_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="flex gap-2 mt-4">
                                        <div class="flex items-center gap-1 text-amber-500 text-xs">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i
                                                    class="fas fa-star {{ $i <= $rating->stars ? 'text-amber-500' : 'text-gray-300' }}"></i>
                                            @endfor
                                        </div>
                                        <p class="text-sm text-gray-600">"{{ $rating->comment }}"</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-400 text-sm text-center py-6">No ratings yet.</p>
                            @endforelse
                        </div>

                        @if ($ratings->count() > 5)
                            <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-200">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-gray-600">Showing <span id="startCount">1</span>-<span
                                            id="endCount">5</span> of <span
                                            id="totalCount">{{ $ratings->count() }}</span></span>
                                </div>
                                <div class="flex gap-2">
                                    <button id="prevPage"
                                        class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl text-sm font-semibold hover:bg-indigo-100 transition flex items-center gap-1 disabled:opacity-50 disabled:cursor-not-allowed"
                                        disabled>
                                        <i class="fas fa-chevron-left text-xs"></i> Previous
                                    </button>
                                    <button id="nextPage"
                                        class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl text-sm font-semibold hover:bg-indigo-100 transition flex items-center gap-1">
                                        Next <i class="fas fa-chevron-right text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
    </div>

    {{-- Invite Popup --}}
    <div id="invitePopup" class="invite-popup">
        <div class="popup-content">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold flex items-center gap-2">
                    <i class="fas fa-envelope-open-text text-indigo-500"></i>
                    Invite via email
                </h3>
                <button id="closePopup" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
            </div>

            <form action="invitation" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email address</label>
                    <input type="email" name="email" placeholder="Email"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 outline-none transition">
                </div>
                <div class="flex gap-3 pt-4">
                    <button type="submit"
                        class="flex-1 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg transition">
                        Send invitation
                    </button>
                    <button type="button" id="cancelPopup"
                        class="px-6 py-3 border border-gray-200 rounded-xl font-semibold text-gray-700 hover:bg-gray-50 transition">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Add Expense Popup --}}
    <div id="expensePopup" class="expense-popup">
        <div class="popup-content">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold flex items-center gap-2">
                    <i class="fas fa-money-bill-wave text-indigo-500"></i>
                    Add new expense
                </h3>
                <button id="closeExpensePopup" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
            </div>

            <form action="/expense" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="colocation_id" value="{{ $colocation->id }}">

                {{-- Title --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                    <input type="text" name="title" placeholder="e.g. Groceries, Rent, Electricity"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 outline-none transition"
                        required>
                </div>

                {{-- Amount --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Amount (DH)</label>
                    <input type="number" name="amount" placeholder="0.00" step="0.01" min="0"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 outline-none transition"
                        required>
                </div>

                {{-- Category --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select name="categorie_id"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 outline-none transition"
                        required>
                        <option value="">Select a category</option>
                        @foreach ($category as $cat)
                            <option value="{{ $cat->id }}" style="color: {{ $cat->color }};">
                                <i class="fas {{ $cat->icon }}"></i> {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit"
                        class="flex-1 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg transition">
                        <i class="fas fa-plus-circle mr-2"></i> Add expense
                    </button>
                    <button type="button" id="cancelExpensePopup"
                        class="px-6 py-3 border border-gray-200 rounded-xl font-semibold text-gray-700 hover:bg-gray-50 transition">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Manage Categories Popup (with name, color, icon) --}}
    <div id="categoryPopup" class="category-popup">
        <div class="popup-content">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold flex items-center gap-2">
                    <i class="fas fa-tags text-indigo-500"></i>
                    Manage categories
                </h3>
                <button id="closeCategoryPopup" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
            </div>

            {{-- Add new category form with name, color, icon --}}
            <form action="categories" method="POST" class="space-y-6 mb-8">
                @csrf
                <input type="hidden" name="colocation_id" value="{{ $colocation->id }}">

                {{-- Category name --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category name</label>
                    <input type="text" name="name" placeholder="e.g. Rent, Groceries, Utilities"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 outline-none transition"
                        required>
                </div>

                {{-- Color picker --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Color</label>
                    <div class="flex flex-wrap gap-3">
                        <div class="color-option selected" style="background: #3b82f6;" data-color="#3b82f6"
                            onclick="selectColor(this)"></div>
                        <div class="color-option" style="background: #10b981;" data-color="#10b981"
                            onclick="selectColor(this)"></div>
                        <div class="color-option" style="background: #f59e0b;" data-color="#f59e0b"
                            onclick="selectColor(this)"></div>
                        <div class="color-option" style="background: #ef4444;" data-color="#ef4444"
                            onclick="selectColor(this)"></div>
                        <div class="color-option" style="background: #8b5cf6;" data-color="#8b5cf6"
                            onclick="selectColor(this)"></div>
                        <div class="color-option" style="background: #ec4899;" data-color="#ec4899"
                            onclick="selectColor(this)"></div>
                        <div class="color-option" style="background: #14b8a6;" data-color="#14b8a6"
                            onclick="selectColor(this)"></div>
                        <div class="color-option" style="background: #f97316;" data-color="#f97316"
                            onclick="selectColor(this)"></div>
                    </div>
                    <input type="hidden" name="color" id="selectedColor" value="#3b82f6">
                </div>

                {{-- Icon picker --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Icon</label>
                    <div class="grid grid-cols-6 gap-2">
                        <div class="icon-option selected" data-icon="fa-home" onclick="selectIcon(this)"><i
                                class="fas fa-home"></i></div>
                        <div class="icon-option" data-icon="fa-cart-shopping" onclick="selectIcon(this)"><i
                                class="fas fa-cart-shopping"></i></div>
                        <div class="icon-option" data-icon="fa-bolt" onclick="selectIcon(this)"><i
                                class="fas fa-bolt"></i></div>
                        <div class="icon-option" data-icon="fa-wifi" onclick="selectIcon(this)"><i
                                class="fas fa-wifi"></i></div>
                        <div class="icon-option" data-icon="fa-gas-pump" onclick="selectIcon(this)"><i
                                class="fas fa-gas-pump"></i></div>
                        <div class="icon-option" data-icon="fa-utensils" onclick="selectIcon(this)"><i
                                class="fas fa-utensils"></i></div>
                        <div class="icon-option" data-icon="fa-tv" onclick="selectIcon(this)"><i class="fas fa-tv"></i>
                        </div>
                        <div class="icon-option" data-icon="fa-water" onclick="selectIcon(this)"><i
                                class="fas fa-water"></i></div>
                        <div class="icon-option" data-icon="fa-trash" onclick="selectIcon(this)"><i
                                class="fas fa-trash"></i></div>
                        <div class="icon-option" data-icon="fa-shield" onclick="selectIcon(this)"><i
                                class="fas fa-shield"></i></div>
                        <div class="icon-option" data-icon="fa-wine-bottle" onclick="selectIcon(this)"><i
                                class="fas fa-wine-bottle"></i></div>
                        <div class="icon-option" data-icon="fa-dumbbell" onclick="selectIcon(this)"><i
                                class="fas fa-dumbbell"></i></div>
                    </div>
                    <input type="hidden" name="icon" id="selectedIcon" value="fa-home">
                </div>

                <button type="submit"
                    class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg transition">
                    <i class="fas fa-plus-circle mr-2"></i> Add category
                </button>
            </form>

            {{-- Categories list with icons and colors --}}
            <div class="border-t border-gray-200 pt-6">
                <h4 class="font-semibold mb-4">Existing categories</h4>
                <div class="space-y-2 max-h-[250px] overflow-y-auto pr-2">
                    @foreach ($category as $categor)
                        <div class="category-item">
                            <div class="flex items-center">
                                <span class="category-badge" style="background: {{ $categor->color }};"></span>
                                <i class="fas {{ $categor->icon }} w-6 mr-2"
                                    style="color: {{ $categor->color }};"></i>
                                <span class="font-medium">{{ $categor->name }}</span>
                            </div>
                            <form action="deletecat" method="POST">
                                @csrf
                                <button type="submit" class="text-red-400 hover:text-red-600 transition">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button type="button" id="cancelCategoryPopup"
                    class="px-6 py-3 border border-gray-200 rounded-xl font-semibold text-gray-700 hover:bg-gray-50 transition">
                    Close
                </button>
            </div>
        </div>
    </div>

    {{-- Settle Debts Popup --}}
    <div id="settlePopup" class="settle-popup">
        <div class="popup-content">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold flex items-center gap-2">
                    <i class="fas fa-hand-holding-heart text-indigo-500"></i>
                    Settle debts
                </h3>
                <button id="closeSettlePopup" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
            </div>

            <form action="settle" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="colocation_id" value="{{ $colocation->id }}">
                <input type="hidden" name="payer_id" value="{{ Auth::id() }}">

                {{-- Title (description of the settlement) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                    <input type="text" name="title" placeholder="e.g. Settlement for groceries, Rent share..."
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 outline-none transition"
                        required>
                </div>

                {{-- Display who is paying (read-only info) --}}
                <div class="bg-indigo-50 p-4 rounded-xl border border-indigo-100">
                    <label class="block text-sm font-medium text-indigo-700 mb-1">Who is paying</label>
                    <p class="font-semibold text-indigo-800 flex items-center gap-2">
                        <i class="fas fa-user-circle"></i>
                        {{ Auth::user()->firstname }} {{ Auth::user()->lastname }} (You)
                    </p>
                    <p class="text-xs text-indigo-600 mt-1">This payment will be recorded from your account</p>
                </div>

                {{-- Select who is receiving (receiver) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Who is receiving?</label>
                    <select name="receiver_id"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 outline-none transition"
                        required>
                        <option value="">Select who receives</option>
                        @foreach ($members as $member)
                            @if ($member->id != Auth::id())
                                <option value="{{ $member->id }}">{{ $member->firstname }} {{ $member->lastname }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>

                {{-- Amount --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Amount (DH)</label>
                    <input type="number" name="amount" placeholder="0.00" step="0.01" min="0"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 outline-none transition"
                        required>
                </div>

                {{-- Payment date --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Payment date</label>
                    <input type="date" name="payment_date" value="{{ date('Y-m-d') }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 outline-none transition"
                        required>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit"
                        class="flex-1 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg transition">
                        <i class="fas fa-check-circle mr-2"></i> Confirm settlement
                    </button>
                    <button type="button" id="cancelSettlePopup"
                        class="px-6 py-3 border border-gray-200 rounded-xl font-semibold text-gray-700 hover:bg-gray-50 transition">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Rating Popup --}}
    <div id="ratingPopup" class="rating-popup">
        <div class="popup-content">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold flex items-center gap-2">
                    <i class="fas fa-star text-amber-500"></i>
                    Rate <span id="ratingUserName"></span>
                </h3>
                <button id="closeRatingPopup" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
            </div>

            <form action="rating" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="to_user_id" id="ratingUserId">

                {{-- Star rating --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Your rating</label>
                    <div class="star-rating">
                        <input type="radio" name="stars" value="5" id="star5"><label for="star5"
                            class="fas fa-star"></label>
                        <input type="radio" name="stars" value="4" id="star4"><label for="star4"
                            class="fas fa-star"></label>
                        <input type="radio" name="stars" value="3" id="star3"><label for="star3"
                            class="fas fa-star"></label>
                        <input type="radio" name="stars" value="2" id="star2"><label for="star2"
                            class="fas fa-star"></label>
                        <input type="radio" name="stars" value="1" id="star1" checked><label
                            for="star1" class="fas fa-star"></label>
                    </div>
                </div>

                {{-- Comment --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Comment (optional)</label>
                    <textarea name="comment" rows="3" placeholder="Share your experience with this roommate..."
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 outline-none transition resize-none"></textarea>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit"
                        class="flex-1 bg-gradient-to-r from-amber-500 to-orange-500 text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg transition">
                        <i class="fas fa-paper-plane mr-2"></i> Submit rating
                    </button>
                    <button type="button" id="cancelRatingPopup"
                        class="px-6 py-3 border border-gray-200 rounded-xl font-semibold text-gray-700 hover:bg-gray-50 transition">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Confirm Quit Popup --}}
    <div id="confirmQuitPopup" class="confirm-quit-popup">
        <div class="popup-content">
            <div class="warning-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>

            <h3 class="text-2xl font-bold mb-3">Leave colocation?</h3>

            <p class="text-gray-600 mb-6">
                Are you sure you want to quit <span class="font-semibold">{{ $colocation->name }}</span>?<br>
                You will lose access to all shared expenses and balances.
            </p>

            <form action="leave" method="POST" id="quitColocationForm">
                @csrf

                <div class="flex gap-3">
                    <button type="submit"
                        class="flex-1 bg-red-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-red-700 transition">
                        <i class="fas fa-check-circle mr-2"></i> Yes, leave
                    </button>
                    <button type="button" id="cancelQuitPopup"
                        class="flex-1 px-6 py-3 border border-gray-200 rounded-xl font-semibold text-gray-700 hover:bg-gray-50 transition">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Confirm Kick Popup --}}
    <div id="confirmKickPopup" class="confirm-kick-popup">
        <div class="popup-content">
            <div class="kick-icon">
                <i class="fas fa-user-minus"></i>
            </div>

            <h3 class="text-2xl font-bold mb-3">Kick member?</h3>

            <p class="text-gray-600 mb-6">
                Are you sure you want to kick <span id="kickUserName" class="font-semibold"></span> from <span
                    class="font-semibold">{{ $colocation->name }}</span>?<br>
                This action cannot be undone.
            </p>

            <form action="/kick" method="POST" id="kickMemberForm">
                @csrf
                <input type="hidden" name="user_id" id="kickUserId">

                <div class="flex gap-3">
                    <button type="submit"
                        class="flex-1 bg-red-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-red-700 transition">
                        <i class="fas fa-check-circle mr-2"></i> Yes, kick
                    </button>
                    <button type="button" id="cancelKickPopup"
                        class="flex-1 px-6 py-3 border border-gray-200 rounded-xl font-semibold text-gray-700 hover:bg-gray-50 transition">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Expenses pagination
            const expenseItems = document.querySelectorAll('.expense-item');
            const expensesPrevBtn = document.getElementById('expensesPrevPage');
            const expensesNextBtn = document.getElementById('expensesNextPage');
            const expensesStartSpan = document.getElementById('expensesStartCount');
            const expensesEndSpan = document.getElementById('expensesEndCount');

            if (expenseItems.length > 0 && expensesPrevBtn && expensesNextBtn) {
                const expensesPerPage = 6;
                let expensesCurrentPage = 1;
                const expensesTotalPages = Math.ceil(expenseItems.length / expensesPerPage);

                function showExpensesPage(page) {
                    const start = (page - 1) * expensesPerPage;
                    const end = start + expensesPerPage;

                    expenseItems.forEach((item, index) => {
                        if (index >= start && index < end) {
                            item.classList.remove('hidden');
                        } else {
                            item.classList.add('hidden');
                        }
                    });

                    // Update button states
                    expensesPrevBtn.disabled = page === 1;
                    expensesNextBtn.disabled = page === expensesTotalPages;

                    // Update counter
                    if (expensesStartSpan && expensesEndSpan) {
                        expensesStartSpan.textContent = start + 1;
                        expensesEndSpan.textContent = Math.min(end, expenseItems.length);
                    }

                    expensesCurrentPage = page;
                }

                expensesPrevBtn.addEventListener('click', () => {
                    if (expensesCurrentPage > 1) {
                        showExpensesPage(expensesCurrentPage - 1);
                    }
                });

                expensesNextBtn.addEventListener('click', () => {
                    if (expensesCurrentPage < expensesTotalPages) {
                        showExpensesPage(expensesCurrentPage + 1);
                    }
                });

                // Initialize first page
                showExpensesPage(1);
            }

            // Balances pagination
            const balanceItems = document.querySelectorAll('.balance-item');
            const balancesPrevBtn = document.getElementById('balancesPrevPage');
            const balancesNextBtn = document.getElementById('balancesNextPage');
            const balancesStartSpan = document.getElementById('balancesStartCount');
            const balancesEndSpan = document.getElementById('balancesEndCount');

            if (balanceItems.length > 0 && balancesPrevBtn && balancesNextBtn) {
                const balancesPerPage = 6;
                let balancesCurrentPage = 1;
                const balancesTotalPages = Math.ceil(balanceItems.length / balancesPerPage);

                function showBalancesPage(page) {
                    const start = (page - 1) * balancesPerPage;
                    const end = start + balancesPerPage;

                    balanceItems.forEach((item, index) => {
                        if (index >= start && index < end) {
                            item.classList.remove('hidden');
                        } else {
                            item.classList.add('hidden');
                        }
                    });

                    // Update button states
                    balancesPrevBtn.disabled = page === 1;
                    balancesNextBtn.disabled = page === balancesTotalPages;

                    // Update counter
                    if (balancesStartSpan && balancesEndSpan) {
                        balancesStartSpan.textContent = start + 1;
                        balancesEndSpan.textContent = Math.min(end, balanceItems.length);
                    }

                    balancesCurrentPage = page;
                }

                balancesPrevBtn.addEventListener('click', () => {
                    if (balancesCurrentPage > 1) {
                        showBalancesPage(balancesCurrentPage - 1);
                    }
                });

                balancesNextBtn.addEventListener('click', () => {
                    if (balancesCurrentPage < balancesTotalPages) {
                        showBalancesPage(balancesCurrentPage + 1);
                    }
                });

                // Initialize first page
                showBalancesPage(1);
            }

            // History pagination
            const historyItems = document.querySelectorAll('.history-item');
            const historyPrevBtn = document.getElementById('historyPrevPage');
            const historyNextBtn = document.getElementById('historyNextPage');
            const historyStartSpan = document.getElementById('historyStartCount');
            const historyEndSpan = document.getElementById('historyEndCount');

            if (historyItems.length > 0 && historyPrevBtn && historyNextBtn) {
                const itemsPerPage = 3;
                let currentPage = 1;
                const totalPages = Math.ceil(historyItems.length / itemsPerPage);

                function showHistoryPage(page) {
                    const start = (page - 1) * itemsPerPage;
                    const end = start + itemsPerPage;

                    historyItems.forEach((item, index) => {
                        if (index >= start && index < end) {
                            item.classList.remove('hidden');
                        } else {
                            item.classList.add('hidden');
                        }
                    });

                    // Update button states
                    historyPrevBtn.disabled = page === 1;
                    historyNextBtn.disabled = page === totalPages;

                    // Update counter
                    if (historyStartSpan && historyEndSpan) {
                        historyStartSpan.textContent = start + 1;
                        historyEndSpan.textContent = Math.min(end, historyItems.length);
                    }

                    currentPage = page;
                }

                historyPrevBtn.addEventListener('click', () => {
                    if (currentPage > 1) {
                        showHistoryPage(currentPage - 1);
                    }
                });

                historyNextBtn.addEventListener('click', () => {
                    if (currentPage < totalPages) {
                        showHistoryPage(currentPage + 1);
                    }
                });

                // Initialize first page
                showHistoryPage(1);
            }

            // Rating pagination
            const ratingItems = document.querySelectorAll('.rating-item');
            const prevBtn = document.getElementById('prevPage');
            const nextBtn = document.getElementById('nextPage');
            const startSpan = document.getElementById('startCount');
            const endSpan = document.getElementById('endCount');

            if (ratingItems.length > 0 && prevBtn && nextBtn) {
                const itemsPerPage = 5;
                let currentPage = 1;
                const totalPages = Math.ceil(ratingItems.length / itemsPerPage);

                function showPage(page) {
                    const start = (page - 1) * itemsPerPage;
                    const end = start + itemsPerPage;

                    ratingItems.forEach((item, index) => {
                        if (index >= start && index < end) {
                            item.classList.remove('hidden');
                        } else {
                            item.classList.add('hidden');
                        }
                    });

                    // Update button states
                    prevBtn.disabled = page === 1;
                    nextBtn.disabled = page === totalPages;

                    // Update counter
                    if (startSpan && endSpan) {
                        startSpan.textContent = start + 1;
                        endSpan.textContent = Math.min(end, ratingItems.length);
                    }

                    currentPage = page;
                }

                prevBtn.addEventListener('click', () => {
                    if (currentPage > 1) {
                        showPage(currentPage - 1);
                    }
                });

                nextBtn.addEventListener('click', () => {
                    if (currentPage < totalPages) {
                        showPage(currentPage + 1);
                    }
                });

                // Initialize first page
                showPage(1);
            }

            // Invite popup functionality
            const inviteBtn = document.getElementById('inviteButton');
            const invitePopup = document.getElementById('invitePopup');
            const closeInviteBtn = document.getElementById('closePopup');
            const cancelInviteBtn = document.getElementById('cancelPopup');

            // Expense popup functionality
            const expenseBtn = document.getElementById('addExpenseBtn');
            const expensePopup = document.getElementById('expensePopup');
            const closeExpenseBtn = document.getElementById('closeExpensePopup');
            const cancelExpenseBtn = document.getElementById('cancelExpensePopup');

            // Category popup functionality
            const categoryBtn = document.getElementById('manageCategoriesBtn');
            const categoryPopup = document.getElementById('categoryPopup');
            const closeCategoryBtn = document.getElementById('closeCategoryPopup');
            const cancelCategoryBtn = document.getElementById('cancelCategoryPopup');

            // Settle popup functionality
            const settleBtn = document.getElementById('settleDebtsBtn');
            const settlePopup = document.getElementById('settlePopup');
            const closeSettleBtn = document.getElementById('closeSettlePopup');
            const cancelSettleBtn = document.getElementById('cancelSettlePopup');

            // Rating popup functionality
            const ratingPopup = document.getElementById('ratingPopup');
            const closeRatingBtn = document.getElementById('closeRatingPopup');
            const cancelRatingBtn = document.getElementById('cancelRatingPopup');

            // Confirm Quit popup functionality
            const openQuitBtn = document.getElementById('openQuitConfirmBtn');
            const quitPopup = document.getElementById('confirmQuitPopup');
            const cancelQuitBtn = document.getElementById('cancelQuitPopup');

            // Confirm Kick popup functionality
            const kickPopup = document.getElementById('confirmKickPopup');
            const cancelKickBtn = document.getElementById('cancelKickPopup');

            // Open expense popup
            if (expenseBtn) {
                expenseBtn.addEventListener('click', function() {
                    expensePopup.classList.add('active');
                    document.body.style.overflow = 'hidden';
                });
            }

            // Open invite popup
            if (inviteBtn) {
                inviteBtn.addEventListener('click', function() {
                    invitePopup.classList.add('active');
                    document.body.style.overflow = 'hidden';
                });
            }

            // Open category popup
            if (categoryBtn) {
                categoryBtn.addEventListener('click', function() {
                    categoryPopup.classList.add('active');
                    document.body.style.overflow = 'hidden';
                });
            }

            // Open settle popup
            if (settleBtn) {
                settleBtn.addEventListener('click', function() {
                    settlePopup.classList.add('active');
                    document.body.style.overflow = 'hidden';
                });
            }

            // Open confirm quit popup
            if (openQuitBtn) {
                openQuitBtn.addEventListener('click', function() {
                    quitPopup.classList.add('active');
                    document.body.style.overflow = 'hidden';
                });
            }

            // Close functions
            function closeInvitePopup() {
                if (invitePopup) {
                    invitePopup.classList.remove('active');
                    document.body.style.overflow = '';
                }
            }

            function closeExpensePopup() {
                if (expensePopup) {
                    expensePopup.classList.remove('active');
                    document.body.style.overflow = '';
                }
            }

            function closeCategoryPopup() {
                if (categoryPopup) {
                    categoryPopup.classList.remove('active');
                    document.body.style.overflow = '';
                }
            }

            function closeSettlePopup() {
                if (settlePopup) {
                    settlePopup.classList.remove('active');
                    document.body.style.overflow = '';
                }
            }

            function closeRatingPopup() {
                if (ratingPopup) {
                    ratingPopup.classList.remove('active');
                    document.body.style.overflow = '';
                }
            }

            function closeQuitPopup() {
                if (quitPopup) {
                    quitPopup.classList.remove('active');
                    document.body.style.overflow = '';
                }
            }

            function closeKickPopup() {
                if (kickPopup) {
                    kickPopup.classList.remove('active');
                    document.body.style.overflow = '';
                }
            }

            // Attach close events for invite popup
            if (closeInviteBtn) closeInviteBtn.addEventListener('click', closeInvitePopup);
            if (cancelInviteBtn) cancelInviteBtn.addEventListener('click', closeInvitePopup);

            // Attach close events for expense popup
            if (closeExpenseBtn) closeExpenseBtn.addEventListener('click', closeExpensePopup);
            if (cancelExpenseBtn) cancelExpenseBtn.addEventListener('click', closeExpensePopup);

            // Attach close events for category popup
            if (closeCategoryBtn) closeCategoryBtn.addEventListener('click', closeCategoryPopup);
            if (cancelCategoryBtn) cancelCategoryBtn.addEventListener('click', closeCategoryPopup);

            // Attach close events for settle popup
            if (closeSettleBtn) closeSettleBtn.addEventListener('click', closeSettlePopup);
            if (cancelSettleBtn) cancelSettleBtn.addEventListener('click', closeSettlePopup);

            // Attach close events for rating popup
            if (closeRatingBtn) closeRatingBtn.addEventListener('click', closeRatingPopup);
            if (cancelRatingBtn) cancelRatingBtn.addEventListener('click', closeRatingPopup);

            // Attach close events for quit popup
            if (cancelQuitBtn) cancelQuitBtn.addEventListener('click', closeQuitPopup);

            // Attach close events for kick popup
            if (cancelKickBtn) cancelKickBtn.addEventListener('click', closeKickPopup);

            // Close when clicking outside
            if (invitePopup) {
                invitePopup.addEventListener('click', function(e) {
                    if (e.target === invitePopup) {
                        closeInvitePopup();
                    }
                });
            }

            if (expensePopup) {
                expensePopup.addEventListener('click', function(e) {
                    if (e.target === expensePopup) {
                        closeExpensePopup();
                    }
                });
            }

            if (categoryPopup) {
                categoryPopup.addEventListener('click', function(e) {
                    if (e.target === categoryPopup) {
                        closeCategoryPopup();
                    }
                });
            }

            if (settlePopup) {
                settlePopup.addEventListener('click', function(e) {
                    if (e.target === settlePopup) {
                        closeSettlePopup();
                    }
                });
            }

            if (ratingPopup) {
                ratingPopup.addEventListener('click', function(e) {
                    if (e.target === ratingPopup) {
                        closeRatingPopup();
                    }
                });
            }

            if (quitPopup) {
                quitPopup.addEventListener('click', function(e) {
                    if (e.target === quitPopup) {
                        closeQuitPopup();
                    }
                });
            }

            if (kickPopup) {
                kickPopup.addEventListener('click', function(e) {
                    if (e.target === kickPopup) {
                        closeKickPopup();
                    }
                });
            }

            // ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeInvitePopup();
                    closeExpensePopup();
                    closeCategoryPopup();
                    closeSettlePopup();
                    closeRatingPopup();
                    closeQuitPopup();
                    closeKickPopup();
                }
            });

            // Color selector
            window.selectColor = function(element) {
                document.querySelectorAll('.color-option').forEach(opt => opt.classList.remove('selected'));
                element.classList.add('selected');
                document.getElementById('selectedColor').value = element.dataset.color;
            };

            // Icon selector
            window.selectIcon = function(element) {
                document.querySelectorAll('.icon-option').forEach(opt => opt.classList.remove('selected'));
                element.classList.add('selected');
                document.getElementById('selectedIcon').value = element.dataset.icon;
            };
        });

        // Rating popup function
        function openRatingPopup(userId, userName) {
            const ratingPopup = document.getElementById('ratingPopup');
            const ratingUserId = document.getElementById('ratingUserId');
            const ratingUserName = document.getElementById('ratingUserName');

            ratingUserId.value = userId;
            ratingUserName.textContent = userName;
            ratingPopup.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        // Kick popup function
        function openKickPopup(userId, userName) {
            const kickPopup = document.getElementById('confirmKickPopup');
            const kickUserId = document.getElementById('kickUserId');
            const kickUserName = document.getElementById('kickUserName');

            kickUserId.value = userId;
            kickUserName.textContent = userName;
            kickPopup.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    </script>
@endpush
