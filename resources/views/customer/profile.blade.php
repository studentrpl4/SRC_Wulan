@extends('layout.app')
@section('title', 'profile')
@section('content')
    <div class="min-h-screen bg-[#ffffff] flex justify-center">
        <div class="w-full max-w-sm px-4 pt-6 pb-28">

            <!-- Header -->
            <div class="text-center mb-6">
                <h1 class="text-lg font-bold text-gray-900">Profil</h1>
            </div>

            <!-- Avatar & User Info -->
            <div class="flex flex-col items-center mb-8">
                <img src="{{ asset('assets/images/icons/Avatar.webp') }}" alt="avatar"
                    class="w-24 h-24 rounded-full object-cover mb-3" />
                <p class="font-semibold text-gray-900">{{ $customer->name }}</p>
                <p class="text-sm text-gray-400">{{ $customer->email }}</p>
            </div>

            <!-- Menu List -->
            <div class="space-y-3">

                <!-- Item -->
                <a href="{{ route('customer.detail.profile') }}"
                    class="flex items-center justify-between bg-white rounded-xl px-4 py-3">
                    <div class="flex items-center gap-3">
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-user-round-icon lucide-user-round">
                                <circle cx="12" cy="8" r="5" />
                                <path d="M20 21a8 8 0 0 0-16 0" />
                            </svg></span>
                        <p class="text-sm font-medium text-gray-900">Detail Profil</p>
                    </div>
                    <span>›</span>
                </a>

                <!-- Notifikasi -->
                <div class="flex items-center justify-between bg-white rounded-xl px-4 py-3">
                    <div class="flex items-center gap-3">
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-bell-icon lucide-bell">
                                <path d="M10.268 21a2 2 0 0 0 3.464 0" />
                                <path
                                    d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326" />
                            </svg></span>
                        <p class="text-sm font-medium text-gray-900">Notifikasi</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-[#e40312] transition">
                        </div>
                        <span
                            class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition peer-checked:translate-x-5">
                        </span>
                    </label>
                </div>

                <!-- Item -->
                <a href="#" class="flex items-center justify-between bg-white rounded-xl px-4 py-3">
                    <div class="flex items-center gap-3">
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-heart-icon lucide-heart">
                                <path
                                    d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5" />
                            </svg></span>
                        <p class="text-sm font-medium text-gray-900">Produk Favorit</p>
                    </div>
                    <span>›</span>
                </a>

                <a href="#" class="flex items-center justify-between bg-white rounded-xl px-4 py-3">
                    <div class="flex items-center gap-3">
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-map-pin-icon lucide-map-pin">
                                <path
                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
                                <circle cx="12" cy="10" r="3" />
                            </svg></span>
                        <p class="text-sm font-medium text-gray-900">Alamat Pengiriman</p>
                    </div>
                    <span>›</span>
                </a>

                <a href="#" class="flex items-center justify-between bg-white rounded-xl px-4 py-3">
                    <div class="flex items-center gap-3">
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-message-circle-question-mark-icon lucide-message-circle-question-mark">
                                <path
                                    d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719" />
                                <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3" />
                                <path d="M12 17h.01" />
                            </svg></span>
                        <p class="text-sm font-medium text-gray-900">FAQ</p>
                    </div>
                    <span>›</span>
                </a>



                <form action="{{ route('customer.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="flex items-center justify-between bg-[#e40312] w-full rounded-xl px-4 py-3">
                        <div class="flex items-center gap-3">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-log-out-icon lucide-log-out">
                                    <path d="m16 17 5-5-5-5" />
                                    <path d="M21 12H9" />
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                </svg>
                            </span>
                            <p class="text-sm font-medium text-gray-900">Logout</p>
                        </div>

                    </button>

                </form>
            </div>

            <!-- Bottom Navbar -->
        </div>
    </div>

    @include('navbar.navbar')
@endsection