<header class="relative z-30 bg-white shadow-sm">
    <nav class="py-6 px-6 md:px-10 flex justify-between items-center max-w-[1700px] mx-auto">

        {{-- Logo --}}
        <a href="{{ url('/') }}"
            class="text-3xl font-black tracking-tight 
            bg-gradient-to-r from-indigo-600 via-blue-600 to-purple-600
            bg-clip-text text-transparent flex items-center gap-2">
            <i class="fas fa-piggy-bank text-indigo-500"></i>
            EasyColoc
        </a>

        {{-- Navigation Links --}}
        <div class="flex items-center gap-6">

            {{-- Common Links --}}

            @auth
                <a href="{{ url('/') }}"
                    class="text-sm font-semibold text-gray-700 hover:text-indigo-600 transition flex items-center gap-1">
                    <i class="fas fa-home"></i> Home
                </a>
                <a href="#"
                    class="text-sm font-semibold text-gray-700 hover:text-indigo-600 transition flex items-center gap-1">
                    <i class="fas fa-user"></i> Profile
                </a>

                @if (Auth::user()->is_admin)
                    <a href="#"
                        class="text-sm font-semibold text-gray-700 hover:text-indigo-600 transition flex items-center gap-1">
                        <i class="fas fa-crown"></i> Admin Panel
                    </a>
                @endif

                <a href="#"
                    class="text-sm font-semibold text-gray-700 hover:text-indigo-600 transition flex items-center gap-1 relative">
                    <i class="fas fa-bell"></i> Notifications
                    {{-- @php
                        $notifCount = Auth::user()->unreadNotifications->count();
                    @endphp
                    @if ($notifCount > 0)
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                            {{ $notifCount }}
                        </span>
                    @endif --}}
                </a>

                <a href="{{ route('logout') }}"
                    class="px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-full hover:bg-red-700 transition">
                    Logout
                </a>
            @endauth

            {{-- Guest Links --}}
            @guest
                <a href="{{ route('login') }}"
                    class="px-4 py-2 text-sm font-semibold text-indigo-700 bg-white/70 rounded-full border border-indigo-200 hover:bg-white/90 transition">
                    Login
                </a>

                <a href="{{ route('signup') }}"
                    class="px-4 py-2 text-sm font-semibold text-white bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full hover:from-indigo-600 hover:to-purple-600 transition">
                    Sign Up
                </a>
            @endguest

        </div>
    </nav>
</header>
