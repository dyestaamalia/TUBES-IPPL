<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Account</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white">

    <!-- Header -->
    <div class="w-full bg-[#33E4DB] py-10 flex justify-center">
        <h1 class="text-white text-4xl font-bold">New Account</h1>
    </div>

    <div class="max-w-md mx-auto mt-10 px-5">

        <!-- FORM REGISTER -->
        <form action="{{ route('register.post') }}" method="POST">
            @csrf

            {{-- Name --}}
            <label class="block mb-4">
                <span class="text-gray-800 font-semibold text-lg">Full Name</span>
                <input type="text" name="name"
                    class="w-full mt-2 p-4 bg-[#EAF7FF] rounded-xl text-gray-700 focus:outline-none"
                    placeholder="Full Name" value="{{ old('name') }}">
                @error('name')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </label>

            {{-- Email --}}
            <label class="block mb-4">
                <span class="text-gray-800 font-semibold text-lg">Email</span>
                <input type="email" name="email"
                    class="w-full mt-2 p-4 bg-[#EAF7FF] rounded-xl text-gray-700 focus:outline-none"
                    placeholder="email@gmail.com" value="{{ old('email') }}">
                @error('email')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </label>

            {{-- Password --}}
            <label class="block mb-4">
                <span class="text-gray-800 font-semibold text-lg">Password</span>
                <input type="password" name="password"
                    class="w-full p-4 bg-[#EAF7FF] rounded-xl focus:outline-none"
                    placeholder="*************">
                @error('password')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </label>

            {{-- Confirm Password --}}
            <label class="block mb-4">
                <span class="text-gray-800 font-semibold text-lg">Confirm Password</span>
                <input type="password" name="password_confirmation"
                    class="w-full p-4 bg-[#EAF7FF] rounded-xl focus:outline-none"
                    placeholder="*************">
                @error('password_confirmation')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </label>

            {{-- Phone --}}
            <label class="block mb-4">
                <span class="text-gray-800 font-semibold text-lg">Phone Number</span>
                <input type="text" name="phone"
                    class="w-full mt-2 p-4 bg-[#EAF7FF] rounded-xl text-gray-700 focus:outline-none"
                    placeholder="08123456789" value="{{ old('phone') }}">
                @error('phone')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </label>

            {{-- Date of Birth --}}
            <label class="block mb-4">
                <span class="text-gray-800 font-semibold text-lg">Date of Birth</span>
                <input type="date" name="dob"
                    class="w-full mt-2 p-4 bg-[#EAF7FF] rounded-xl text-gray-700 focus:outline-none"
                    value="{{ old('dob') }}">
                @error('dob')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </label>

            {{-- Terms --}}
            <p class="text-center text-gray-600 text-sm mt-1 mb-5">
                By continuing, you agree to<br>
                <a href="#" class="text-[#33E4DB] font-semibold">Terms of Use</a> and
                <a href="#" class="text-[#33E4DB] font-semibold">Privacy Policy</a>.
            </p>

            {{-- Submit Button --}}
            <button type="submit"
                class="w-full mt-2 py-3 rounded-full bg-[#33E4DB] text-white text-lg font-semibold">
                Sign Up
            </button>

        </form>

        {{-- Login Link --}}
        <p class="text-center text-gray-600 mt-6 mb-10">
            Already have an account?
            <a href="{{ route('login') }}" class="text-[#33E4DB] font-semibold">Log In</a>
        </p>

    </div>
</body>
</html>
