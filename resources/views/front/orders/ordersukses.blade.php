@extends('layout.app')
<<<<<<< HEAD
@section('title', 'SRC Wulan')

@section('content')
    <div class=" relative flex flex-col w-full max-w-md min-h-screen bg-[#e40312]">
=======
@section('title', 'Madinashop')

@section('content')
    <div class=" relative flex flex-col w-full max-w-md min-h-screen bg-[#0AA085]">
>>>>>>> 6d2ee0824dc6b8da7ad98afd3adb7fcc0b376f22
        {{--
        <div class="absolute top-0 w-full max-w-md px-6 pt-2 flex justify-between text-lg font-semibold">
            <span>9:41</span>
            <span class="opacity-70">...</span>
        </div> --}}

        <div class="flex flex-col items-center text-center mt-40">

            <div class="check-icon-circle bg-white/30 text-white rounded-full mb-8 p-5">
                <div class="rounded-full border-2 boder-white p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-check-icon lucide-check">
                        <path d="M20 6 9 17l-5-5" />
                    </svg>
                </div>
            </div>

            <h1 class="text-3xl font-bold text-white mb-2">
                Pembayaran Berhasil
            </h1>

            <p class="text-base text-white opacity-80 mb-12 max-w-xs">
                Lorem ipsum dolor sit amet condektur
            </p>

            <div class="w-full max-w-xs flex flex-col space-y-4">

                <a href="{{ route('front.index') }}"
<<<<<<< HEAD
                    class="w-full bg-white text-[#e40312] font-semibold py-4 rounded-full shadow-lg hover:bg-gray-100 transition-colors">
=======
                    class="w-full bg-white text-[#0AA085] font-semibold py-4 rounded-full shadow-lg hover:bg-gray-100 transition-colors">
>>>>>>> 6d2ee0824dc6b8da7ad98afd3adb7fcc0b376f22
                    Kembali ke beranda
                </a>

                <a href="{{ route('customer.orders') }}"
<<<<<<< HEAD
                    class="w-full  border-white bg-white  text-[#e40312] font-semibold py-4 rounded-full shadow-lg transition-colors">
=======
                    class="w-full  border-white bg-white  text-[#0AA085] font-semibold py-4 rounded-full shadow-lg transition-colors">
>>>>>>> 6d2ee0824dc6b8da7ad98afd3adb7fcc0b376f22
                    Track Pesanan
                </a>
            </div>

        </div>

    </div>
@endsection