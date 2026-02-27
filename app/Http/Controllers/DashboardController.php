<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $stats = [];

        if ($user->role === 'admin') {
            $stats = [
                'total_users' => User::count(),
                'total_alats' => Alat::count(),
                'pending_loans' => Peminjaman::where('status', 'menunggu')->count(),
                'active_loans' => Peminjaman::where('status', 'disetujui')->count(),
                'total_fines' => \App\Models\Pengembalian::sum('denda'),
                'recent_logs' => ActivityLog::with('user')->latest()->take(5)->get(),
                'pending_items' => Peminjaman::with('user', 'details.alat')->where('status', 'menunggu')->latest()->take(3)->get(),
            ];
        } elseif ($user->role === 'petugas') {
            $stats = [
                'pending_loans' => Peminjaman::where('status', 'menunggu')->count(),
                'active_loans' => Peminjaman::where('status', 'disetujui')->count(),
                'total_alats' => Alat::count(),
                'pending_items' => Peminjaman::with('user', 'details.alat')->where('status', 'menunggu')->latest()->take(5)->get(),
            ];
        } else {
            $stats = [
                'my_loans' => Peminjaman::where('user_id', $user->id)->count(),
                'my_pending' => Peminjaman::where('user_id', $user->id)->where('status', 'menunggu')->count(),
                'active_items' => Peminjaman::with('details.alat')->where('user_id', $user->id)->where('status', 'disetujui')->latest()->take(3)->get(),
            ];
        }

        return view('dashboard', compact('stats'));
    }
}
