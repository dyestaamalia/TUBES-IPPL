<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'IngonCare')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-[#F8FAFC]">

<div class="flex">

    <!-- SIDEBAR -->
    <aside class="w-64 h-screen bg-white border-r fixed px-6 py-6 z-50">
        <h1 class="text-2xl font-bold text-[#13CAD6] mb-10">IngonCare</h1>

        <nav class="space-y-5">

            <a href="{{ route('home') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-xl transition
               {{ request()->is('home') 
                 ? 'bg-[#E5FAF7] text-[#13CAD6] font-semibold border-l-4 border-[#13CAD6]' 
                 : 'text-gray-700 hover:bg-gray-100 hover:text-[#1A9C8C]' }}">
                🏠 Dashboard
            </a>

            <a href="{{ route('hewan-saya') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-xl transition
                {{ request()->is('hewan-saya') 
                ? 'bg-[#E5FAF7] text-[#13CAD6] font-semibold border-l-4 border-[#13CAD6]' 
                : 'text-gray-700 hover:bg-gray-100 hover:text-[#1A9C8C]' }}">
                🐾 Hewan Saya
            </a>

            <a href="/riwayat"
               class="flex items-center gap-3 px-3 py-2 rounded-xl transition
               {{ request()->is('riwayat') 
                 ? 'bg-[#E5FAF7] text-[#13CAD6] font-semibold border-l-4 border-[#13CAD6]' 
                 : 'text-gray-700 hover:bg-gray-100 hover:text-[#1A9C8C]' }}">
                📈 Riwayat Kesehatan
            </a>

            <a href="/pengingat"
               class="flex items-center gap-3 px-3 py-2 rounded-xl transition
               {{ request()->is('pengingat') 
                 ? 'bg-[#E5FAF7] text-[#13CAD6] font-semibold border-l-4 border-[#13CAD6]' 
                 : 'text-gray-700 hover:bg-gray-100 hover:text-[#1A9C8C]' }}">
                ⏰ Pengingat
            </a>

            {{-- UPDATED LINK PROFIL --}}
            <a href="{{ route('profile.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-xl transition
               {{ request()->is('profil*') 
                 ? 'bg-[#E5FAF7] text-[#13CAD6] font-semibold border-l-4 border-[#13CAD6]'
                 : 'text-gray-700 hover:bg-gray-100 hover:text-[#1A9C8C]' }}">
                👤 Profil Saya
            </a>

        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="ml-64 w-full">

        <!-- HEADER -->
        <header class="flex items-center justify-between px-10 py-6 bg-white shadow-sm relative">
            <div class="w-1/3">
                <input 
                    type="text" 
                    placeholder="Search"
                    class="w-full px-4 py-2 bg-[#F1F5F9] rounded-full border focus:ring-[#1A9C8C]"
                >
            </div>

            <div class="flex items-center gap-6">
                <span class="text-xl cursor-pointer">🔔</span>
                <span class="text-xl cursor-pointer">⚙️</span>

                <div class="flex items-center gap-3 relative">

                    <p>Hi, Welcome 
                        <span class="font-semibold">
                            {{ Auth::user()->name ?? 'Guest' }}
                        </span>
                    </p>

                    <img 
                        id="profileButton"
                        src="https://i.pravatar.cc/40" 
                        class="w-10 h-10 rounded-full cursor-pointer"
                        onclick="toggleDropdown()"
                    >

                    <!-- UPDATED DROPDOWN -->
                    <div 
                        id="profileDropdown"
                        class="hidden absolute right-0 top-14 w-40 bg-white shadow-lg rounded-xl p-2"
                    >
                        <a href="{{ route('profile.index') }}" 
                           class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                           Profil Saya
                        </a>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button 
                                class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-100 rounded-lg">
                                Logout
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </header>

        <!-- CONTENT -->
        <main class="p-10">
            @yield('content')
        </main>

    </div>
</div>

<!-- SCRIPT DROPDOWN -->
<script>
    function toggleDropdown() {
        const menu = document.getElementById('profileDropdown');
        menu.classList.toggle('hidden');
    }

    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('profileDropdown');
        const profileBtn = document.getElementById('profileButton');

        if (!profileBtn.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });
</script>

@stack('scripts')

</body>
</html>
