<x-filament-panels::page>
    <div class="flex rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 shadow-sm" style="height: 70vh;">
        
        {{-- SIDEBAR KIRI: Daftar Customer --}}
        <div class="w-1/3 border-r border-gray-200 dark:border-gray-700 flex flex-col h-full bg-gray-50/50 dark:bg-gray-950/20" wire:poll.4s>
            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Daftar Obrolan</h3>
            </div>
            
            <div class="flex-1 overflow-y-auto divide-y divide-gray-100 dark:divide-gray-800">
                @forelse($this->customers as $c)
                    <button 
                        type="button"
                        wire:click="selectCustomer({{ $c->id }})" 
                        class="w-full text-left p-4 flex items-center gap-3 transition-all hover:bg-gray-100 dark:hover:bg-gray-800/50 {{ $this->activeCustomerId === $c->id ? 'bg-gray-100 dark:bg-gray-800/80 border-l-4 border-primary-500' : '' }}"
                    >
                        <div class="w-10 h-10 rounded-full bg-primary-600 flex items-center justify-center text-white font-bold text-sm shadow-sm">
                            {{ strtoupper(substr($c->name ?? 'C', 0, 1)) }}
                        </div>
                        
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <h4 class="text-sm font-semibold text-gray-950 dark:text-white truncate">
                                    {{ $c->name ?? 'Pelanggan' }}
                                </h4>
                                <span class="text-[10px] text-gray-400">
                                    {{ $c->latest_message_at ? \Carbon\Carbon::parse($c->latest_message_at)->timezone('Asia/Jakarta')->format('H:i') : '' }}
                                </span>
                            </div>
                            
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate mt-1">
                                {{ $c->latest_message ?? 'Mulai obrolan...' }}
                            </p>
                        </div>
                        
                        @if($c->unread_count > 0)
                            <div class="h-5 min-w-5 px-1.5 rounded-full bg-red-600 flex items-center justify-center text-[10px] text-white font-bold animate-bounce">
                                {{ $c->unread_count }}
                            </div>
                        @endif
                    </button>
                @empty
                    <div class="p-8 text-center text-xs text-gray-400">
                        Belum ada riwayat obrolan pembeli.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- PANE KANAN: Riwayat Chat & Balas --}}
        <div class="flex-1 flex flex-col h-full bg-white dark:bg-gray-900">
            @if($this->activeCustomer)
                {{-- HEADER OBROLAN --}}
                <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between bg-gray-50/20 dark:bg-gray-950/10">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-primary-600 flex items-center justify-center text-white font-bold text-sm">
                            {{ strtoupper(substr($this->activeCustomer->name ?? 'C', 0, 1)) }}
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-950 dark:text-white">
                                {{ $this->activeCustomer->name ?? 'Pelanggan' }}
                            </h3>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400">
                                {{ $this->activeCustomer->email }} | {{ $this->activeCustomer->phone ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- AREA PESAN --}}
                <div 
                    id="adminChatMessages" 
                    wire:poll.3s
                    class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50/30 dark:bg-gray-900"
                >
                    <div class="flex justify-center mb-2">
                        <span class="text-[10px] bg-gray-200 dark:bg-gray-800 text-gray-600 dark:text-gray-400 px-3 py-1 rounded-full shadow-sm">
                            Riwayat Obrolan
                        </span>
                    </div>

                    @foreach($this->messages as $msg)
                        @if($msg->sender === 'customer')
                            {{-- PESAN CUSTOMER (Masuk) --}}
                            <div class="flex items-start gap-2" wire:key="msg-{{ $msg->id }}">
                                <div class="w-8 h-8 rounded-full bg-primary-600 flex items-center justify-center text-white text-xs font-bold shadow-sm">
                                    {{ strtoupper(substr($this->activeCustomer->name ?? 'C', 0, 1)) }}
                                </div>
                                <div class="max-w-[70%]">
                                    <div class="bg-white dark:bg-gray-800 rounded-2xl rounded-tl-none px-4 py-2.5 border border-gray-100 dark:border-gray-700 shadow-sm">
                                        <p class="text-sm text-gray-800 dark:text-gray-200 break-words leading-relaxed">
                                            {{ $msg->message }}
                                        </p>
                                    </div>
                                    <p class="text-[9px] text-gray-400 mt-1 ml-1">
                                        {{ $msg->created_at->timezone('Asia/Jakarta')->format('d M, H:i') }}
                                    </p>
                                </div>
                            </div>
                        @else
                            {{-- PESAN ADMIN (Keluar) --}}
                            <div class="flex justify-end" wire:key="msg-{{ $msg->id }}">
                                <div class="max-w-[70%]">
                                    <div class="bg-primary-600 text-white rounded-2xl rounded-tr-none px-4 py-2.5 shadow-sm">
                                        <p class="text-sm break-words leading-relaxed">
                                            {{ $msg->message }}
                                        </p>
                                    </div>
                                    <p class="text-[9px] text-gray-400 mt-1 text-right mr-1">
                                        {{ $msg->created_at->timezone('Asia/Jakarta')->format('d M, H:i') }}
                                        @if($msg->is_read)
                                            <span class="text-emerald-500 ml-1">✔✔</span>
                                        @else
                                            <span class="text-gray-400 ml-1">✔</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                {{-- FORM BALASAN --}}
                <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
                    <form wire:submit.prevent="sendReply" class="flex gap-2">
                        <input 
                            wire:model.defer="replyMessage"
                            type="text" 
                            placeholder="Tulis balasan pesan untuk pelanggan..." 
                            class="flex-1 block w-full rounded-lg border-0 py-2.5 text-gray-950 dark:text-white bg-gray-100 dark:bg-gray-800 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 text-sm outline-none px-4"
                            autocomplete="off"
                            required
                        >
                        
                        <button 
                            type="submit"
                            class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-lg bg-primary-600 text-white font-semibold text-sm shadow-sm hover:bg-primary-500 transition-all active:scale-95"
                        >
                            <span>Balas</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transform rotate-45" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.125A59.769 59.769 0 0121.485 12 59.768 59.768 0 013.27 20.875L6 12zm0 0h7.5" />
                            </svg>
                        </button>
                    </form>
                </div>
            @else
                <div class="flex-1 flex flex-col items-center justify-center p-8 text-center text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-200 dark:text-gray-800 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Belum Ada Obrolan Dipilih</h3>
                    <p class="text-xs text-gray-500 mt-1 max-w-xs">Silakan pilih salah satu pelanggan dari daftar di sidebar kiri untuk menampilkan obrolan chat.</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const scrollContainer = () => {
                const adminMessages = document.getElementById('adminChatMessages');
                if (adminMessages) {
                    adminMessages.scrollTop = adminMessages.scrollHeight;
                }
            };

            // Initial Scroll
            setTimeout(scrollContainer, 300);

            // Listeners
            window.addEventListener('admin-scroll-to-bottom', () => {
                setTimeout(scrollContainer, 50);
            });

            window.addEventListener('admin-chat-switched', () => {
                setTimeout(scrollContainer, 100);
            });

            // Livewire polling element updates
            const observer = new MutationObserver(() => {
                scrollContainer();
            });

            const chatPane = document.getElementById('adminChatMessages');
            if (chatPane) {
                observer.observe(chatPane, { childList: true });
            }
        });
    </script>
</x-filament-panels::page>
