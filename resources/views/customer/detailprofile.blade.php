@extends('layout.app')

@section('title', 'SRC Wulan 🏪')

@section('content')
    <div class="min-h-screen bg-[#ffffff] flex justify-center">
        <div class="w-full max-w-sm px-4 pt-6 pb-10">
            <div class="flex items-center justify-between px-2 top-0 mb-6">
                <a href="{{ route('customer.profile') }}"
                    class="w-10 h-10 rounded-full bg-white flex items-center justify-center shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-arrow-left-icon lucide-arrow-left">
                        <path d="m12 19-7-7 7-7" />
                        <path d="M19 12H5" />
                    </svg>
                </a>
                <h1 class="text-lg font-semibold text-gray-900">
                    Detail Profile
                </h1>
                <div class="dummy-btn w-10"></div>
            </div>
            <div class="p-5 items-center">
                <div class="bg-white rounded-2xl p-4 shadow-md space-y-4">

                    <!-- Header -->
                    <h2 class="text-ms font-bold text-gray-900">
                        Detail Profil
                    </h2>

                    <!-- Item -->
                    <div class="flex items-center justify-between border-b pb-3">
                        <p class="text-sm text-gray-500">Nama Lengkap</p>
                        <p class="text-sm font-medium text-gray-900">
                            {{ $customer->name }}
                        </p>
                    </div>

                    {{-- <div class="flex items-center justify-between border-b pb-3">
                        <p class="text-sm text-gray-500">Username</p>
                        <p class="text-sm font-medium text-gray-900">
                            {{ $customer-> }}
                        </p>
                    </div> --}}

                    <div class="flex items-center justify-between border-b pb-3">
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="text-sm font-medium text-gray-900">
                            {{ $customer->email }}
                        </p>
                    </div>

                    <div class="flex items-center justify-between border-b pb-3">
                        <p class="text-sm text-gray-500">No. Telepon</p>
                        <p class="text-sm font-medium text-gray-900">
                            {{ $customer->phone }}
                        </p>
                    </div>

                    <div class="flex items-center justify-between">
                        <p class="text-sm text-gray-500">Bergabung Sejak</p>
                        <p class="text-sm font-medium text-gray-900">
                            {{ date_format($customer->created_at, 'd F y') }}
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection