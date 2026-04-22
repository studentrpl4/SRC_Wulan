<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerProfileController extends Controller
{
    // ========================
    // SHOW SETUP PROFILE PAGE
    // ========================
    public function showSetupProfile()
    {
        // jika profil sudah lengkap, langsung ke dashboard
        if (Auth::guard('customer')->user()->profile_completed) {
            return redirect()->route('customer.dashboard');
        }

        return view('customer.setup-profile');
    }

    public function showdatailProfile()
    {
        // jika profil sudah lengkap, langsung ke dashboard
        $customer = Auth::guard('customer')->user();

        return view('customer.detailprofile',compact('customer'));
    }

    // ========================
    // STORE PROFILE DATA
    // ========================
    public function storeSetupProfile(Request $request)
    {
        $request->validate([
            'name'   => ['required', 'string', 'max:255'],
            'phone'  => ['required', 'string', 'max:20'],
            'gender' => ['required', 'in:laki-laki,perempuan'],
            'birth_date' => ['required', 'date'],
        ]);

        $customer = Auth::guard('customer')->user();

        // update data profil
        $customer->update([
            'name'   => $request->name,
            'phone'  => $request->phone,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
            'profile_completed' => true,
        ]);

        return redirect()->route('front.index');
    }

    public function showProfile()
    {
        $customer = Auth::guard('customer')->user();

        return view('customer.profile', compact('customer'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'birth_date' => 'required|date',
        ]);

        $customer = Auth::guard('customer')->user();

        $customer->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
        ]);

        return redirect()->route('customer.profile')->with('success', 'Profil berhasil diperbarui!');
    }
}
