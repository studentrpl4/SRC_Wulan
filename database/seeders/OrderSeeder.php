<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\PromoCode;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $customers = Customer::all();
        $products  = Product::all();
        $promos    = PromoCode::where('is_active', true)->get();

        // Order 1: Budi — belanja snack & minuman, tanpa promo
        $order1 = Order::create([
            'customer_id' => $customers[0]->id,
            'invoice' => 'INV-' . now()->format('Ymd') . '-001',
            'address' => 'Jl. Merdeka No. 45, Kel. Sukajadi, Kec. Sukajadi, Bandung 40162',
            'payment_method' => 'transfer_bank',
            'total_price' => 30500,
            'status' => 'completed',
            'promo_id' => null,
            'discount_amount' => 0,
        ]);
        OrderItem::create(['order_id' => $order1->id, 'product_id' => $products[0]->id, 'quantity' => 2, 'price' => 11500, 'subtotal' => 23000]);
        OrderItem::create(['order_id' => $order1->id, 'product_id' => $products[4]->id, 'quantity' => 1, 'price' => 5500, 'subtotal' => 5500]);

        // Order 2: Dewi — belanja instan & rumah tangga, pakai HEMATBELANJA
        $promoHemat = $promos->where('code', 'HEMATBELANJA')->first();
        $sub2 = 3500 * 5 + 12500; // 5 Indomie + 1 Sunlight = 30000
        $disc2 = min($sub2 * 10 / 100, 15000);
        $order2 = Order::create([
            'customer_id' => $customers[1]->id,
            'invoice' => 'INV-' . now()->format('Ymd') . '-002',
            'address' => 'Jl. Asia Afrika No. 12, Kel. Braga, Kec. Sumur Bandung, Bandung 40111',
            'payment_method' => 'e_wallet',
            'total_price' => (int)($sub2 - $disc2),
            'status' => 'shipped',
            'promo_id' => $promoHemat?->id,
            'discount_amount' => (int)$disc2,
        ]);
        OrderItem::create(['order_id' => $order2->id, 'product_id' => $products[6]->id, 'quantity' => 5, 'price' => 3500, 'subtotal' => 17500]);
        OrderItem::create(['order_id' => $order2->id, 'product_id' => $products[9]->id, 'quantity' => 1, 'price' => 12500, 'subtotal' => 12500]);

        // Order 3: Andi — belanja perawatan, pakai GRATISONGKIR
        $promoOngkir = $promos->where('code', 'GRATISONGKIR')->first();
        $sub3 = 28000 + 15000 + 24500; // Lifebuoy + Pepsodent + Pantene = 67500
        $order3 = Order::create([
            'customer_id' => $customers[2]->id,
            'invoice' => 'INV-' . now()->format('Ymd') . '-003',
            'address' => 'Jl. Dago No. 88, Kel. Dago, Kec. Coblong, Bandung 40135',
            'payment_method' => 'cod',
            'total_price' => (int)($sub3 - 10000),
            'status' => 'processing',
            'promo_id' => $promoOngkir?->id,
            'discount_amount' => 10000,
        ]);
        OrderItem::create(['order_id' => $order3->id, 'product_id' => $products[12]->id, 'quantity' => 1, 'price' => 28000, 'subtotal' => 28000]);
        OrderItem::create(['order_id' => $order3->id, 'product_id' => $products[13]->id, 'quantity' => 1, 'price' => 15000, 'subtotal' => 15000]);
        OrderItem::create(['order_id' => $order3->id, 'product_id' => $products[14]->id, 'quantity' => 1, 'price' => 24500, 'subtotal' => 24500]);

        // Order 4: Sari — belanja campur, tanpa promo
        $order4 = Order::create([
            'customer_id' => $customers[3]->id,
            'invoice' => 'INV-' . now()->format('Ymd') . '-004',
            'address' => 'Jl. Cihampelas No. 160, Kel. Cipaganti, Kec. Coblong, Bandung 40131',
            'payment_method' => 'transfer_bank',
            'total_price' => 42400,
            'status' => 'completed',
            'promo_id' => null,
            'discount_amount' => 0,
        ]);
        OrderItem::create(['order_id' => $order4->id, 'product_id' => $products[1]->id, 'quantity' => 2, 'price' => 10900, 'subtotal' => 21800]);
        OrderItem::create(['order_id' => $order4->id, 'product_id' => $products[3]->id, 'quantity' => 2, 'price' => 3500, 'subtotal' => 7000]);
        OrderItem::create(['order_id' => $order4->id, 'product_id' => $products[7]->id, 'quantity' => 2, 'price' => 3200, 'subtotal' => 6400]);
        OrderItem::create(['order_id' => $order4->id, 'product_id' => $products[5]->id, 'quantity' => 1, 'price' => 7500, 'subtotal' => 7500]);

        // Order 5: Rizky — belanja besar, pakai MEMBER15
        $promoMember = $promos->where('code', 'MEMBER15')->first();
        $sub5 = 52000 + 18500 + 15500; // Baygon + Rinso + Tango = 86000
        $disc5 = min($sub5 * 15 / 100, 25000);
        $order5 = Order::create([
            'customer_id' => $customers[4]->id,
            'invoice' => 'INV-' . now()->format('Ymd') . '-005',
            'address' => 'Jl. Buah Batu No. 77, Kel. Turangga, Kec. Lengkong, Bandung 40264',
            'payment_method' => 'e_wallet',
            'total_price' => (int)($sub5 - $disc5),
            'status' => 'processing',
            'promo_id' => $promoMember?->id,
            'discount_amount' => (int)$disc5,
        ]);
        OrderItem::create(['order_id' => $order5->id, 'product_id' => $products[11]->id, 'quantity' => 1, 'price' => 52000, 'subtotal' => 52000]);
        OrderItem::create(['order_id' => $order5->id, 'product_id' => $products[10]->id, 'quantity' => 1, 'price' => 18500, 'subtotal' => 18500]);
        OrderItem::create(['order_id' => $order5->id, 'product_id' => $products[2]->id, 'quantity' => 1, 'price' => 15500, 'subtotal' => 15500]);
    }
}
