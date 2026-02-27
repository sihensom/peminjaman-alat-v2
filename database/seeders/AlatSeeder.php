<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alat;
use App\Models\Kategori;

class AlatSeeder extends Seeder
{
    public function run(): void
    {
        $elektronik = Kategori::where('nama_kategori', 'Elektronik')->first();
        $perkakas = Kategori::where('nama_kategori', 'Perkakas')->first();
        $audio = Kategori::where('nama_kategori', 'Audio Visual')->first();

        $alats = [
            [
                'nama_alat' => 'Kamera Canon EOS R6',
                'kategori_id' => $elektronik->id,
                'stok' => 5,
                'kondisi' => 'baik',
            ],
            [
                'nama_alat' => 'Proyektor Epson EB-X400',
                'kategori_id' => $elektronik->id,
                'stok' => 3,
                'kondisi' => 'baik',
            ],
            [
                'nama_alat' => 'Bor Listrik Makita',
                'kategori_id' => $perkakas->id,
                'stok' => 10,
                'kondisi' => 'baik',
            ],
            [
                'nama_alat' => 'Mic Wireless Sennheiser',
                'kategori_id' => $audio->id,
                'stok' => 8,
                'kondisi' => 'baik',
            ],
            [
                'nama_alat' => 'Laptop ROG Zephyrus',
                'kategori_id' => $elektronik->id,
                'stok' => 2,
                'kondisi' => 'baik',
            ],
        ];

        foreach ($alats as $a) {
            Alat::create($a);
        }
    }
}
