<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerAuthController extends Controller
{
    // ========================
    // SHOW LOGIN PAGE
    // ========================
    public function showLogin()
    {
        return view('customer.auth.login');
    }

    // ========================
    // LOGIN ACTION
    // ========================
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt login with guard 'customer'
        if (Auth::guard('customer')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            $request->session()->regenerate();

            // jika profil belum lengkap → arahkan ke setup profil
            if (!Auth::guard('customer')->user()->profile_completed) {
                return redirect()->route('customer.setupProfile');
            }

            // jika sudah lengkap → arahkan ke dashboard
            return redirect()->route('front.index');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    // ========================
    // SHOW REGISTER PAGE
    // ========================
    public function showRegister()
    {
        return view('customer.auth.register');
    }

    // ========================
    // REGISTER ACTION
    // ========================
    public function register(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'unique:customers,email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar, silakan gunakan email lain atau login ke akun Anda.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $customer = Customer::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('customer')->login($customer);

        return redirect()->route('customer.setupProfile');
    }

public function logout(Request $request)
{
    Auth::guard('customer')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('customer.auth.login');
}


}
