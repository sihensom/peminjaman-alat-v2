<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function monthly(Request $request)
    {
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));

        $peminjamans = Peminjaman::with(['user', 'details.alat'])
            ->whereMonth('tanggal_pinjam', $month)
            ->whereYear('tanggal_pinjam', $year)
            ->get();

        $pengembalians = Pengembalian::with('peminjaman.user')
            ->whereMonth('tanggal_dikembalikan', $month)
            ->whereYear('tanggal_dikembalikan', $year)
            ->get();

        $totalFines = $pengembalians->sum('denda');

        return view('reports.monthly', compact('peminjamans', 'pengembalians', 'totalFines', 'month', 'year'));
    }

    public function audit()
    {
        $logs = ActivityLog::with('user')->latest()->paginate(20);
        return view('reports.audit', compact('logs'));
    }

    public function printMonthly(Request $request)
    {
        // Logic for print view (simplified for now, using the same view but with print layout)
        return $this->monthly($request)->with('isPrint', true);
    }
}
