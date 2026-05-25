<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ProductRealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = base_path('data_real/Produk SRC WULAN.xlsx');

        if (!file_exists($filePath)) {
            $this->command->error("File Produk SRC WULAN.xlsx tidak ditemukan di folder data_real!");
            return;
        }

        $this->command->info("Memuat data produk dari Excel (ini mungkin memakan waktu beberapa detik karena ribuan data)...");

        $reader = IOFactory::createReaderForFile($filePath);
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);

        $insertedCount = 0;

        foreach ($rows as $index => $row) {
            // Lewati header pada baris ke-1
            if ($index === 1) {
                continue;
            }

            $barcode = trim($row['A'] ?? '');
            $kdProduk = trim($row['B'] ?? '');
            $namaProduk = trim($row['C'] ?? '');
            $satuan = trim($row['D'] ?? '');
            $konversi = trim($row['E'] ?? '');
            $kategoriName = trim($row['F'] ?? '');
            $hpp = intval($row['G'] ?? 0);
            $hargaJualUmum = intval($row['H'] ?? 0);
            $hargaJualMember = intval($row['I'] ?? 0);
            $hargaJualGrosir = intval($row['J'] ?? 0);
            $hargaJualGrosirMember = intval($row['K'] ?? 0);
            $supplier = trim($row['L'] ?? '');

            if (empty($namaProduk)) {
                continue;
            }

            // Cari atau buat kategori berdasarkan nama dari Excel secara dinamis
            if (empty($kategoriName)) {
                $kategoriName = 'Lain-Lain';
            }

            $categorySlug = Str::slug($kategoriName);
            $category = Category::where('slug', $categorySlug)->first();

            if (!$category) {
                $category = Category::create([
                    'name' => Str::title($kategoriName),
                    'slug' => $categorySlug,
                    'icon' => 'icon-default.png'
                ]);
            }

            // Generasi slug produk unik untuk menghindari duplikasi
            $slug = Str::slug($namaProduk);
            $originalSlug = $slug;
            $counter = 1;
            while (Product::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            // Gunakan harga jual umum, jika kosong set default Rp 1.000
            $price = $hargaJualUmum > 0 ? $hargaJualUmum : 1000;

            // Buat produk di database
            Product::create([
                'name' => $namaProduk,
                'slug' => $slug,
                'thumbnail' => 'product_default.png',
                'about' => "Produk {$namaProduk} berkualitas tinggi dengan satuan kemasan {$satuan}.",
                'price' => $price,
                'stock' => mt_rand(50, 150), // Set stok acak realistis
                'is_popular' => false,
                'category_id' => $category->id,
            ]);

            $insertedCount++;
        }

        $this->command->info("Sukses memigrasikan {$insertedCount} data produk dari Excel ke database!");
    }
}
