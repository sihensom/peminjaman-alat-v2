<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            ['nama_kategori' => 'Perangkat Komputer', 'deskripsi' => 'Perangkat utama seperti Laptop, PC Desktop, Server.'],
            ['nama_kategori' => 'Peripheral Komputer', 'deskripsi' => 'Alat input/output pendukung seperti Keyboard, Mouse, Flashdisk, Harddisk Eksternal.'],
            ['nama_kategori' => 'Audio Visual & Proyeksi', 'deskripsi' => 'Proyektor/LCD, Layar Proyektor, Kamera, Mikrofon, Speaker.'],
            ['nama_kategori' => 'Kabel & Koneksi', 'deskripsi' => 'Berbagai macam kabel: Kabel Oloran/Rol, HDMI, VGA, Power, UTP, Audio.'],
            ['nama_kategori' => 'Jaringan (Networking)', 'deskripsi' => 'Router, Switch Hub, Tang Crimping, LAN Tester, Access Point.'],
            ['nama_kategori' => 'Perkakas Teknisi', 'deskripsi' => 'Obeng set, Solder, Blower, Multitester.'],
        ];

        foreach ($kategoris as $k) {
            Kategori::create($k);
        }
    }
}
