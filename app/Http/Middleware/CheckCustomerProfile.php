<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckCustomerProfile
{
   public function handle(Request $request, Closure $next)
    {
        $customer = Auth::guard('customer')->user();

        // Cek apakah customer sudah punya profile lengkap
        if (!$customer->name || !$customer->phone || !$customer->gender || !$customer->birth_date) {
            // kalau dia mengakses /setup-profile, jangan redirect
            if (!$request->is('setup-profile')) {
                return redirect()->route('customer.setupProfile');
            }
        }

        return $next($request);
    }
}
