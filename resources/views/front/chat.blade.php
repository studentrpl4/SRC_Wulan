@extends('layout.app')

@section('title', 'Room Chat SRC Wulan')

@section('content')
<div class="min-h-screen bg-[#f5f7fb] flex flex-col">

    {{-- HEADER CHAT --}}
    <header class="bg-white px-4 py-4 shadow-sm sticky top-0 z-20">
        <div class="flex items-center gap-3">
            <a href="{{ route('front.index') }}" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-700" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>

            <div class="w-11 h-11 rounded-full bg-[#e40312] flex items-center justify-center text-white font-bold">
                S
            </div>

            <div class="flex-1">
                <h1 class="font-semibold text-gray-900 leading-tight">Admin SRC Wulan</h1>
                <div class="flex items-center gap-1 text-xs text-green-600">
                    <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                    Online
                </div>
            </div>

            <button class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-700" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372a1.125 1.125 0 00-.852-1.091l-4.423-1.106a1.125 1.125 0 00-1.173.417l-.97 1.293a1.125 1.125 0 01-1.21.38 12.035 12.035 0 01-7.143-7.143 1.125 1.125 0 01.38-1.21l1.293-.97a1.125 1.125 0 00.417-1.173L6.963 3.102A1.125 1.125 0 005.872 2.25H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                </svg>
            </button>
        </div>
    </header>

    {{-- AREA PESAN --}}
    <main id="chatMessages" class="flex-1 overflow-y-auto px-4 py-5 space-y-4 pb-28">

        {{-- TANGGAL --}}
        <div class="flex justify-center">
            <span class="text-xs bg-white text-gray-500 px-3 py-1 rounded-full shadow-sm">
                Hari ini
            </span>
        </div>

        {{-- PESAN ADMIN --}}
        <div class="flex items-start gap-2">
            <div class="w-8 h-8 rounded-full bg-[#e40312] flex items-center justify-center text-white text-xs font-bold">
                S
            </div>

            <div class="max-w-[75%]">
                <div class="bg-white rounded-2xl rounded-tl-none px-4 py-3 shadow-sm">
                    <p class="text-sm text-gray-800 leading-relaxed">
                        Halo, selamat datang di SRC Wulan. Ada yang bisa kami bantu?
                    </p>
                </div>
                <p class="text-[11px] text-gray-400 mt-1 ml-1">09.00</p>
            </div>
        </div>

        {{-- PESAN CUSTOMER --}}
        <div class="flex justify-end">
            <div class="max-w-[75%]">
                <div class="bg-[#e40312] rounded-2xl rounded-tr-none px-4 py-3 shadow-sm">
                    <p class="text-sm text-white leading-relaxed">
                        Halo admin, saya ingin bertanya tentang produk.
                    </p>
                </div>
                <p class="text-[11px] text-gray-400 mt-1 text-right mr-1">09.01</p>
            </div>
        </div>

        {{-- PESAN ADMIN --}}
        <div class="flex items-start gap-2">
            <div class="w-8 h-8 rounded-full bg-[#e40312] flex items-center justify-center text-white text-xs font-bold">
                S
            </div>

            <div class="max-w-[75%]">
                <div class="bg-white rounded-2xl rounded-tl-none px-4 py-3 shadow-sm">
                    <p class="text-sm text-gray-800 leading-relaxed">
                        Baik, silakan tanyakan produk yang ingin Anda cari.
                    </p>
                </div>
                <p class="text-[11px] text-gray-400 mt-1 ml-1">09.02</p>
            </div>
        </div>

    </main>

    {{-- INPUT CHAT --}}
    <div class="fixed bottom-0 left-1/2 -translate-x-1/2 w-full max-w-md bg-white px-4 py-3 shadow-[0_-8px_24px_rgba(0,0,0,0.06)]">
        <form id="chatForm" class="flex items-center gap-2">

            <button type="button" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.586-6.586a4 4 0 10-5.656-5.656L5.758 10.758a6 6 0 108.484 8.484L20 13.485" />
                </svg>
            </button>

            <input
                id="messageInput"
                type="text"
                placeholder="Tulis pesan..."
                class="flex-1 bg-gray-100 rounded-full px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-[#e40312]/30"
                autocomplete="off"
            >

            <button type="submit" class="w-11 h-11 rounded-full bg-[#e40312] flex items-center justify-center shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6 12L3.269 3.125A59.769 59.769 0 0121.485 12 59.768 59.768 0 013.27 20.875L6 12zm0 0h7.5" />
                </svg>
            </button>

        </form>
    </div>

</div>

@push('scripts')
<script>
    const chatForm = document.getElementById('chatForm');
    const messageInput = document.getElementById('messageInput');
    const chatMessages = document.getElementById('chatMessages');

    chatForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const message = messageInput.value.trim();

        if (message === '') {
            return;
        }

        const time = new Date().toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit'
        });

        const messageElement = document.createElement('div');
        messageElement.className = 'flex justify-end';
        messageElement.innerHTML = `
            <div class="max-w-[75%]">
                <div class="bg-[#e40312] rounded-2xl rounded-tr-none px-4 py-3 shadow-sm">
                    <p class="text-sm text-white leading-relaxed">${message}</p>
                </div>
                <p class="text-[11px] text-gray-400 mt-1 text-right mr-1">${time}</p>
            </div>
        `;

        chatMessages.appendChild(messageElement);
        messageInput.value = '';
        chatMessages.scrollTop = chatMessages.scrollHeight;
    });
</script>
@endpush

@endsection