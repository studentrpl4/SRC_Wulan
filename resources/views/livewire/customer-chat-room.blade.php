<div class="min-h-screen bg-[#f5f7fb] flex flex-col w-full max-w-[640px] mx-auto relative shadow-md">

    {{-- HEADER CHAT --}}
    <header class="bg-white px-4 py-4 shadow-sm sticky top-0 z-20 flex items-center gap-3">
        <a href="{{ route('front.index') }}" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center transition-all hover:bg-gray-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-700" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </a>

        <div class="w-11 h-11 rounded-full bg-[#e40312] flex items-center justify-center text-white font-bold shadow-sm">
            S
        </div>

        <div class="flex-1">
            <h1 class="font-semibold text-gray-900 leading-tight text-sm">Admin SRC Wulan</h1>
            <div class="flex items-center gap-1 text-xs text-green-600">
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                Online
            </div>
        </div>

        <a href="tel:{{ env('STORE_PHONE', '08123456789') }}" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center transition-all hover:bg-gray-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-700" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372a1.125 1.125 0 00-.852-1.091l-4.423-1.106a1.125 1.125 0 00-1.173.417l-.97 1.293a1.125 1.125 0 01-1.21.38 12.035 12.035 0 01-7.143-7.143 1.125 1.125 0 01.38-1.21l1.293-.97a1.125 1.125 0 00.417-1.173L6.963 3.102A1.125 1.125 0 005.872 2.25H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
            </svg>
        </a>
    </header>

    {{-- AREA PESAN --}}
    <main id="chatMessages" wire:poll.3s class="flex-1 overflow-y-auto px-4 py-5 space-y-4 pb-28" style="height: calc(100vh - 150px);">
        
        <div class="flex justify-center">
            <span class="text-[10px] bg-gray-200 text-gray-600 px-3 py-1 rounded-full shadow-sm">
                Percakapan dimulai
            </span>
        </div>

        @forelse($messages as $msg)
            @if($msg->sender === 'admin')
                {{-- PESAN ADMIN --}}
                <div class="flex items-start gap-2" wire:key="msg-{{ $msg->id }}">
                    <div class="w-8 h-8 rounded-full bg-[#e40312] flex items-center justify-center text-white text-xs font-bold shadow-sm">
                        S
                    </div>

                    <div class="max-w-[75%]">
                        <div class="bg-white rounded-2xl rounded-tl-none px-4 py-3 shadow-sm border border-gray-100">
                            <p class="text-sm text-gray-800 leading-relaxed break-words">
                                {{ $msg->message }}
                            </p>
                        </div>
                        <p class="text-[10px] text-gray-400 mt-1 ml-1">
                            {{ $msg->created_at->timezone('Asia/Jakarta')->format('H:i') }}
                        </p>
                    </div>
                </div>
            @else
                {{-- PESAN CUSTOMER --}}
                <div class="flex justify-end" wire:key="msg-{{ $msg->id }}">
                    <div class="max-w-[75%]">
                        <div class="bg-[#e40312] rounded-2xl rounded-tr-none px-4 py-3 shadow-sm">
                            <p class="text-sm text-white leading-relaxed break-words">
                                {{ $msg->message }}
                            </p>
                        </div>
                        <p class="text-[10px] text-gray-400 mt-1 text-right mr-1">
                            {{ $msg->created_at->timezone('Asia/Jakarta')->format('H:i') }}
                            @if($msg->is_read)
                                <span class="text-emerald-500 ml-1">✔✔</span>
                            @else
                                <span class="text-gray-400 ml-1">✔</span>
                            @endif
                        </p>
                    </div>
                </div>
            @endif
        @empty
            <div class="flex flex-col items-center justify-center py-12 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                <p class="text-xs text-gray-400">Belum ada pesan. Silakan ketik pesan di bawah untuk memulai obrolan dengan toko!</p>
            </div>
        @endforelse

    </main>

    {{-- INPUT CHAT --}}
    <div class="absolute bottom-0 left-0 w-full bg-white px-4 py-3 shadow-[0_-8px_24px_rgba(0,0,0,0.06)] border-t border-gray-100 z-10">
        <form wire:submit.prevent="sendMessage" class="flex items-center gap-2">
            <input
                wire:model.defer="newMessage"
                id="messageInput"
                type="text"
                placeholder="Tulis pesan..."
                class="flex-1 bg-gray-100 rounded-full px-5 py-3 text-sm outline-none border-none focus:ring-2 focus:ring-[#e40312]/30 placeholder-gray-400"
                autocomplete="off"
                required
            >

            <button type="submit" class="w-11 h-11 rounded-full bg-[#e40312] flex items-center justify-center shadow-md hover:bg-[#c40310] active:scale-95 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white transform rotate-45 -mr-0.5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6 12L3.269 3.125A59.769 59.769 0 0121.485 12 59.768 59.768 0 013.27 20.875L6 12zm0 0h7.5" />
                </svg>
            </button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const chatContainer = document.getElementById('chatMessages');
            
            const scrollToBottom = () => {
                if (chatContainer) {
                    chatContainer.scrollTop = chatContainer.scrollHeight;
                }
            };

            // Scroll on initial load
            setTimeout(scrollToBottom, 200);

            // Listen to Livewire's dispatch event for new messages
            window.addEventListener('scroll-to-bottom', () => {
                setTimeout(scrollToBottom, 50);
            });

            // Scroll when polling fetches new messages (by checking element additions)
            const observer = new MutationObserver(() => {
                scrollToBottom();
            });

            if (chatContainer) {
                observer.observe(chatContainer, { childList: true });
            }
        });
    </script>
</div>
