@extends('layout.app')

@section('title', 'SRC Wulan 🏪')

@section('content')
    <div class="min-h-screen bg-[#ffffff] px-4 py-4 pb-24">

        {{-- Pencarian --}}
        <form action="{{route('front.search')}}" class="flex justify-between items-center mx-auto">
            <div class="flex w-full items-center mb-4">
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

        <nav class="flex items-center justify-between pt-3 mb-2 border-b border-gray-400">
            <div class="flex space-x-6">
                <button id="btn-all" class="font-semibold text-gray-900 border-b-2 border-[#e40312] pb-1">
                    Terbaru
                </button>
                <button id="btn-populer" class="font-semibold text-gray-400  pb-1">
                    Bestseller
                </button>
            </div>
            <button class="text-gray-400 hover:text-text-light ">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-funnel-icon lucide-funnel">
                    <path
                        d="M10 20a1 1 0 0 0 .553.895l2 1A1 1 0 0 0 14 21v-7a2 2 0 0 1 .517-1.341L21.74 4.67A1 1 0 0 0 21 3H3a1 1 0 0 0-.742 1.67l7.225 7.989A2 2 0 0 1 10 14z" />
                </svg>
            </button>
        </nav>


        <div id="allshow" class="grid grid-cols-2 gap-4">
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
        {{-- {{ dd($data) }} --}}
        <div id="populershow" class="hidden grid grid-cols-2 gap-4">
            {{-- CARD PRODUK --}}
            @foreach ($populerproduk as $item)
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

    <script>
        const btnall = document.getElementById('btn-all');
        const btnpopuler = document.getElementById('btn-populer');
        const all = document.getElementById('allshow');
        const populer = document.getElementById('populershow');

        btnall.addEventListener('click', ()=>{
            btnall.classList.add(
                'text-text-light',
                'border-b-2',
                'border-[#e40312]',
                'text-gray-900'
            )
            btnpopuler.classList.remove(
                'text-text-light',
                'border-b-2',
                'border-[#e40312]',
                'text-gray-900'
            )
            all.classList.remove('hidden')
            populer.classList.add('hidden')
        });
        btnpopuler.addEventListener('click', ()=>{
            btnall.classList.remove(
                'text-text-light',
                'border-b-2',
                'border-[#e40312]',
                'text-gray-900',
            )
            btnall.classList.add(
                'text-gray-400',
            )
            btnpopuler.classList.add(
                'text-text-light',
                'border-b-2',
                'border-[#e40312]',
                'text-gray-900'
            )
            all.classList.add('hidden')
            populer.classList.remove('hidden')
        });
    </script>

@endsection