<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alat;
use App\Models\Kategori;

class AlatSeeder extends Seeder
{
    public function run(): void
    {
        $k_pr_komputer = Kategori::where('nama_kategori', 'Perangkat Komputer')->first()->id;
        $k_ph_komputer = Kategori::where('nama_kategori', 'Peripheral Komputer')->first()->id;
        $k_audio_vis = Kategori::where('nama_kategori', 'Audio Visual & Proyeksi')->first()->id;
        $k_kabel = Kategori::where('nama_kategori', 'Kabel & Koneksi')->first()->id;
        $k_jaringan = Kategori::where('nama_kategori', 'Jaringan (Networking)')->first()->id;
        $k_perkakas = Kategori::where('nama_kategori', 'Perkakas Teknisi')->first()->id;

        $alats = [
            // Audio Visual & Proyeksi
            ['nama_alat' => 'Proyektor Epson EB-X500', 'kategori_id' => $k_audio_vis, 'stok' => 5, 'kondisi' => 'baik'],
            ['nama_alat' => 'Proyektor BenQ MX560', 'kategori_id' => $k_audio_vis, 'stok' => 3, 'kondisi' => 'baik'],
            ['nama_alat' => 'Layar Proyektor Tripod 70 inch', 'kategori_id' => $k_audio_vis, 'stok' => 4, 'kondisi' => 'baik'],
            ['nama_alat' => 'Kamera DSLR Canon EOS 250D', 'kategori_id' => $k_audio_vis, 'stok' => 2, 'kondisi' => 'baik'],
            ['nama_alat' => 'Microphone Wireless Shure', 'kategori_id' => $k_audio_vis, 'stok' => 4, 'kondisi' => 'baik'],

            // Kabel & Koneksi
            ['nama_alat' => 'Kabel Roll/Oloran 10 Meter', 'kategori_id' => $k_kabel, 'stok' => 15, 'kondisi' => 'baik'],
            ['nama_alat' => 'Kabel Roll/Oloran 5 Meter', 'kategori_id' => $k_kabel, 'stok' => 10, 'kondisi' => 'baik'],
            ['nama_alat' => 'Kabel HDMI 3 Meter', 'kategori_id' => $k_kabel, 'stok' => 20, 'kondisi' => 'baik'],
            ['nama_alat' => 'Kabel VGA 3 Meter', 'kategori_id' => $k_kabel, 'stok' => 10, 'kondisi' => 'baik'],
            ['nama_alat' => 'Kabel UTP LAN Cat6 10 Meter', 'kategori_id' => $k_kabel, 'stok' => 10, 'kondisi' => 'baik'],
            
            // Perangkat Komputer
            ['nama_alat' => 'Laptop Asus Vivobook 14', 'kategori_id' => $k_pr_komputer, 'stok' => 3, 'kondisi' => 'baik'],
            ['nama_alat' => 'Laptop Lenovo Thinkpad T480', 'kategori_id' => $k_pr_komputer, 'stok' => 2, 'kondisi' => 'baik'],

            // Peripheral Komputer
            ['nama_alat' => 'Mouse Wireless Logitech M170', 'kategori_id' => $k_ph_komputer, 'stok' => 15, 'kondisi' => 'baik'],
            ['nama_alat' => 'Keyboard USB M-Tech', 'kategori_id' => $k_ph_komputer, 'stok' => 10, 'kondisi' => 'baik'],
            ['nama_alat' => 'Flashdisk Sandisk 32GB', 'kategori_id' => $k_ph_komputer, 'stok' => 5, 'kondisi' => 'baik'],

            // Jaringan
            ['nama_alat' => 'Router Mikrotik RB951Ui-2HnD', 'kategori_id' => $k_jaringan, 'stok' => 8, 'kondisi' => 'baik'],
            ['nama_alat' => 'Switch Hub TP-Link 16 Port', 'kategori_id' => $k_jaringan, 'stok' => 4, 'kondisi' => 'baik'],
            ['nama_alat' => 'Tang Crimping RJ45', 'kategori_id' => $k_jaringan, 'stok' => 5, 'kondisi' => 'baik'],
            ['nama_alat' => 'LAN Tester', 'kategori_id' => $k_jaringan, 'stok' => 4, 'kondisi' => 'baik'],

            // Perkakas
            ['nama_alat' => 'Multitester Digital Dekko', 'kategori_id' => $k_perkakas, 'stok' => 3, 'kondisi' => 'baik'],
            ['nama_alat' => 'Obeng Set Komputer (+/-)', 'kategori_id' => $k_perkakas, 'stok' => 4, 'kondisi' => 'baik'],
        ];

        foreach ($alats as $a) {
            Alat::create($a);
        }
    }
}
