@extends('layout.app')
@section('title', 'Detail Pesanan')
@section('content')
<<<<<<< HEAD
    <div class="min-h-screen bg-[#ffffff] flex justify-center">
=======
    <div class="min-h-screen bg-[#F5F5F0] flex justify-center">
>>>>>>> 6d2ee0824dc6b8da7ad98afd3adb7fcc0b376f22
        <div class="w-full max-w-sm px-4 pt-6 pb-10">

            <!-- Header -->
            <div class="flex items-center justify-between px-2 mb-6">
                <a href="{{ route('customer.orders') }}"
                    class="w-10 h-10 rounded-full bg-white flex items-center justify-center shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-arrow-left-icon lucide-arrow-left">
                        <path d="m12 19-7-7 7-7" />
                        <path d="M19 12H5" />
                    </svg>
                </a>
                <h1 class="text-lg font-semibold text-gray-900">
                    Detail Transaksi
                </h1>
                <div class="dummy-btn w-10"></div>
            </div>

            <!-- Detail Order -->
            <div class="bg-white rounded-2xl p-4 mb-4">
                <h2 class="font-semibold text-sm mb-3">Detail Order</h2>

                <div class="space-y-2 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>No. Order</span>
                        <span class="font-medium text-gray-900">{{ $order->invoice }}</span>
                    </div>

                    <div class="flex justify-between items-center text-gray-600">
                        <span>Metode Pembayaran</span>
                        <div class="flex items-center gap-2 font-medium text-gray-900">
                            {{ $order->payment_method }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Pengiriman -->
            <div class="bg-white rounded-2xl p-4 mb-4">
                <h2 class="font-semibold text-sm mb-3">Detail Pengiriman</h2>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>No. Order</span>
                        <span class="font-medium text-gray-900">{{ $order->invoice }}</span>
                    </div>

                    <div class="flex items-start gap-2 text-gray-600">
                        <span class="mt-0.5"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-map-pin-icon lucide-map-pin">
                                <path
                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
                                <circle cx="12" cy="10" r="3" />
                            </svg></span>
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">
                                Dikirim ke: {{ $order->customer->name }}
                            </p>
                            <p class="text-xs text-gray-500 leading-snug">
                                {{ $order->address }}
                            </p>
                        </div>
                        @if ($order->status == 'processing')
                            <span
                                class="inline-block bg-orange-100 text-orange-600 text-xs font-medium px-3 py-1 rounded-full w-fit">
                                Sedang disiapkan
                            </span>
                        @elseif($order->status == 'shipped')
                            <span
                                class="inline-block bg-orange-100 text-orange-600 text-xs font-medium px-3 py-1 rounded-full w-fit">
                                Sedang dikirim
                            </span>
                        @elseif($order->status == 'completed')
                            <span
                                class="inline-block bg-green-100 text-green-600 text-xs font-medium px-3 py-1 rounded-full w-fit">
                                Sedang dikirim
                            </span>
                        @endif
                        {{-- {{ dd($order->order_items) }} --}}
                    </div>


                </div>
            </div>

            <!-- Detail Produk -->
            <div class="bg-white rounded-2xl p-4">
                <h2 class="font-semibold text-sm mb-3">
                    Detail Produk Pembelian
                </h2>
                @foreach ($order->order_items as $item)
                    {{-- {{ dd($item) }} --}}
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('storage/' . $item->product->thumbnail) }}" class="w-12 h-12 rounded-lg border object-cover"
                            alt="produk" />

                        <div class="flex-1">
                            <p class="text-sm font-medium leading-tight text-gray-900">
                                {{ $item->product->name }} {{ $item->product->about }}
                            </p>
                            <p class="text-xs text-gray-500 mt-1">{{ $item->quantity }}x</p>
                        </div>

                        <p class="text-sm font-semibold text-emerald-600">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </p>
                    </div>
                @endforeach

            </div>

        </div>
    </div>

@endsection