<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white">

    <!-- Header -->
    <div class="w-full bg-[#33E4DB] py-10 flex justify-center">
        <h1 class="text-white text-4xl font-bold">Log In</h1>
    </div>

    <div class="max-w-md mx-auto mt-10 px-5">

        <!-- FORM LOGIN -->
        <form action="{{ route('proseslogin') }}" method="POST">
            @csrf

            {{-- Email or Phone --}}
            <label class="block mb-3">
                <span class="text-gray-800 font-semibold text-lg">Email or Mobile Number</span>
                <input type="text" name="login"
                    class="w-full mt-2 p-4 bg-[#EAF7FF] rounded-xl text-gray-700 focus:outline-none"
                    placeholder="Email or Mobile Number" value="{{ old('login') }}">
            </label>

            {{-- Password --}}
            <label class="block mb-2">
                <span class="text-gray-800 font-semibold text-lg">Password</span>
                <input type="password" name="password"
                    class="w-full p-4 bg-[#EAF7FF] rounded-xl focus:outline-none"
                    placeholder="************">
            </label>

            {{-- Error Message --}}
            @if(session('error'))
                <p class="text-xs text-red-600 mt-1">{{ session('error') }}</p>
            @endif

            <div class="text-right mt-1">
                <a href="#" class="text-[#33E4DB] text-sm">Forget Password</a>
            </div>

            {{-- Login Button --}}
            <button type="submit"
                class="w-full mt-5 py-3 rounded-full bg-[#33E4DB] text-white text-lg font-semibold">
                Log In
            </button>
        </form>

        {{-- Sign Up --}}
        <p class="text-center text-gray-600 mt-6 mb-10">
            Don’t have an account?
            <a href="{{ route('register') }}" class="text-[#33E4DB] font-semibold">Sign Up</a>
        </p>

    </div>
</body>
</html>
