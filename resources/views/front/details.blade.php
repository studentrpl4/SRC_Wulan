@extends('layout.app')

@section('title', 'SRC Wulan')

@section('content')
    <div class="relative flex flex-col w-full max-w-[640px] min-h-screen gap-5 mx-auto bg-[#F5F5F0]">
        <div class="flex justify-between items-center px-4 mt-10">
            <a href="{{route('front.index')}}">
                <img src="{{asset('assets/images/icons/back.svg')}}" class="w-10 h-10" alt="icon">
            </a>
            <p class="font-bold text-lg leading-[27px]">Look Details</p>

            <a href="{{ route('cart.index') }}" class="p-2 bg-white rounded-full shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-shopping-cart-icon lucide-shopping-cart">
                    <circle cx="8" cy="21" r="1" />
                    <circle cx="19" cy="21" r="1" />
                    <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12" />
                </svg>
            </a>
        </div>
        <section id="gallery" class="flex flex-col gap-[10px]">
            <div class="flex w-full h-[250px] shrink-0 overflow-hidden px-4">
                <img id="main-thumbnail" src="{{Storage::url($product->photos()->latest()->first()->photo)}}"
                    class="w-full h-full object-contain object-center" alt="thumbnail">
            </div>
            <div class="swiper w-full overflow-hidden">
                <div class="swiper-wrapper">

                    @foreach ($product->photos as $itemPhoto)
                        <div class="swiper-slide !w-fit py-[2px]">
                            <label
                                class="thumbnail-selector flex flex-col shrink-0 w-20 h-20 rounded-[20px] p-[10px] bg-white transition-all duration-300 hover:ring-2 hover:ring-[#FFC700] has-[:checked]:ring-2 has-[:checked]:ring-[#FFC700]">
                                <input type="radio" name="image" class="hidden">
                                <img src="{{Storage::url($itemPhoto->photo)}}" class="w-full h-full object-contain"
                                    alt="thumbnail">
                            </label>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>
        <section id="info" class="flex flex-col gap-[14px] px-4">
            <div class="flex items-center justify-between">
                <h1 id="title" class="font-bold text-2xl leading-9">{{$product->name}}</h1>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-heart-icon lucide-heart">
                    <path
                        d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5" />
                </svg>
            </div>
            <p id="desc" class="leading-[30px]">{{$product->about}}.</p>
        </section>
        <div id="brand" class="flex items-center gap-4 px-4">


            <a href="{{route('front.category', $category->slug)}}"
                class="flex items-center p-3 rounded-xl bg-white shadow-sm border border-gray-100 hover:bg-gray-50 transition duration-150">
                <div class="p-3 bg-primary-accent/10 rounded-lg mr-auto">
                    @if ($category->icon && file_exists(public_path('storage/' . $category->icon)))
                        <img src="{{ asset('storage/' . $category->icon) }}"
                            class="w-6 h-6 object-cover object-left text-primary-green" alt="thumbnail">
                    @else
                        <svg class="w-6 h-6 text-primary-green" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    @endif
                </div>
                <span class="text-sm font-medium text-gray-800">{{$category->name}}</span>
            </a>
        </div>
        <div class="flex flex-col gap-2 px-4">
            <p class="font-semibold">Quantity</p>
            <div class="relative flex items-center gap-[30px]">
                <button type="button" id='minus'
                    class="flex w-full h-[54px] items-center justify-center rounded-full bg-[#2A2A2A] overflow-hidden">
                    <span class="font-bold text-xl leading-[30px] text-white">-</span>
                </button>
                <p id="quantity-display" class="font-bold text-xl leading-[30px]">1</p>
                <button type="button" id="plus"
                    class="flex w-full h-[54px] items-center justify-center rounded-full bg-[#e40312] overflow-hidden">
                    <span class="font-bold text-xl leading-[30px]">+</span>
                </button>
            </div>
        </div>
        <form action="{{ route('cart.add') }}" method="POST" class="flex flex-col ">
            @csrf
            <input type="hidden" name="product_id" value="{{$product->id}}">
            <input type="hidden" name="quantity" id="quantity" value="1">
            <div id="form-bottom-nav" class="relative flex h-[100px] w-full shrink-0 mt-5">
                <div class="fixed bottom-5 w-full max-w-md z-30 px-4">
                    <div class="flex items-center justify-between rounded-full bg-[#2A2A2A] p-[10px] pl-6">
                        <div class="flex flex-col gap-[2px]">
                            <p class="font-bold text-[20px] leading-[30px] text-white">Rp <span id="subtotal"
                                    data-price="{{ $product->price }}">{{ number_format($product->price, 0, ',', '.') }}</span>
                            </p>
                        </div>
                        <button type="submit" class="rounded-full p-3 bg-[#e40312] font-bold text-white">
                            Beli sekarang
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @if (session('success'))
        <div id="toast-success" class="fixed top-6 w-3/4 max-w-sm left-1/2 -translate-x-1/2 z-[999] flex items-center gap-4  bg-white text-white px-5 py-3 rounded-full shadow-xl animate-toast-down">

            {{-- Icon --}}
            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-[#e40312]/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-[#e40312]" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            {{-- Text --}}
            <p class="text-sm text-[#e40312] font-medium">
                {{ session('success') }}
            </p>
        </div>

        <script>
            setTimeout(() => {
                const toast = document.getElementById('toast-success');
                if (toast) {
                    toast.classList.add('animate-toast-up');
                    setTimeout(() => toast.remove(), 300);
                }
            }, 2000);
        </script>

        <style>
            @keyframes toastDown {
                from {
                    opacity: 0;
                    transform: translate(-0%, -50px);
                }

                to {
                    opacity: 1;
                    transform: translate( 0%, 0);
                }
            }

            @keyframes toastUp {
                from {
                    opacity: 1;
                    transform: translate(0%, 0);
                }

                to {
                    opacity: 0;
                    transform: translate(0%, -50px);
                }
            }

            .animate-toast-down {
                animation: toastDown 0.35s ease-out;
            }

            .animate-toast-up {
                animation: toastUp 0.3s ease-in forwards;
            }
        </style>
    @endif


    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{asset('js/details.js')}}"></script>
    <script src="{{asset('js/booking.js')}}"></script>
@endsection