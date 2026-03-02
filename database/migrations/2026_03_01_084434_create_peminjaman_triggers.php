<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Trigger untuk mengurangi stok alat saat peminjaman disetujui
        // Perhatian: Logic sesungguhnya mungkin berbeda tergantung pada flow aplikasi.
        // Asumsi: Kita mengurangi stok ketika 'status' peminjaman diupdate menjadi 'disetujui'
        DB::unprepared('
            CREATE TRIGGER tg_kurangi_stok 
            AFTER UPDATE ON peminjamans
            FOR EACH ROW
            BEGIN
                IF NEW.status = "disetujui" AND OLD.status != "disetujui" THEN
                    UPDATE alats 
                    INNER JOIN detail_peminjamans ON alats.id = detail_peminjamans.alat_id
                    SET alats.stok = alats.stok - detail_peminjamans.jumlah
                    WHERE detail_peminjamans.peminjaman_id = NEW.id;
                END IF;
            END
        ');

        // Trigger untuk menambah stok alat saat dikembalikan (insert ke tabel pengembalians)
        DB::unprepared('
            CREATE TRIGGER tg_tambah_stok 
            AFTER INSERT ON pengembalians
            FOR EACH ROW
            BEGIN
                UPDATE alats
                INNER JOIN detail_peminjamans ON alats.id = detail_peminjamans.alat_id
                SET alats.stok = alats.stok + detail_peminjamans.jumlah
                WHERE detail_peminjamans.peminjaman_id = NEW.peminjaman_id;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS tg_kurangi_stok');
        DB::unprepared('DROP TRIGGER IF EXISTS tg_tambah_stok');
    }
};
