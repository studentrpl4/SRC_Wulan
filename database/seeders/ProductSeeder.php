<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Seed data produk minimarket.
     */
    public function run(): void
    {
        $snackId      = Category::where('slug', 'makanan-ringan')->first()->id;
        $minumanId    = Category::where('slug', 'minuman')->first()->id;
        $instanId     = Category::where('slug', 'makanan-instan')->first()->id;
        $rumahtanggaId = Category::where('slug', 'kebutuhan-rumah-tangga')->first()->id;
        $perawatanId  = Category::where('slug', 'perawatan-tubuh')->first()->id;

        $products = [
            // === Makanan Ringan ===
            [
                'name'        => 'Chitato Sapi Panggang 68g',
                'thumbnail'   => 'chitato-sapi-panggang.jpg',
                'about'       => 'Keripik kentang rasa sapi panggang yang renyah dan gurih. Cocok untuk camilan sehari-hari.',
                'price'       => 11500,
                'stock'       => 120,
                'is_popular'  => true,
                'category_id' => $snackId,
            ],
            [
                'name'        => 'Oreo Original 133g',
                'thumbnail'   => 'oreo-original.jpg',
                'about'       => 'Biskuit sandwich coklat dengan krim vanilla yang lezat. Favorit segala usia.',
                'price'       => 10900,
                'stock'       => 100,
                'is_popular'  => true,
                'category_id' => $snackId,
            ],
            [
                'name'        => 'Tango Wafer Coklat 176g',
                'thumbnail'   => 'tango-wafer-coklat.jpg',
                'about'       => 'Wafer berlapis krim coklat yang renyah dan lezat. Kemasan pas untuk keluarga.',
                'price'       => 15500,
                'stock'       => 80,
                'is_popular'  => false,
                'category_id' => $snackId,
            ],

            // === Minuman ===
            [
                'name'        => 'Aqua Botol 600ml',
                'thumbnail'   => 'aqua-600ml.jpg',
                'about'       => 'Air mineral murni dari sumber mata air pegunungan terpilih. Menyegarkan dan menyehatkan.',
                'price'       => 3500,
                'stock'       => 200,
                'is_popular'  => true,
                'category_id' => $minumanId,
            ],
            [
                'name'        => 'Teh Botol Sosro 450ml',
                'thumbnail'   => 'teh-botol-sosro.jpg',
                'about'       => 'Teh manis dalam kemasan botol plastik, dibuat dari daun teh pilihan. Apapun makanannya, minumnya Teh Botol Sosro.',
                'price'       => 5500,
                'stock'       => 150,
                'is_popular'  => true,
                'category_id' => $minumanId,
            ],
            [
                'name'        => 'Pocari Sweat 500ml',
                'thumbnail'   => 'pocari-sweat-500ml.jpg',
                'about'       => 'Minuman isotonik pengganti ion tubuh. Cocok diminum setelah olahraga atau saat dehidrasi.',
                'price'       => 7500,
                'stock'       => 90,
                'is_popular'  => false,
                'category_id' => $minumanId,
            ],

            // === Makanan Instan ===
            [
                'name'        => 'Indomie Goreng Original',
                'thumbnail'   => 'indomie-goreng.jpg',
                'about'       => 'Mie instan goreng favorit Indonesia dengan bumbu khas yang menggugah selera. Mudah dan cepat disajikan.',
                'price'       => 3500,
                'stock'       => 300,
                'is_popular'  => true,
                'category_id' => $instanId,
            ],
            [
                'name'        => 'Mie Sedaap Goreng',
                'thumbnail'   => 'mie-sedaap-goreng.jpg',
                'about'       => 'Mie instan goreng dengan kriuk-kriuk bawang yang bikin nagih. Porsi pas untuk sekali makan.',
                'price'       => 3200,
                'stock'       => 250,
                'is_popular'  => true,
                'category_id' => $instanId,
            ],
            [
                'name'        => 'Pop Mie Ayam Bawang',
                'thumbnail'   => 'pop-mie-ayam.jpg',
                'about'       => 'Mie instan cup rasa ayam bawang, praktis tinggal seduh air panas. Cocok untuk bekal perjalanan.',
                'price'       => 5500,
                'stock'       => 100,
                'is_popular'  => false,
                'category_id' => $instanId,
            ],

            // === Kebutuhan Rumah Tangga ===
            [
                'name'        => 'Sunlight Jeruk Nipis 800ml',
                'thumbnail'   => 'sunlight-800ml.jpg',
                'about'       => 'Sabun cuci piring dengan kekuatan jeruk nipis 100x, efektif membersihkan lemak membandel.',
                'price'       => 12500,
                'stock'       => 75,
                'is_popular'  => true,
                'category_id' => $rumahtanggaId,
            ],
            [
                'name'        => 'Rinso Anti Noda 800g',
                'thumbnail'   => 'rinso-anti-noda.jpg',
                'about'       => 'Deterjen bubuk dengan formula anti noda yang ampuh menghilangkan noda membandel di pakaian.',
                'price'       => 18500,
                'stock'       => 60,
                'is_popular'  => false,
                'category_id' => $rumahtanggaId,
            ],
            [
                'name'        => 'Baygon Aerosol Lavender 600ml',
                'thumbnail'   => 'baygon-aerosol.jpg',
                'about'       => 'Pembasmi nyamuk dan serangga dengan wangi lavender yang menyegarkan. Perlindungan hingga 12 jam.',
                'price'       => 52000,
                'stock'       => 40,
                'is_popular'  => false,
                'category_id' => $rumahtanggaId,
            ],

            // === Perawatan Tubuh ===
            [
                'name'        => 'Lifebuoy Sabun Cair 500ml',
                'thumbnail'   => 'lifebuoy-sabun-cair.jpg',
                'about'       => 'Sabun mandi cair antibakteri yang melindungi dari kuman penyebab penyakit. Wangi segar tahan lama.',
                'price'       => 28000,
                'stock'       => 55,
                'is_popular'  => true,
                'category_id' => $perawatanId,
            ],
            [
                'name'        => 'Pepsodent Pasta Gigi 190g',
                'thumbnail'   => 'pepsodent-190g.jpg',
                'about'       => 'Pasta gigi dengan perlindungan gigi berlubang dan gusi sehat. Mengandung fluoride dan kalsium aktif.',
                'price'       => 15000,
                'stock'       => 90,
                'is_popular'  => true,
                'category_id' => $perawatanId,
            ],
            [
                'name'        => 'Pantene Shampoo 160ml',
                'thumbnail'   => 'pantene-shampoo.jpg',
                'about'       => 'Shampoo anti rontok dengan Pro-V formula yang menutrisi rambut dari akar hingga ujung.',
                'price'       => 24500,
                'stock'       => 65,
                'is_popular'  => false,
                'category_id' => $perawatanId,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
