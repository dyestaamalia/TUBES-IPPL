<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Tampilkan form login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Tampilkan form register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses login dengan email atau phone
    public function prosesLogin(Request $request)
    {
        $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->login)
                    ->orWhere('phone', $request->login)
                    ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect()->route('dashboard');
        }

        return redirect()->route('login')->with('error', 'Email/Phone atau Password salah');
    }

    // Proses register
    public function prosesRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'phone'     => 'required|unique:users',
            'password'  => 'required|string|min:8|confirmed',
            'dob'       => 'required|date',
        ], [
            'password.confirmed' => 'Password dan Confirm Password tidak sama!',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            if ($errors->has('password') && strpos($errors->first('password'), 'Confirm Password') !== false) {
                $errors->add('password_confirmation', $errors->first('password'));
                $errors->forget('password'); // hapus error dari password
            }
            return redirect()->back()->withErrors($errors)->withInput();
        }

        // CREATE USER
        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'dob'       => $request->dob,
            'password'  => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat!');
    }
}
