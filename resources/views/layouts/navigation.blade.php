<nav class="flex items-center justify-between px-6 py-4 bg-white shadow ">
    <!-- Logo -->
    <div class="text-2xl font-extrabold text-black tracking-wide">
        TENTON
    </div>

    <!-- Links -->
    <div class="space-x-4">
        @guest
            <a href="{{ route('register') }}" class="text-sm text-gray-700 hover:text-black">Register</a>
            <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1.5 rounded text-sm font-medium transition">
                Login
            </a>
        @else
            <form method="POST" action="/logout" class="inline">
                @csrf
                <button type="submit" class="text-sm text-red-600 hover:text-red-800">Log Out</button>
            </form>
        @endguest
    </div>
</nav>
