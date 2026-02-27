<?php

namespace App\Services;

use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\Alat;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LoanService
{
    /**
     * Approve a borrowing request and reduce stock.
     */
    public function approveLoan(Peminjaman $peminjaman)
    {
        return DB::transaction(function () use ($peminjaman) {
            if ($peminjaman->status !== 'menunggu') {
                throw new \Exception("Peminjaman bukan dalam status menunggu.");
            }

            foreach ($peminjaman->details as $detail) {
                $alat = $detail->alat;
                if ($alat->stok < $detail->jumlah) {
                    throw new \Exception("Stok alat '{$alat->nama_alat}' tidak mencukupi.");
                }
                $alat->decrement('stok', $detail->jumlah);
            }

            $peminjaman->update(['status' => 'disetujui']);

            $this->logActivity('approve_loan', "Menyetujui peminjaman ID #{$peminjaman->id}", [
                'peminjaman_id' => $peminjaman->id,
                'user_id' => $peminjaman->user_id
            ]);

            return $peminjaman;
        });
    }

    /**
     * Process a return and restore stock + calculate fines.
     */
    public function processReturn(Peminjaman $peminjaman, $tanggalDikembalikan)
    {
        return DB::transaction(function () use ($peminjaman, $tanggalDikembalikan) {
            if ($peminjaman->status !== 'disetujui') {
                throw new \Exception("Peminjaman harus disetujui sebelum dikembalikan.");
            }

            $tglKembali = Carbon::parse($peminjaman->tanggal_kembali);
            $tglDikembalikan = Carbon::parse($tanggalDikembalikan);
            $fine = 0;

            if ($tglDikembalikan->gt($tglKembali)) {
                $daysLate = $tglDikembalikan->diffInDays($tglKembali);
                $finePerDay = 5000; // Example fine: 5000 per day
                $fine = $daysLate * $finePerDay;
            }

            foreach ($peminjaman->details as $detail) {
                $detail->alat->increment('stok', $detail->jumlah);
            }

            $peminjaman->update(['status' => 'dikembalikan']);

            // Create pengembalian record
            $peminjaman->pengembalian()->create([
                'tanggal_dikembalikan' => $tanggalDikembalikan,
                'denda' => $fine
            ]);

            $this->logActivity('process_return', "Memproses pengembalian ID #{$peminjaman->id}", [
                'peminjaman_id' => $peminjaman->id,
                'fine' => $fine
            ]);

            return $fine;
        });
    }

    /**
     * Log activity to the database.
     */
    private function logActivity($action, $description, $metadata = [])
    {
        ActivityLog::create([
            'user_id' => \Auth::id(),
            'action' => $action,
            'description' => $description,
            'metadata' => $metadata,
            'ip_address' => request()->ip(),
        ]);
    }
}
