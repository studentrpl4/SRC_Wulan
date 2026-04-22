<div
    class="fixed bottom-4 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white px-4 py-2 mr-3 rounded-full shadow-xl flex items-center gap-6">
    <a href="{{ route('front.index') }}" class="flex items-center gap-2 text-primary-green font-medium">
        <div
            class="{{ request()->routeIs('front.index') ? 'bg-[#e40312] flex p-3 rounded-full gap-2' : 'bg-gray-900' }} ">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-house-icon lucide-house">
                <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8" />
                <path
                    d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
            </svg>

            @if (request()->routeIs('front.index'))
                Beranda

            @endif

        </div>
    </a>

    <a href="{{route('produk')}}">
        <div class="{{ request()->routeIs('produk') ? 'bg-[#e40312] flex p-3 rounded-full gap-2' : 'bg-gray-900' }} ">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-store-icon lucide-store">
                <path d="M15 21v-5a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v5" />
                <path
                    d="M17.774 10.31a1.12 1.12 0 0 0-1.549 0 2.5 2.5 0 0 1-3.451 0 1.12 1.12 0 0 0-1.548 0 2.5 2.5 0 0 1-3.452 0 1.12 1.12 0 0 0-1.549 0 2.5 2.5 0 0 1-3.77-3.248l2.889-4.184A2 2 0 0 1 7 2h10a2 2 0 0 1 1.653.873l2.895 4.192a2.5 2.5 0 0 1-3.774 3.244" />
                <path d="M4 10.95V19a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8.05" />
            </svg>

            @if (request()->routeIs('produk'))
                Produk

            @endif
        </div>
    </a>

    <a href="{{ route('customer.orders') }}">
        <div
            class="{{ request()->routeIs('customer.orders') ? 'bg-[#e40312] flex p-3 rounded-full gap-2' : 'bg-gray-900' }} ">

            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-file-clock-icon lucide-file-clock">
                <path
                    d="M16 22h2a2 2 0 0 0 2-2V8a2.4 2.4 0 0 0-.706-1.706l-3.588-3.588A2.4 2.4 0 0 0 14 2H6a2 2 0 0 0-2 2v2.85" />
                <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                <path d="M8 14v2.2l1.6 1" />
                <circle cx="8" cy="16" r="6" />
            </svg>
            @if (request()->routeIs('customer.orders'))
                Produk
            @endif
        </div>
    </a>
    <a href={{route('customer.profile')}}>
        <div
            class="{{ request()->routeIs('customer.profile') ? 'bg-[#e40312] flex p-3 rounded-full gap-2' : 'bg-gray-900' }} ">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-user-round-icon lucide-user-round">
                <circle cx="12" cy="8" r="5" />
                <path d="M20 21a8 8 0 0 0-16 0" />
            </svg>
            @if (request()->routeIs('customer.profile'))
                Profile
            @endif
        </div>
    </a>


</div>