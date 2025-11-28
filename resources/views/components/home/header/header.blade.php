<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<header class="bg-dark-900 border-b border-slate-700 sticky top-0 z-10">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
        <div class="flex items-center">
            <div class="text-2xl font-bold bg-gradient-to-r from-blue-500 to-purple-600 bg-clip-text text-transparent">
                <a href="{{ route('home') }}">
                    E‑Learning Platform
                </a>
            </div>
            <x-home.header.navigation />
        </div>
        @auth
            @if (Auth::user()->isAdmin())
                <a href="{{ route('dashboard') }}" class="text-slate-300 hover:text-white transition">Dashboard</a>
            @endif
            @if (Auth::user()->isTeacher())
                <a href="{{ route('dashboard.teacher') }}" class="text-slate-300 hover:text-white transition">Dashboard</a>
            @endif
        @endauth
        <div class="flex items-center space-x-4">
            <!-- Cart Icon -->
            <a href="{{ route('carts.index') }}" class="relative text-slate-300 hover:text-white transition">
                <i class="fas fa-shopping-cart text-xl"></i>
                @auth
                    @if(auth()->user()?->cart?->items()->count() > 0)
                        <span
                            class="absolute -top-2 -right-2 bg-indigo-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                            {{ auth()->user()?->cart?->items()->count() }}
                        </span>
                    @endif
                @endauth
            </a>

            @auth
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button
                        class="px-4 py-2 bg-slate-700 hover:bg-slate-600 rounded-md text-white font-medium transition cursor-pointer">
                        Logout
                    </button>
                </form>
                <a href="{{ route('profiles.index')}}"
                    class="px-4 py-2 bg-slate-700 hover:bg-slate-600 rounded-md text-white font-medium transition cursor-pointer">
                    My Profile
                </a>
            @else
                <a href="{{ route('login') }}" class="px-4 py-2 text-slate-300 hover:text-white transition font-medium">
                    Sign In
                </a>
                <a href="{{ route('register') }}"
                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-md text-white font-medium transition">
                    Sign Up
                </a>
            @endauth
        </div>
    </div>
</header>