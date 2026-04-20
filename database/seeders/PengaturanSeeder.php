<?php

namespace Database\Seeders;

use App\Models\Pengaturan;
use Illuminate\Database\Seeder;

class PengaturanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pengaturan::firstOrCreate(
            ['nama_perusahaan' => 'Toko Konveksi Jaya'],
            [
                'alamat_1' => 'Jl. Melati No. 12',
                'alamat_2' => 'Bandung, Jawa Barat',
                'logo' => 'default-logo.png',
                'logo_bank' => 'default-bank.png',
            ]
        );
    }
}
