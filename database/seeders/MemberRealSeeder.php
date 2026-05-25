<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Membership;
use App\Models\MemberPoint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;

class MemberRealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = base_path('data_real/Member SRC WULAN.xlsx');

        if (!file_exists($filePath)) {
            $this->command->error("File Member SRC WULAN.xlsx tidak ditemukan di folder data_real!");
            return;
        }

        $this->command->info("Memuat data member dari Excel...");

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

            $kdPelanggan = trim($row['A'] ?? '');
            $namaPelanggan = trim($row['B'] ?? '');
            $alamat = trim($row['C'] ?? '');
            $telp = trim($row['D'] ?? '');
            $piutang = intval($row['E'] ?? 0);
            $point = intval($row['F'] ?? 0);
            $tglLahir = trim($row['G'] ?? '');

            if (empty($namaPelanggan)) {
                continue;
            }

            // Generasi email unik
            $slug = strtolower(preg_replace('/[^a-zA-Z0-9.]+/', '', str_replace(' ', '.', $namaPelanggan)));
            if (empty($slug)) {
                $slug = 'member.' . Str::random(4);
            }
            $email = $slug . '@srcwulan.com';

            // Jamin keunikan email
            $originalEmail = $email;
            $counter = 1;
            while (Customer::where('email', $email)->exists()) {
                $email = $slug . $counter . '@srcwulan.com';
                $counter++;
            }

            // Buat Customer Baru
            $customer = Customer::create([
                'name' => $namaPelanggan,
                'email' => $email,
                'password' => 'member123',
                'phone' => !empty($telp) ? $telp : '08' . mt_rand(10000000, 99999999),
                'gender' => mt_rand(0, 1) ? 'laki-laki' : 'perempuan',
                'birth_date' => !empty($tglLahir) ? $tglLahir : now()->subYears(25)->format('Y-m-d'),
                'profile_completed' => true,
            ]);

            // Buat Membership (member_points table) dengan status active dan placeholder KTP
            $membership = Membership::create([
                'user_id' => $customer->id,
                'status' => 'active',
                'ktp_photo' => 'ktp-photos/imported_member.webp',
            ]);

            // Jika ada saldo point awal di Excel, tambahkan ke riwayat poin (memberships table)
            if ($point > 0) {
                MemberPoint::create([
                    'user_id' => $customer->id,
                    'points' => $point,
                    'type' => 'earned',
                    'expired_at' => now()->addYear(),
                ]);
            }

            $insertedCount++;
        }

        $this->command->info("Sukses memigrasikan {$insertedCount} data member dari Excel ke database!");
    }
}
