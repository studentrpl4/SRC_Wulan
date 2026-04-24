@extends('layout.app')

@section('title', 'SRC Wulan 🏪')

@section('content')
    <div class="min-h-screen bg-[#ffffff] px-4 pb-24">

        {{-- HEADER --}}
        <header class="pt-6 mb-4">
            <div class="flex items-center justify-between">
                <h1 class="font-semibold text-lg flex items-center gap-2">
                    <img src="{{ asset('assets/images/logo_src wulan.png') }}" alt="Logo SRC Wulan" class="w-6 h-6 object-cover">
                    SRC Wulan
                </h1>

                <div class="flex items-center gap-3">
                    @if(Auth::guard('customer')->check())
                        <a href="{{ route('cart.index') }}" class="p-2 bg-white rounded-full shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-shopping-cart-icon lucide-shopping-cart">
                                <circle cx="8" cy="21" r="1" />
                                <circle cx="19" cy="21" r="1" />
                                <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12" />
                            </svg>
                        </a>

                        <a href="#" class="p-2 bg-white rounded-full shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-bell-icon lucide-bell">
                                <path d="M10.268 21a2 2 0 0 0 3.464 0" />
                                <path
                                    d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326" />
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('customer.auth.login') }}"
                            class="p-2 px-5 rounded-full font-bold border bg-[#e40312] text-white border-[#e40312]">
                            login
                        </a>
                    @endif

                </div>
            </div>
        </header>

        {{-- Pencarian --}}
        <form action="{{route('front.search')}}" class="flex justify-between items-center mx-4">
            <div class="flex items-center mb-6 w-full max-w-md">
                <div class="flex-grow bg-white rounded-l-full px-4 py-3 shadow-sm flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5a6 6 0 100 12 6 6 0 000-12zM21 21l-4.35-4.35" />
                    </svg>
                    <input type="text" name="keyword" placeholder="Cari produk favoritmu..."
                        class="w-full bg-transparent outline-none text-gray-700">
                </div>

                <button class="ml-0 bg-[#e40312] text-white px-5 py-3 rounded-r-full font-medium">
                    Cari
                </button>
            </div>
        </form>
        {{-- KATEGORI --}}

        <div class="flex items-center justify-between mb-3">
            <h2 class="font-semibold text-gray-800">Kategori Produk</h2>
            <div class="bg-white rounded-full p-1 px-3">
                <a class="text-[#e40312] font-medium text-sm" href="{{ route('category') }}">Lihat Semua</a>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-3 mb-6">
            {{-- Item kategori --}}
            @if (!empty($categories))
                @foreach ($categories as $item)
                    <a href="{{route('front.category', $item->slug)}}">
                        <div class="bg-white p-4 rounded-xl shadow-sm flex items-center gap-3">
                            {{-- <div class=""> --}}
                                @if ($item->icon && file_exists(public_path('storage/' . $item->icon)))
                                    <img src="{{ asset('storage/' . $item->icon) }}"
                                        class="w-6 h-6 object-cover object-left text-primary-green" alt="thumbnail">
                                @else
                                    <svg class="w-6 h-6 text-primary-green" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h16" />
                                    </svg>
                                @endif

                                {{--
                            </div> --}}
                            <span class="text-sm font-medium text-gray-700">{{ $item->name }}</span>
                        </div>
                    </a>
                @endforeach
            @else
                <p>Belum Ada Data Terbaru...</p>
            @endif

        </div>

        {{-- PRODUK TERLARIS --}}
        <h2 class="font-semibold text-gray-800 mb-3">Produk Terlaris</h2>

        <div class="grid grid-cols-2 gap-4">
            {{-- CARD PRODUK --}}
            @foreach ($newProducts as $item)
                <a href="{{route('front.details', $item->slug)}}">
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{$item->id}}">
                        <input type="hidden" name="quantity" id="quantity" value="1">
                        <div class="bg-white p-4 rounded-xl shadow-sm">
                            <img src="{{ asset('storage/' . $item->thumbnail) }}" class="w-full rounded-lg mb-3" alt="">
                            <h3 class="text-sm text-gray-700">{{ $item->name }} <br> {{ $item->about }} </h3>
                            <p class="text-[#e40312] font-semibold text-sm mt-1">Rp.
                                {{ number_format($item->price, 0, '.', '.') }}
                            </p>
                            <button type="submit"
                                class="mt-3 w-full bg-[#e40312] text-white py-2 rounded-full text-sm font-medium">
                                + Keranjang
                            </button>
                        </div>
                    </form>
                </a>
            @endforeach
        </div>

    </div>

    {{-- BOTTOM NAV --}}
    @include('navbar.navbar')

@endsection