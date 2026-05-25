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
                        @php
                            $cartCount = \App\Models\Cart::where('customer_id', Auth::guard('customer')->id())->count();
                        @endphp
                        <a href="{{ route('cart.index') }}" class="relative p-2 bg-white rounded-full shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-shopping-cart-icon lucide-shopping-cart">
                                <circle cx="8" cy="21" r="1" />
                                <circle cx="19" cy="21" r="1" />
                                <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12" />
                            </svg>
                            @if($cartCount > 0)
                                <span class="absolute -top-1 -right-1 bg-[#e40312] text-white text-[10px] font-bold px-[5px] py-[1px] rounded-full shadow-sm border border-white">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>

                        <a href="{{ route('front.chat') }}" class="p-2 bg-white rounded-full shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M21 15a4 4 0 0 1-4 4H7l-4 4V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4z" />
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
        <form action="{{ route('front.search') }}" class="flex justify-between items-center mx-4">
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

        {{-- HERO PROMO BANNER --}}
        @php
            $heroSlides = !empty($promoBanners) && count($promoBanners) ? $promoBanners : [
                [
                    'banner_image' => asset('assets/images/default-promo.jpg'),
                    'title' => 'Belanja Hemat Hingga 50%',
                    'description' => 'DISKON SPESIAL',
                    'discount_badge' => 'DISKON SPESIAL',
                    'button_link' => route('produk'),
                ],
            ];
        @endphp

        <section class="mb-6">
            <div x-data="promoHeroSlider(@json($heroSlides))" x-init="init()" class="relative">
                <div class="overflow-hidden rounded-3xl shadow-md">
                    <template x-for="(slide, index) in slides" :key="index">
                        <div
                            x-show="activeIndex === index"
                            x-transition.duration.500ms
                            class="relative h-[160px] rounded-3xl overflow-hidden bg-cover bg-center"
                            :style="slide.banner_image 
                                ? 'background-image: linear-gradient(90deg, rgba(0,0,0,0.65), rgba(0,0,0,0.10)), url(' + slide.banner_image + ')' 
                                : 'background: linear-gradient(135deg, #0f766e, #e40312)'"
                        >
                            <div class="relative z-10 h-full flex flex-col justify-center px-6">
                                <p class="text-white text-xs font-semibold uppercase tracking-wide mb-1"
                                x-text="slide.discount_badge ?? 'DISKON SPESIAL'">
                                </p>

                                <h2 class="text-white text-2xl font-bold leading-tight max-w-[260px]"
                                    x-text="slide.title">
                                </h2>

                                <a :href="slide.button_link"
                                class="mt-4 inline-flex w-fit items-center justify-center rounded-full bg-white px-5 py-2 text-sm font-semibold text-[#e40312] shadow-sm">
                                    Belanja Sekarang
                                </a>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="mt-3 flex items-center justify-center gap-2" x-show="slides.length > 1">
                    <template x-for="(_, index) in slides" :key="index">
                        <button
                            type="button"
                            class="h-2.5 rounded-full transition-all duration-300"
                            :class="activeIndex === index ? 'bg-[#e40312] w-8' : 'bg-[#e5e7eb] w-2.5'"
                            @click="setIndex(index)">
                        </button>
                    </template>
                </div>
            </div>
        </section>

        {{-- KATEGORI --}}

        <div class="flex items-center justify-between mb-3">
            <h2 class="font-semibold text-gray-800">Kategori Produk</h2>
        </div>

        @if (!empty($categories) && $categories->count() > 0)
            <div x-data="{ open: false }" class="w-full">
                <!-- Grid Utama: Menampilkan 5 Kategori Pertama + 1 Tombol Toggle "Lainnya" -->
                <div class="grid grid-cols-2 gap-3 mb-3">
                    @foreach ($categories->take(5) as $item)
                        <a href="{{route('front.category', $item->slug)}}">
                            <div class="bg-white p-4 rounded-xl shadow-sm flex items-center gap-3 transition-all duration-300 hover:ring-2 hover:ring-[#FFC700] h-full">
                                @if ($item->icon && file_exists(public_path('storage/' . $item->icon)))
                                    <img src="{{ asset('storage/' . $item->icon) }}"
                                        class="w-6 h-6 object-cover object-left text-primary-green" alt="thumbnail">
                                @else
                                    <svg class="w-6 h-6 text-[#e40312]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    </svg>
                                @endif
                                <span class="text-sm font-semibold text-gray-700 leading-tight">{{ $item->name }}</span>
                            </div>
                        </a>
                    @endforeach

                    <!-- Tombol Toggle "Lainnya" / "Sembunyikan" -->
                    @if ($categories->count() > 5)
                        <button @click="open = !open" 
                            class="bg-white p-4 rounded-xl shadow-sm flex items-center justify-between gap-3 transition-all duration-300 hover:ring-2 hover:ring-[#FFC700] text-[#e40312] font-bold text-sm text-left h-full w-full outline-none focus:outline-none cursor-pointer">
                            <div class="flex items-center gap-3">
                                <svg class="w-6 h-6 text-[#e40312] transform transition-transform duration-300" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                                <span x-text="open ? 'Sembunyikan' : 'Lainnya'">Lainnya</span>
                            </div>
                        </button>
                    @endif
                </div>

                <!-- Bagian Kategori Tambahan dengan Efek Transition -->
                @if ($categories->count() > 5)
                    <div x-show="open" 
                        x-transition.duration.300ms
                        class="grid grid-cols-2 gap-3 mb-6 mt-0">
                        @foreach ($categories->skip(5) as $item)
                            <a href="{{route('front.category', $item->slug)}}">
                                <div class="bg-white p-4 rounded-xl shadow-sm flex items-center gap-3 transition-all duration-300 hover:ring-2 hover:ring-[#FFC700] h-full">
                                    @if ($item->icon && file_exists(public_path('storage/' . $item->icon)))
                                        <img src="{{ asset('storage/' . $item->icon) }}"
                                            class="w-6 h-6 object-cover object-left text-primary-green" alt="thumbnail">
                                    @else
                                        <svg class="w-6 h-6 text-[#e40312]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                        </svg>
                                    @endif
                                    <span class="text-sm font-semibold text-gray-700 leading-tight">{{ $item->name }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        @else
            <p class="text-gray-500 text-sm text-center py-4">Belum Ada Kategori Terbaru...</p>
        @endif

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
                        <div class="bg-white p-4 rounded-xl shadow-sm h-full flex flex-col justify-between">
                            <div>
                                <img src="{{ $item->thumbnail_url }}" class="w-full rounded-lg mb-3 object-cover aspect-square" alt="">
                                <h3 class="text-sm text-gray-700 font-medium leading-snug line-clamp-2">{{ $item->name }}</h3>
                                <p class="text-xs text-gray-400 mt-1 line-clamp-1">{{ $item->about }}</p>
                            </div>
                            <div>
                                <p class="text-[#e40312] font-bold text-sm mt-2">
                                    Rp. {{ number_format($item->price, 0, '.', '.') }}
                                </p>
                                <button type="submit"
                                    class="mt-3 w-full bg-[#e40312] text-white py-2 rounded-full text-sm font-semibold hover:bg-red-700 transition cursor-pointer relative z-10">
                                    + Keranjang
                                </button>
                            </div>
                        </div>
                    </form>
                </a>
            @endforeach
        </div>

        <!-- Custom Premium Pagination Links -->
        @if ($newProducts->hasPages())
            <div class="flex items-center justify-between mt-8 mb-12 bg-white px-4 py-3 rounded-2xl shadow-sm border border-gray-100">
                <!-- Tombol Previous -->
                @if ($newProducts->onFirstPage())
                    <span class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-300 cursor-not-allowed">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </span>
                @else
                    <a href="{{ $newProducts->previousPageUrl() }}" class="w-10 h-10 rounded-xl bg-gray-50 hover:bg-red-50 text-gray-600 hover:text-[#e40312] flex items-center justify-center transition-all duration-300 active:scale-95">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                @endif

                <!-- Info Halaman -->
                <span class="text-xs font-bold text-gray-600">
                    Halaman <span class="text-[#e40312]">{{ $newProducts->currentPage() }}</span> dari {{ $newProducts->lastPage() }}
                </span>

                <!-- Tombol Next -->
                @if ($newProducts->hasMorePages())
                    <a href="{{ $newProducts->nextPageUrl() }}" class="w-10 h-10 rounded-xl bg-gray-50 hover:bg-red-50 text-gray-600 hover:text-[#e40312] flex items-center justify-center transition-all duration-300 active:scale-95">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                @else
                    <span class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-300 cursor-not-allowed">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </span>
                @endif
            </div>
        @endif

    </div>

    {{-- BOTTOM NAV --}}
    @include('navbar.navbar')

    @push('scripts')
        <script defer src="https://unpkg.com/alpinejs@3.12.0/dist/cdn.min.js"></script>
        <script>
            function promoHeroSlider(initialSlides) {
                return {
                    slides: initialSlides || [],
                    activeIndex: 0,
                    intervalId: null,
                    touchStartX: 0,
                    touchEndX: 0,
                    init() {
                        if (!this.slides.length) {
                            return;
                        }
                        this.startAutoplay();
                        this.initSwipe();
                    },
                    setIndex(index) {
                        this.activeIndex = index;
                        this.resetAutoplay();
                    },
                    next() {
                        this.activeIndex = (this.activeIndex + 1) % this.slides.length;
                    },
                    prev() {
                        this.activeIndex = this.activeIndex === 0 ? this.slides.length - 1 : this.activeIndex - 1;
                    },
                    startAutoplay() {
                        this.intervalId = setInterval(() => this.next(), 4500);
                    },
                    resetAutoplay() {
                        if (this.intervalId) {
                            clearInterval(this.intervalId);
                        }
                        this.startAutoplay();
                    },
                    initSwipe() {
                        const slider = this.$root;
                        slider.addEventListener('touchstart', (event) => {
                            this.touchStartX = event.touches[0].clientX;
                        }, { passive: true });

                        slider.addEventListener('touchend', (event) => {
                            this.touchEndX = event.changedTouches[0].clientX;

                            if (this.touchEndX + 40 < this.touchStartX) {
                                this.next();
                                this.resetAutoplay();
                            } else if (this.touchEndX - 40 > this.touchStartX) {
                                this.prev();
                                this.resetAutoplay();
                            }
                        }, { passive: true });
                    }
                };
            }
        </script>
    @endpush

@endsection