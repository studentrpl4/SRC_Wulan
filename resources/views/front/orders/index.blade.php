@extends('layout.app')

@section('title', 'SRC Wulan 🏪')

@section('content')
    <div class="min-h-screen bg-[#ffffff] flex justify-center">
        <div class="w-full max-w-sm px-4 pt-6 pb-28">

            <!-- Header -->
            <div class="text-center mb-6">
                <h1 class="text-lg font-semibold text-gray-900">Transaksi</h1>
            </div>

            <!-- Tabs -->
            <div class="flex gap-6 text-sm border-b border-gray-200 mb-5">
                <button id="btn-all" class="pb-2 font-medium text-gray-900 border-b-2 border-gray-900">
                    Semua
                </button>
                <button id="btn-ongoing" class="pb-2 text-gray-400">
                    Dalam Perjalanan
                </button>
                <button id="btn-history" class="pb-2 text-gray-400">
                    Selesai
                </button>
            </div>

            <!-- Card Transaksi -->
            <div id="all-section" class="flex flex-col gap-4">
                @foreach ($allorder as $item)

                    <div class="bg-white rounded-2xl p-4 shadow-sm space-y-4">

                        <!-- Store   -->
                        <a href="{{ route('orders.show', $item->id) }}"></a>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10  rounded-xl flex items-center justify-center">
                                <img src="{{ asset('assets/images/logo_src_wulan.png') }}" alt="Logo SRC Wulan" class="w-6 h-6 object-cover">
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-sm">SRC Wulan</p>
                                @if ($item->status == 'processing')
                                    <p class="text-xs text-orange-500">
                                        Sedang disiapkan
                                    </p>
                                @elseif($item->status == 'shipped')
                                    <p class="text-xs text-orange-500">
                                        Sedang dalam perjalanan
                                    </p>
                                @elseif($item->status == 'completed')
                                    <p class="text-xs text-orange-500">
                                        pesanan selesai
                                    </p>
                                @endif

                            </div>
                        </div>

                        <!-- Product -->
                        <div class="flex items-center gap-3">
                            {{-- <img src="https://via.placeholder.com/48" class="w-12 h-12 rounded-lg object-cover border" />
                            --}}
                            <div class="flex-col gap-2">
                                <p class="text-sm font-medium leading-tight">
                                    {{ $item->invoice }}
                                </p>
                                <p class="text-sm font-medium leading-tight">
                                    Pembayaran : {{ $item->payment_method }}
                                </p>
                                <p class="text-sm font-medium leading-tight">
                                    Tanggal : {{date_format($item->created_at, 'd M Y')  }}
                                </p>
                                {{-- <p class="text-xs text-gray-400">1x</p> --}}
                            </div>
                        </div>
                        </a>
                        <!-- Footer -->
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-gray-400">Total pesanan</p>
                                <p class="text-sm font-semibold text-emerald-600">
                                    Rp {{ number_format($item->total_price, 0, ',', '.') }}
                                </p>
                            </div>
                            @php
                                $transaksi = optional($item->transaksi);
                            @endphp
                            @if($item->transaksi)
                                @if (($item->status == 'processing') && ($item->transaksi->status == 'berhasil'))
                                    <button class="bg-orange-500 text-white text-sm px-4 py-2 rounded-full font-medium">
                                        Pesanan disiapkan
                                    </button>
                                @elseif($item->status == 'shipped' && $item->transaksi->status == 'berhasil')
                                    <button class="bg-orange-500 text-white text-sm px-4 py-2 rounded-full font-medium">
                                        Pesanan diatar
                                    </button>
                                @elseif($item->status == 'completed' && $item->transaksi->status == 'berhasil')
                                    <button class="bg-[#e40312] text-white text-sm px-4 py-2 rounded-full font-medium">
                                        Pesanan telah sampai
                                    </button>
                                @elseif($item->transaksi->status == 'menunggu' && $item->payment_method == 'transfer')
                                    <button type="submit" onclick="payWithSnap('{{ $item->transaksi->snap_token }}')"
                                        class="bg-orange-500 text-white text-sm px-4 py-2 rounded-full font-medium">
                                        Bayar
                                    </button>
                                @endif
                            @else
                                @if ($item->status == 'processing')
                                    <button class="bg-orange-500 text-white text-sm px-4 py-2 rounded-full font-medium">
                                        Pesanan disiapkan
                                    </button>
                                @elseif($item->status == 'shipped')
                                    <button class="bg-orange-500 text-white text-sm px-4 py-2 rounded-full font-medium">
                                        Pesanan diatar
                                    </button>
                                @elseif($item->status == 'completed')
                                    <button class="bg-[#e40312] text-white text-sm px-4 py-2 rounded-full font-medium">
                                        Pesanan telah sampai
                                    </button>
                                @endif
                            @endif
                            {{-- {{ dd($item->status) }} --}}


                        </div>
                    </div>

                @endforeach
            </div>

            {{-- ONGOIng --}}
            <div id="ongoing-section" class="flex flex-col gap-4 hidden">
                @foreach ($ongoing as $item)
                    <div class="bg-white rounded-2xl p-4 shadow-sm space-y-4">

                        <!-- Store   -->
                        <a href="{{ route('orders.show', $item->id) }}"></a>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10  rounded-xl flex items-center justify-center">
                                <img src="{{ asset('assets/images/logo_src_wulan.png') }}" alt="Logo SRC Wulan" class="w-6 h-6 object-cover">
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-sm">SRC Wulan</p>
                                @if ($item->status == 'processing')
                                    <p class="text-xs text-orange-500">
                                        Sedang disiapkan
                                    </p>
                                @elseif($item->status == 'shipped')
                                    <p class="text-xs text-orange-500">
                                        Sedang dalam perjalanan
                                    </p>
                                @elseif($item->status == 'completed')
                                    <p class="text-xs text-orange-500">
                                        pesanan selesai
                                    </p>
                                @endif

                            </div>
                        </div>

                        <!-- Product -->
                        <div class="flex items-center gap-3">
                            {{-- <img src="https://via.placeholder.com/48" class="w-12 h-12 rounded-lg object-cover border" />
                            --}}
                            <div class="flex-col gap-2">
                                <p class="text-sm font-medium leading-tight">
                                    {{ $item->invoice }}
                                </p>
                                <p class="text-sm font-medium leading-tight">
                                    Pembayaran : {{ $item->payment_method }}
                                </p>
                                <p class="text-sm font-medium leading-tight">
                                    Tanggal : {{date_format($item->created_at, 'd M Y')  }}
                                </p>
                                {{-- <p class="text-xs text-gray-400">1x</p> --}}
                            </div>
                        </div>
                        </a>
                        <!-- Footer -->
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-gray-400">Total pesanan</p>
                                <p class="text-sm font-semibold text-emerald-600">
                                    Rp {{ number_format($item->total_price, 0, ',', '.') }}
                                </p>
                            </div>
                            @php
                                $transaksi = optional($item->transaksi);
                            @endphp
                            @if($item->transaksi)
                                @if (($item->status == 'processing') && ($item->transaksi->status == 'berhasil'))
                                    <button class="bg-orange-500 text-white text-sm px-4 py-2 rounded-full font-medium">
                                        Pesanan disiapkan
                                    </button>
                                @elseif($item->status == 'shipped' && $item->transaksi->status == 'berhasil')
                                    <button class="bg-orange-500 text-white text-sm px-4 py-2 rounded-full font-medium">
                                        Pesanan diatar
                                    </button>
                                @elseif($item->status == 'completed' && $item->transaksi->status == 'berhasil')
                                    <button class="bg-[#e40312] text-white text-sm px-4 py-2 rounded-full font-medium">
                                        Pesanan telah sampai
                                    </button>
                                @elseif($item->transaksi->status == 'menunggu' && $item->payment_method == 'transfer')
                                    <button type="submit" onclick="payWithSnap('{{ $item->transaksi->snap_token }}')"
                                        class="bg-orange-500 text-white text-sm px-4 py-2 rounded-full font-medium">
                                        Bayar
                                    </button>
                                @endif
                            @else
                                @if ($item->status == 'processing')
                                    <button class="bg-orange-500 text-white text-sm px-4 py-2 rounded-full font-medium">
                                        Pesanan disiapkan
                                    </button>
                                @elseif($item->status == 'shipped')
                                    <button class="bg-orange-500 text-white text-sm px-4 py-2 rounded-full font-medium">
                                        Pesanan diatar
                                    </button>
                                @elseif($item->status == 'completed')
                                    <button class="bg-[#e40312] text-white text-sm px-4 py-2 rounded-full font-medium">
                                        Pesanan telah sampai
                                    </button>
                                @endif
                            @endif
                            {{-- {{ dd($item->status) }} --}}


                        </div>
                    </div>
                @endforeach
            </div>

            {{-- selesai --}}
            <div id="history-section" class="flex flex-col gap-4 hidden">
                @foreach ($history as $item)
                    <div class="bg-white rounded-2xl p-4 shadow-sm space-y-4">

                        <!-- Store   -->
                        <a href="{{ route('orders.show', $item->id) }}"></a>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10  rounded-xl flex items-center justify-center">
                                <img src="{{ asset('assets/images/logo_src wulan.png') }}" alt="Logo SRC Wulan" class="w-6 h-6 object-cover">
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-sm">SRC Wulan</p>
                                @if ($item->status == 'processing')
                                    <p class="text-xs text-orange-500">
                                        Sedang disiapkan
                                    </p>
                                @elseif($item->status == 'shipped')
                                    <p class="text-xs text-orange-500">
                                        Sedang dalam perjalanan
                                    </p>
                                @elseif($item->status == 'completed')
                                    <p class="text-xs text-orange-500">
                                        pesanan selesai
                                    </p>
                                @endif

                            </div>
                        </div>

                        <!-- Product -->
                        <div class="flex items-center gap-3">
                            {{-- <img src="https://via.placeholder.com/48" class="w-12 h-12 rounded-lg object-cover border" />
                            --}}
                            <div class="flex-col gap-2">
                                <p class="text-sm font-medium leading-tight">
                                    {{ $item->invoice }}
                                </p>
                                <p class="text-sm font-medium leading-tight">
                                    Pembayaran : {{ $item->payment_method }}
                                </p>
                                <p class="text-sm font-medium leading-tight">
                                    Tanggal : {{date_format($item->created_at, 'd M Y')  }}
                                </p>
                                {{-- <p class="text-xs text-gray-400">1x</p> --}}
                            </div>
                        </div>
                        </a>
                        <!-- Footer -->
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-gray-400">Total pesanan</p>
                                <p class="text-sm font-semibold text-emerald-600">
                                    Rp {{ number_format($item->total_price, 0, ',', '.') }}
                                </p>
                            </div>
                            @php
                                $transaksi = optional($item->transaksi);
                            @endphp
                            @if($item->transaksi)
                                @if (($item->status == 'processing') && ($item->transaksi->status == 'berhasil'))
                                    <button class="bg-orange-500 text-white text-sm px-4 py-2 rounded-full font-medium">
                                        Pesanan disiapkan
                                    </button>
                                @elseif($item->status == 'shipped' && $item->transaksi->status == 'berhasil')
                                    <button class="bg-orange-500 text-white text-sm px-4 py-2 rounded-full font-medium">
                                        Pesanan diatar
                                    </button>
                                @elseif($item->status == 'completed' && $item->transaksi->status == 'berhasil')
                                    <button class="bg-[#e40312] text-white text-sm px-4 py-2 rounded-full font-medium">
                                        Pesanan telah sampai
                                    </button>
                                @elseif($item->transaksi->status == 'menunggu' && $item->payment_method == 'transfer')
                                    <button type="submit" onclick="payWithSnap('{{ $item->transaksi->snap_token }}')"
                                        class="bg-orange-500 text-white text-sm px-4 py-2 rounded-full font-medium">
                                        Bayar
                                    </button>
                                @endif
                            @else
                                @if ($item->status == 'processing')
                                    <button class="bg-orange-500 text-white text-sm px-4 py-2 rounded-full font-medium">
                                        Pesanan disiapkan
                                    </button>
                                @elseif($item->status == 'shipped')
                                    <button class="bg-orange-500 text-white text-sm px-4 py-2 rounded-full font-medium">
                                        Pesanan diatar
                                    </button>
                                @elseif($item->status == 'completed')
                                    <button class="bg-[#e40312] text-white text-sm px-4 py-2 rounded-full font-medium">
                                        Pesanan telah sampai
                                    </button>
                                @endif
                            @endif
                            {{-- {{ dd($item->status) }} --}}
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
        {{-- @if(isset($snapToken)) --}}
        <script src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
        <script type="text/javascript">

            function payWithSnap(snapToken) {
                snap.pay(snapToken, {
                    onSuccess: function (result) {
                        // Redirect setelah sukses
                        // Livewire.dispatch('berhasil');
                        window.location.href = "{{ route('order.success') }}";
                    },
                    onPending: function (result) {
                        // Redirect juga jika pending
                        window.location.href = "{{ route('customer.orders') }}";

                    },
                    onError: function (result) {
                        window.location.href = "{{ route('customer.orders') }}";
                        alert("transaksi gagal silahkan pesan ulang.");

                    }
                });
            };
        </script>
        {{-- @endif --}}
        <script>
            const btnOngoing = document.getElementById('btn-ongoing');
            const btnHistory = document.getElementById('btn-history');
            const btnall = document.getElementById('btn-all');
            const ongoing = document.getElementById('ongoing-section');
            const history = document.getElementById('history-section');
            const all = document.getElementById('all-section');

            btnOngoing.addEventListener('click', () => {
                btnOngoing.classList.add(
                    'font-medium',
                    'text-gray-900',
                    'border-b-2',
                    'border-gray-900');
                btnHistory.classList.remove('font-medium',
                    'text-gray-900',
                    'border-b-2',
                    'border-gray-900');
                btnall.classList.remove('font-medium',
                    'text-gray-900',
                    'border-b-2',
                    'border-gray-900');
                ongoing.classList.remove('hidden');
                history.classList.add('hidden');
                all.classList.add('hidden');
            });

            btnHistory.addEventListener('click', () => {
                btnOngoing.classList.remove(
                    'font-medium',
                    'text-gray-900',
                    'border-b-2',
                    'border-gray-900');
                btnHistory.classList.add('font-medium',
                    'text-gray-900',
                    'border-b-2',
                    'border-gray-900');
                btnall.classList.remove('font-medium',
                    'text-gray-900',
                    'border-b-2',
                    'border-gray-900');
                ongoing.classList.add('hidden');
                history.classList.remove('hidden');
                all.classList.add('hidden');
            });
            btnall.addEventListener('click', () => {
                btnOngoing.classList.remove(
                    'font-medium',
                    'text-gray-900',
                    'border-b-2',
                    'border-gray-900');
                btnHistory.classList.remove('font-medium',
                    'text-gray-900',
                    'border-b-2',
                    'border-gray-900');
                btnall.classList.add('font-medium',
                    'text-gray-900',
                    'border-b-2',
                    'border-gray-900');
                ongoing.classList.add('hidden');
                history.classList.add('hidden');
                all.classList.remove('hidden');
            });
        </script>

        <style>
            .tab {
                padding: 8px 16px;
                border-radius: 999px;
                background: #E0E0E0;
            }

            .tab-active {
                padding: 8px 16px;
                border-radius: 999px;
                background: #C5F277;
                font-weight: bold;
            }
        </style>

        @include('navbar.navbar')

@endsection