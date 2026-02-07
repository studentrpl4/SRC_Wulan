<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\StoreSetupProfileRequest;
use App\Http\Requests\Profile\UpdateProfileRequest;
use Illuminate\Http\Request;

class CustomerProfileController extends Controller
{
    /**
     * Show customer profile.
     */
    public function show(Request $request)
    {
        return response()->json([
            'customer' => $request->user()
        ]);
    }

    /**
     * Update customer profile.
     */
    public function update(UpdateProfileRequest $request)
    {
        $customer = $request->user();

        $customer->update($request->validated());

        return response()->json([
            'message' => 'Profil berhasil diperbarui!',
            'customer' => $customer
        ]);
    }

    /**
     * Store initial profile setup.
     */
    public function storeSetup(StoreSetupProfileRequest $request)
    {
        $customer = $request->user();

        $customer->update(array_merge(
            $request->validated(),
            ['profile_completed' => true]
        ));

        return response()->json([
            'message' => 'Profil berhasil dilengkapi!',
            'customer' => $customer
        ]);
    }
}
