<nav class="relative z-30 py-6 px-6 md:px-10 flex justify-between items-center max-w-[1700px]  mx-auto">
    
    <a href="/" class="text-3xl font-black tracking-tight 
        bg-gradient-to-r from-indigo-600 via-blue-600 to-purple-600
        bg-clip-text text-transparent flex items-center gap-2">

        <i class="fas fa-piggy-bank text-indigo-500"></i>
        EasyColoc
    </a>

    <div class="flex gap-4 items-center">

        @guest
            <a href="{{ route('login') }}"
               class="px-5 py-2.5 text-sm font-semibold text-indigo-700
               bg-white/70 rounded-full border border-indigo-200">
                Login
            </a>

            <a href="{{ route('signup') }}"
               class="px-5 py-2.5 text-sm font-semibold text-white
               bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full">
                Sign Up
            </a>
        @endguest

        @auth
            <a href="{{ route('logout') }}"
               class="px-5 py-2.5 text-sm font-semibold text-white
               bg-red-600 rounded-full">
                Logout
            </a>
        @endauth

    </div>
</nav>