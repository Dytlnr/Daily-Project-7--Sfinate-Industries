<?php

namespace Database\Seeders;

use App\Models\Pengaturan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PengaturanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaults = [
            ['key' => 'nama_perusahaan', 'value' => 'Toko Konveksi Jaya'],
            ['key' => 'alamat_1', 'value' => 'Jl. Melati No. 12'],
            ['key' => 'alamat_2', 'value' => 'Bandung, Jawa Barat'],
            ['key' => 'logo', 'value' => 'storage/logo/default-logo.png'],
            ['key' => 'logo_bank', 'value' => 'storage/logo/default-bank.png'],
        ];

        foreach ($defaults as $item) {
            Pengaturan::firstOrCreate(['key' => $item['key']], ['value' => $item['value']]);
        }
    }
}
