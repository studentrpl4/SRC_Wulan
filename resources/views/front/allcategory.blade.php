@extends('layout.app')

@section('title', 'SRC Wulan')

@section('content')
    <div class="relative flex flex-col w-full max-w-[640px] min-h-screen gap-5 mx-auto bg-[#ffffff]">
        <div id="top-bar" class="flex justify-between items-center px-4 mt-[10px]">
            <a href="{{route('front.index')}}">
                <img src="{{asset('assets/images/icons/back.svg')}}" class="w-10 h-10" alt="icon">
            </a>
            <p class="font-bold text-lg leading-[27px]">Kategori</p>
            <div class="dummy-btn w-10"></div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            @if (!empty($categories))
                @foreach ($categories as $item)
                    <a href="{{route('front.category', $item->slug)}}"
                        class="flex items-center p-3 rounded-xl bg-white shadow-sm border border-gray-100 hover:bg-gray-50 transition duration-150">
                        <div class="p-3 bg-primary-accent/10 rounded-lg mr-3">
                             @if ($item->icon && file_exists(public_path('storage/' . $item->icon)))
                                    <img src="{{ asset('storage/' . $item->icon) }}"
                                        class="w-6 h-6 object-cover object-left text-primary-green" alt="thumbnail">
                                @else
                                    <svg class="w-6 h-6 text-primary-green" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h16" />
                                    </svg>
                                @endif
                        </div>
                        <span class="text-sm font-medium text-gray-800">{{ $item->name }}</span>
                    </a>
                @endforeach
            @else
                <p>Belum Ada Data Terbaru...</p>
            @endif

        </div>

@endsection