<header class="relative z-30 bg-white/80 backdrop-blur-md border-b border-gray-200 sticky top-0">
    <nav class="py-4 px-6 md:px-10 flex justify-between items-center max-w-[1700px] mx-auto">

        {{-- Logo with home link --}}
        <a href="{{ url('/') }}"
            class="text-3xl font-black tracking-tight 
            bg-gradient-to-r from-indigo-600 via-blue-600 to-purple-600
            bg-clip-text text-transparent flex items-center gap-2 hover:scale-105 transition-transform duration-200">
            <i class="fas fa-piggy-bank text-indigo-500"></i>
            EasyColoc
        </a>

        {{-- Navigation Links --}}
        <div class="flex items-center gap-2 md:gap-4">

            {{-- Common Links for Authenticated Users --}}
            @auth
                {{-- Home/Dashboard --}}
                <a href="/"
                    class="px-3 py-2 text-sm font-semibold text-gray-700 hover:text-indigo-600 transition flex items-center gap-1 rounded-lg hover:bg-indigo-50">
                    <i class="fas fa-home"></i>
                    <span class="hidden md:inline">Dashboard</span>
                </a>

                {{-- Profile --}}
                <a href="profile"
                    class="px-3 py-2 text-sm font-semibold text-gray-700 hover:text-indigo-600 transition flex items-center gap-1 rounded-lg hover:bg-indigo-50">
                    <i class="fas fa-user"></i>
                    <span class="hidden md:inline">Profile</span>
                </a>

                {{-- Admin Panel --}}
                @if (Auth::user()->is_admin)
                    <a href="/manage"
                        class="px-3 py-2 text-sm font-semibold text-amber-600 hover:text-amber-700 transition flex items-center gap-1 rounded-lg hover:bg-amber-50">
                        <i class="fas fa-crown"></i>
                        <span class="hidden md:inline">Admin</span>
                    </a>
                @endif

                {{-- Developer Profile Button --}}
                <a href="/hyk"
                    class="px-3 py-2 text-sm font-semibold text-purple-600 hover:text-purple-700 transition flex items-center gap-1 rounded-lg hover:bg-purple-50 border border-purple-200">
                    <i class="fas fa-code"></i>
                    <span class="hidden md:inline">Developer</span>
                </a>

                {{-- Logout --}}
                <a href="/logout"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="px-4 py-2 text-sm font-semibold text-white bg-gradient-to-r from-red-500 to-red-600 rounded-full hover:from-red-600 hover:to-red-700 transition shadow-md hover:shadow-lg flex items-center gap-1">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="hidden md:inline">Logout</span>
                </a>

                {{-- Hidden Logout Form --}}
                <form id="logout-form" action="/logout" method="POST" class="hidden">
                    @csrf
                </form>

            @endauth

            {{-- Guest Links --}}
            @guest
                <a href="/"
                    class="px-3 py-2 text-sm font-semibold text-gray-700 hover:text-indigo-600 transition flex items-center gap-1 rounded-lg hover:bg-indigo-50">
                    <i class="fas fa-home"></i>
                    <span class="hidden md:inline">Home</span>
                </a>

                <a href="/"
                    class="px-3 py-2 text-sm font-semibold text-gray-700 hover:text-indigo-600 transition flex items-center gap-1 rounded-lg hover:bg-indigo-50">
                    <i class="fas fa-star"></i>
                    <span class="hidden md:inline">Features</span>
                </a>

                {{-- Developer Profile Button (also for guests) --}}
                <a href="/hyk"
                    class="px-3 py-2 text-sm font-semibold text-purple-600 hover:text-purple-700 transition flex items-center gap-1 rounded-lg hover:bg-purple-50 border border-purple-200">
                    <i class="fas fa-code"></i>
                    <span class="hidden md:inline">Developer</span>
                </a>

                <a href="/login"
                    class="px-4 py-2 text-sm font-semibold text-indigo-700 bg-indigo-50 rounded-full border border-indigo-200 hover:bg-indigo-100 transition">
                    Login
                </a>

                <a href="/signup"
                    class="px-4 py-2 text-sm font-semibold text-white bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full hover:from-indigo-600 hover:to-purple-600 transition shadow-md hover:shadow-lg">
                    Sign Up
                </a>
            @endguest

        </div>
    </nav>
</header>

{{-- Mobile Bottom Navigation (for smaller screens) --}}
<div class="fixed bottom-0 left-0 right-0 bg-white/90 backdrop-blur-md border-t border-gray-200 py-2 px-4 md:hidden z-40">
    <div class="flex justify-around items-center">
        @auth
            <a href="/" class="flex flex-col items-center text-xs text-gray-600 hover:text-indigo-600">
                <i class="fas fa-home text-lg"></i>
                <span>Home</span>
            </a>
            <a href="/profile" class="flex flex-col items-center text-xs text-gray-600 hover:text-indigo-600">
                <i class="fas fa-user text-lg"></i>
                <span>Profile</span>
            </a>
            <a href="/hyk" class="flex flex-col items-center text-xs text-purple-600 hover:text-purple-700">
                <i class="fas fa-code text-lg"></i>
                <span>Dev</span>
            </a>
        @endauth
        @guest
            <a href="/" class="flex flex-col items-center text-xs text-gray-600 hover:text-indigo-600">
                <i class="fas fa-home text-lg"></i>
                <span>Home</span>
            </a>
            <a href="/" class="flex flex-col items-center text-xs text-gray-600 hover:text-indigo-600">
                <i class="fas fa-star text-lg"></i>
                <span>Features</span>
            </a>
            <a href="/hyk" class="flex flex-col items-center text-xs text-purple-600 hover:text-purple-700">
                <i class="fas fa-code text-lg"></i>
                <span>Dev</span>
            </a>
            <a href="/login" class="flex flex-col items-center text-xs text-indigo-600">
                <i class="fas fa-sign-in-alt text-lg"></i>
                <span>Login</span>
            </a>
        @endguest
    </div>
</div>