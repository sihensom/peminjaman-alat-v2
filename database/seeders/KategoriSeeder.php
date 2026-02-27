<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            ['nama_kategori' => 'Elektronik', 'deskripsi' => 'Alat-alat elektronik seperti kamera, proyektor, dll.'],
            ['nama_kategori' => 'Perkakas', 'deskripsi' => 'Alat pertukangan seperti bor, gergaji, dll.'],
            ['nama_kategori' => 'Audio Visual', 'deskripsi' => 'Peralatan pendukung audio dan visual.'],
            ['nama_kategori' => 'Olahraga', 'deskripsi' => 'Alat-alat olahraga.'],
        ];

        foreach ($kategoris as $k) {
            Kategori::create($k);
        }
    }
}
