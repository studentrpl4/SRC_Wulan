<div class="space-y-4 p-4">
    {{-- Informasi Pesanan --}}
    <div class="border-b pb-2">
        <p class="font-bold text-lg">Invoice: {{ $order->invoice }}</p>
        <p class="text-sm text-gray-600">Tanggal: {{ $order->created_at->format('d M Y H:i') }}</p>
        <p class="text-sm text-gray-600">Customer: {{ $order->customer->name }}</p>
        <p class="text-sm text-gray-600">Nomor Telp: {{ $order->customer->phone }}</p>
        <p class="text-sm text-gray-600">Alamat: {{ $order->address }}</p>
        <p class="text-sm text-gray-600">Status: {{ ucfirst($order->status) }}</p>
    </div>

    {{-- Daftar Produk --}}
    <div class="space-y-2">
        <p class="font-semibold">Produk:</p>
        @foreach($order->order_items as $item)
            <div class="flex justify-between border-b pb-2">
                <div class="flex flex-col">
                    <p class="font-bold">{{ $item->product->name }}</p>
                    <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                </div>
                <p class="font-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
            </div>
        @endforeach
    </div>

    {{-- Total --}}
    <div class="pt-2 font-bold border-t text-right">
        Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}
    </div>
</div>
