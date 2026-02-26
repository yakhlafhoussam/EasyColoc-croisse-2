@extends('layouts.main')

@push('styles')
    <style>
        body {
            background: #f6f8fc;
            font-family: 'Inter', sans-serif;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.6);
        }

        .hover-card {
            transition: .25s;
        }

        .hover-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, .08);
        }
    </style>
@endpush


@section('content')
    <div class="max-w-7xl mx-auto px-6 py-8">

        {{-- ================= HERO ================= --}}
        <section class="relative h-72 rounded-3xl overflow-hidden shadow-xl mb-10">

            <img src="https://www.sarouty.ma/wp-content/uploads/2024/01/imag-2.jpg" class="w-full h-full object-cover">

            <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-black/20"></div>

            <div class="absolute bottom-8 left-8 flex items-center gap-6">

                {{-- Avatar --}}
                @if ($user->profile_image)
                    <img src="{{ $user->profile_image }}"
                        class="w-28 h-28 rounded-full border-4 {{ $user->is_admin == 1 ? 'border-yellow-500' : 'border-white' }} shadow-xl"
                        onerror="this.src='{{ asset('image/shopping.png') }}'">
                @else
                    <div
                        class="w-28 h-28 rounded-full bg-indigo-500 flex items-center justify-center text-white text-3xl font-bold">
                        {{ strtoupper(substr($user->firstname, 0, 1) . substr($user->lastname, 0, 1)) }}
                    </div>
                @endif

                {{-- Identity --}}
                <div class="text-white">
                    <h1 class="text-4xl font-bold">
                        {{ $user->firstname }} {{ $user->lastname }}
                    </h1>

                    <p class="opacity-90 flex items-center gap-2">
                        <i class="fas fa-location-dot"></i>
                        {{ $user->city }}, {{ $user->country }}
                    </p>

                    <div class="flex gap-2 mt-3">
                        <span class="bg-green-500 px-3 py-1 rounded-full text-xs flex items-center gap-1">
                            <i class="fas fa-circle-check"></i>
                            Active Member
                        </span>

                        <span class="bg-white/20 px-3 py-1 rounded-full text-xs flex items-center gap-1">
                            <i class="fas fa-star"></i>
                            {{ $averageRating }} Reputation
                        </span>
                    </div>
                </div>

            </div>
        </section>


        <div class="grid lg:grid-cols-6 gap-8">

            {{-- ================= SIDEBAR ================= --}}
            <div class="lg:col-span-2">

                <div class="glass-card rounded-3xl p-6">

                    <h3 class="font-bold mb-5 text-lg flex items-center gap-2">
                        <i class="fas fa-user-circle"></i>
                        Profile Information
                    </h3>

                    <div class="space-y-3 text-sm">

                        {{-- Full Name --}}
                        <div class="flex justify-between">
                            <span><i class="fas fa-id-card mr-2"></i>Full Name</span>
                            <span class="font-semibold">
                                {{ $user->firstname }} {{ $user->lastname }}
                            </span>
                        </div>

                        {{-- Email --}}
                        <div class="flex justify-between">
                            <span><i class="fas fa-envelope mr-2"></i>Email</span>
                            <span>{{ $user->email }}</span>
                        </div>

                        {{-- Phone --}}
                        @if ($user->phone)
                            <div class="flex justify-between">
                                <span><i class="fas fa-phone mr-2"></i>Phone</span>
                                <span>{{ $user->phone }}</span>
                            </div>
                        @endif

                        {{-- Gender --}}
                        @if ($user->gender)
                            <div class="flex justify-between">
                                <span><i class="fas fa-venus-mars mr-2"></i>Gender</span>
                                <span>{{ ucfirst($user->gender) }}</span>
                            </div>
                        @endif

                        {{-- Birth Date --}}
                        @if ($user->birth_date)
                            <div class="flex justify-between">
                                <span><i class="fas fa-cake-candles mr-2"></i>Birth Date</span>
                                <span>
                                    {{ \Carbon\Carbon::parse($user->birth_date)->format('d M Y') }}
                                </span>
                            </div>
                        @endif

                        {{-- Country --}}
                        @if ($user->country)
                            <div class="flex justify-between">
                                <span><i class="fas fa-globe mr-2"></i>Country</span>
                                <span>{{ $user->country }}</span>
                            </div>
                        @endif

                        {{-- City --}}
                        @if ($user->city)
                            <div class="flex justify-between">
                                <span><i class="fas fa-city mr-2"></i>City</span>
                                <span>{{ $user->city }}</span>
                            </div>
                        @endif

                        {{-- CIN --}}
                        @if ($user->cin)
                            <div class="flex justify-between">
                                <span><i class="fas fa-address-card mr-2"></i>CIN</span>
                                <span>{{ $user->cin }}</span>
                            </div>
                        @endif

                        {{-- Occupation Type --}}
                        @if ($user->type_occupation)
                            <div class="flex justify-between">
                                <span><i class="fas fa-user-tie mr-2"></i>Status</span>
                                <span>{{ ucfirst($user->type_occupation) }}</span>
                            </div>
                        @endif

                        {{-- Occupation --}}
                        @if ($user->occupation)
                            <div class="flex justify-between">
                                <span><i class="fas fa-briefcase mr-2"></i>Occupation</span>
                                <span>{{ $user->occupation }}</span>
                            </div>
                        @endif

                        {{-- Role --}}
                        <div class="flex justify-between">
                            <span><i class="fas fa-shield-alt mr-2"></i>Role</span>

                            @if ($user->is_admin)
                                <span
                                    class="bg-yellow-100 text-yellow-500 px-4 py-1 rounded-full text-sm flex items-center gap-1">
                                    <i class="fas fa-crown"></i>
                                    Admin
                                </span>
                            @else
                                <span
                                    class="bg-indigo-100 text-indigo-700 px-4 py-1 rounded-full text-sm flex items-center gap-1">
                                    <i class="fas fa-user"></i>
                                    User
                                </span>
                            @endif
                        </div>

                        {{-- Account Status --}}
                        <div class="flex justify-between">
                            <span><i class="fas fa-user-lock mr-2"></i>Account Status</span>

                            @if ($user->is_banned)
                                <span class="text-red-500 font-semibold">
                                    Banned
                                </span>
                            @else
                                <span class="text-green-600 font-semibold">
                                    Active
                                </span>
                            @endif
                        </div>

                        {{-- Joined At --}}
                        <div class="flex justify-between">
                            <span><i class="fas fa-calendar-plus mr-2"></i>Joined</span>
                            <span>
                                {{ $user->created_at->format('d M Y') }}
                            </span>
                        </div>

                    </div>

                </div>

            </div>


            {{-- ================= MAIN ================= --}}
            <div class="lg:col-span-4 space-y-6">

                {{-- CURRENT COLOCATION --}}
                <div class="glass-card rounded-3xl p-6 hover-card">

                    <h2 class="text-xl font-bold mb-5 flex items-center gap-2">
                        <i class="fas fa-house"></i>
                        Current Colocation
                    </h2>

                    @if ($membership)
                        <div class="flex justify-between items-center">

                            <div>
                                <h4 class="font-semibold text-lg">
                                    {{ $membership->colocation->name }}
                                </h4>

                                <p class="text-gray-500 text-sm flex items-center gap-2">
                                    <i class="fas fa-calendar"></i>
                                    Joined
                                    {{ \Carbon\Carbon::parse($membership->join_at)->format('F Y') }}
                                </p>
                            </div>

                            <span
                                class="bg-indigo-100 text-indigo-700 px-4 py-1 rounded-full text-sm flex items-center gap-1">
                                <i class="fas fa-user-tie"></i>

                                {{ $membership->role ? 'Owner' : 'Member' }}

                            </span>

                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">

                            <i class="fas fa-house-circle-xmark text-4xl mb-3"></i>

                            <p class="font-semibold">
                                You don't belong to any colocation yet
                            </p>

                        </div>
                    @endif

                </div>


                {{-- ROOMMATES --}}
                <div class="glass-card rounded-3xl p-6">

                    <h3 class="font-bold mb-5 flex items-center gap-2">
                        <i class="fas fa-users"></i>
                        Roommates
                    </h3>

                    @if ($membership && $roommates->count())
                        <div class="flex gap-6 flex-wrap">

                            @foreach ($roommates as $mate)
                                <div class="text-center">

                                    <img src="{{ $mate->profile_image }}" class="w-16 h-16 rounded-full mx-auto"
                                        onerror="this.src='{{ asset('image/shopping.png') }}'">

                                    <p class="text-sm mt-2 font-medium">
                                        {{ $mate->firstname }}
                                    </p>

                                </div>
                            @endforeach

                        </div>
                    @else
                        <div class="text-center text-gray-500 py-6">

                            <i class="fas fa-user-slash text-3xl mb-2"></i>
                            <p>No roommates available</p>

                        </div>
                    @endif

                </div>


                {{-- RATINGS --}}
                <div class="glass-card rounded-3xl p-6">

                    <h3 class="font-bold mb-5 flex items-center gap-2">
                        <i class="fas fa-star"></i>
                        Ratings Received
                    </h3>

                    @if ($ratings->count())
                        <div class="space-y-4">

                            @foreach ($ratings as $rating)
                                <div class="border-b pb-4">

                                    <div class="flex justify-between items-start">

                                        {{-- Reviewer --}}
                                        <div class="flex items-center gap-3">

                                            <img src="{{ $rating->fromUser->profile_image }}"
                                                class="w-10 h-10 rounded-full"
                                                onerror="this.src='{{ asset('image/shopping.png') }}'">

                                            <div>
                                                <p class="font-semibold">
                                                    {{ $rating->fromUser->firstname }}
                                                    {{ $rating->fromUser->lastname }}
                                                </p>

                                                <p class="text-xs text-gray-500 flex items-center gap-1">
                                                    <i class="fas fa-house"></i>
                                                    {{ $rating->colocation->name }}
                                                </p>
                                            </div>

                                        </div>

                                        {{-- Stars --}}
                                        <div class="text-amber-500 text-sm">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i
                                                    class="fas fa-star {{ $i <= $rating->stars ? '' : 'text-gray-300' }}"></i>
                                            @endfor
                                        </div>

                                    </div>

                                    {{-- Comment --}}
                                    @if ($rating->comment)
                                        <p class="text-sm text-gray-600 mt-3 ml-13">
                                            {{ $rating->comment }}
                                        </p>
                                    @endif

                                    {{-- Date --}}
                                    <p class="text-xs text-gray-400 mt-2">
                                        <i class="fas fa-clock"></i>
                                        {{ $rating->created_at->diffForHumans() }}
                                    </p>

                                </div>
                            @endforeach

                        </div>
                    @else
                        <div class="text-center text-gray-500 py-6">
                            <i class="fas fa-star-half-stroke text-3xl mb-2"></i>
                            <p>No ratings received yet</p>
                        </div>
                    @endif

                </div>


                {{-- HISTORY --}}
                <div class="glass-card rounded-3xl p-6">

                    <h3 class="font-bold mb-4 flex items-center gap-2">
                        <i class="fas fa-clock-rotate-left"></i>
                        Colocation History
                    </h3>

                    @if ($history->count())
                        <ul class="space-y-4 border-l pl-4 text-sm">

                            @foreach ($history as $item)
                                <li class="relative">

                                    <span class="font-semibold">
                                        {{ \Carbon\Carbon::parse($item->join_at)->format('Y') }}
                                    </span>

                                    —

                                    {{ $item->colocation->name }}

                                    @if (is_null($item->left_at))
                                        <span class="ml-2 text-green-600 font-medium">
                                            (Active)
                                        </span>
                                    @else
                                        <span class="ml-2 text-gray-500">
                                            ({{ \Carbon\Carbon::parse($item->left_at)->format('Y') }})
                                        </span>
                                    @endif

                                </li>
                            @endforeach

                        </ul>
                    @else
                        <div class="text-center text-gray-500 py-6">

                            <i class="fas fa-clock text-3xl mb-2"></i>
                            <p>No colocation history yet</p>

                        </div>
                    @endif

                </div>

            </div>

        </div>
    </div>
@endsection
