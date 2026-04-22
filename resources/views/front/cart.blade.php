@extends('layout.app')

@section('title', 'Cart')

@section('content')
    <div class="relative flex flex-col w-full max-w-[640px] min-h-screen gap-5 mx-auto bg-[#F5F5F0]">
        <div id="top-bar" class="flex justify-between items-center px-4 mt-[60px]">
            <a href="{{route('front.index')}}">
                <img src="{{asset('assets/images/icons/back.svg')}}" class="w-10 h-10" alt="icon">
            </a>
            <p class="font-bold text-lg leading-[27px]">Keranjang</p>
            <div class="dummy-btn w-10"></div>
        </div>
        <section id="fresh" class="flex flex-col gap-4 px-4 mb-[111px]">
            <div class="flex items-center py-2 mb-4">
                <input type="checkbox" id="selectAll" checked
<<<<<<< HEAD
                    class="h-5 w-5 text-green-500 border-[#e40312] accent-[#e40312] rounded focus:ring-green-500 mr-3">
=======
                    class="h-5 w-5 text-green-500 border-[#0AA085] accent-[#0AA085] rounded focus:ring-green-500 mr-3">
>>>>>>> 6d2ee0824dc6b8da7ad98afd3adb7fcc0b376f22
                <label for="selectAll" class="text-base text-gray-700 font-medium">Pilih semua</label>
            </div>
            @foreach ($carts as $item)
                <div class="cart-item flex items-start py-3 mb-2 border-b border-gray-100" data-price="20000"
                    data-quantity="1">
                    <input type="checkbox" checked
<<<<<<< HEAD
                        class="item-checkbox h-5 w-5 text-green-500 border-[#e40312] accent-[#e40312] rounded focus:ring-green-500 mt-1 mr-3 flex-shrink-0">
=======
                        class="item-checkbox h-5 w-5 text-green-500 border-[#0AA085] accent-[#0AA085] rounded focus:ring-green-500 mt-1 mr-3 flex-shrink-0">
>>>>>>> 6d2ee0824dc6b8da7ad98afd3adb7fcc0b376f22

                    <div class="flex flex-1">
                        <img src="{{ asset('storage/' . $item->product->thumbnail) }}" alt="Bebelac Susu"
                            class="w-24 h-24 rounded-lg object-cover mr-3 flex-shrink-0 border border-gray-200">

                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-800 leading-tight mb-0.5">{{ $item->product->name }}
                                {{$item->product->about}}
                            </p>
                            <p class="text-sm leading-[21px] ">{{ $item->product->category->name }}</p>
                            <div class="flex items-center justify-between mt-1">
<<<<<<< HEAD
                                <p class="text-base font-bold text-[#e40312] item-subtotal-display"
=======
                                <p class="text-base font-bold text-[#0AA085] item-subtotal-display"
>>>>>>> 6d2ee0824dc6b8da7ad98afd3adb7fcc0b376f22
                                    id="cart-subtotal-{{ $item->id }}">Rp
                                    {{ number_format($item->subtotal, 0, ',', '.') }}
                                </p>

                                <div class="flex items-center space-x-2">
                                    <button class="text-gray-400 hover:text-red-500 text-lg icon-trash"></button>
                                    <button
                                        class="btn-decrease w-7 h-7 border border-gray-300 text-gray-700 rounded-full text-lg icon-minus flex items-center justify-center minus-btn"
                                        data-id="{{ $item->id }}">-</button>
                                    <span class="text-base font-semibold w-4 text-center text-gray-800 qty-display"
                                        data-id="{{ $item->id }}">{{ $item->quantity }}</span>
                                    <button
                                        class="btn-increase w-7 h-7 bg-gray-800 text-white rounded-full text-lg icon-plus flex items-center justify-center plus-btn"
                                        data-id="{{ $item->id }}">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="flex flex-col gap-4">
                    <a>
                        <div
                            class="flex items-center rounded-3xl p-[10px_16px_16px_10px] gap-[14px] bg-white transition-all duration-300 hover:ring-2 hover:ring-[#FFC700]">
                            <div class="w-20 h-20 flex shrink-0 rounded-2xl bg-[#D9D9D9] overflow-hidden">
                                <img src="{{ Storage::url($item->product->thumbnail) }}" class="w-full h-full object-cover"
                                    alt="thumbnail">
                            </div>
                            <div class="flex w-full items-center justify-between gap-[14px]">
                                <div class="flex flex-col gap-[6px]">
                                    <h3 class="font-bold leading-[20px]">{{ $item->product->name }}</h3>
                                    <p class="text-sm leading-[21px] ">{{ $item->product->category->name }}</p>
                                </div>
                                <p id="cart-subtotal-{{ $item->id }}" class="text-sm text-gray-500">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </p>

                            </div>
                            <div class="flex items-center gap-2 mt-2">
                                <button class="btn-decrease px-3 py-1 bg-gray-300 rounded"
                                    data-id="{{ $item->id }}">-</button>
                                <span class="px-3 py-1 border rounded qty-display" data-id="{{ $item->id }}">{{
                                    $item->quantity }}</span>
                                <button class="btn-increase px-3 py-1 bg-green-300 rounded"
                                    data-id="{{ $item->id }}">+</button>
                            </div>

                        </div>

                    </a>
                </div> --}}
            @endforeach

        </section>
        @if($carts->count() > 0)
            <div id="bottom-nav" class="relative flex h-[100px] w-full shrink-0 mt-5">
                <div class="fixed bottom-5 w-full max-w-md z-30 px-4">
                    <div class="flex items-center justify-between rounded-full bg-[#2A2A2A] p-2 pl-6">
                        <div class="flex flex-col ">
                            <p class="text-sm  text-[#878785]">Total harga</p>
                            <p id="grand-total" class="font-bold text-md  text-white">Rp
                                {{ number_format($total, 0, ',', '.') }}
                            </p>
                            
                        </div>
                        <a href="{{ route('checkout.index') }}"
<<<<<<< HEAD
                            class="rounded-full p-[12px_20px] bg-[#e40312] font-semibold text-white">Lanjut</a>
=======
                            class="rounded-full p-[12px_20px] bg-[#0AA085] font-semibold text-white">Lanjut</a>
>>>>>>> 6d2ee0824dc6b8da7ad98afd3adb7fcc0b376f22
                    </div>
                </div>
            </div>
        @endif

    </div>
    <script src="{{asset('js/cart.js')}}"></script>
@endsection