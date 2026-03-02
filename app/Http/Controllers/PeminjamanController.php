<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\User;
use App\Models\ActivityLog;
use App\Services\LoanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    protected $loanService;

    public function __construct(LoanService $loanService)
    {
        $this->loanService = $loanService;
    }

    private function logActivity($action, $description, $metadata = [])
    {
        ActivityLog::create([
            'user_id'     => auth()->id(),
            'action'      => $action,
            'description' => $description,
            'metadata'    => $metadata,
            'ip_address'  => request()->ip(),
        ]);
    }

    public function index(Request $request)
    {
        $user   = auth()->user();
        $status = $request->query('status');

        $query = Peminjaman::with(['user', 'details.alat']);

        if ($user->role === 'peminjam') {
            $query->where('user_id', $user->id);
        }

        if ($status === 'menunggu') {
            $query->where('status', 'menunggu');
        } elseif ($status === 'aktif') {
            $query->where('status', 'disetujui');
        }

        $peminjamans = $query->latest()->get();

        return view('peminjamans.index', compact('peminjamans', 'status'));
    }

    public function create()
    {
        $users = User::all();
        return view('peminjamans.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'          => 'required|exists:users,id',
            'tanggal_pinjam'   => 'required|date',
            'tanggal_kembali'  => 'required|date|after_or_equal:tanggal_pinjam',
            'items'            => 'required|array|min:1',
            'items.*.alat_id'  => 'required|exists:alats,id',
            'items.*.jumlah'   => 'required|integer|min:1',
        ]);

        return DB::transaction(function () use ($validated) {
            $peminjaman = Peminjaman::create([
                'user_id'         => $validated['user_id'],
                'tanggal_pinjam'  => $validated['tanggal_pinjam'],
                'tanggal_kembali' => $validated['tanggal_kembali'],
                'status'          => 'menunggu',
            ]);

            foreach ($validated['items'] as $item) {
                $peminjaman->details()->create([
                    'alat_id' => $item['alat_id'],
                    'jumlah'  => $item['jumlah'],
                ]);
            }

            $this->logActivity('create_peminjaman', "Mengajukan peminjaman baru ID #{$peminjaman->id}", [
                'peminjaman_id' => $peminjaman->id, 'user_id' => $peminjaman->user_id,
            ]);

            $route = auth()->user()->role === 'peminjam'
                ? route('peminjam.peminjamans.show', $peminjaman)
                : route('peminjamans.show', $peminjaman);

            return redirect($route)->with('success', 'Permintaan peminjaman berhasil diajukan.');
        });
    }

    public function approve(Peminjaman $peminjaman)
    {
        try {
            $this->loanService->approveLoan($peminjaman);
            return back()->with('success', 'Peminjaman disetujui dan stok telah diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function reject(Peminjaman $peminjaman)
    {
        $peminjaman->update(['status' => 'ditolak']);

        $this->logActivity('reject_peminjaman', "Menolak peminjaman ID #{$peminjaman->id}", [
            'peminjaman_id' => $peminjaman->id,
        ]);

        return back()->with('success', 'Peminjaman telah ditolak.');
    }

    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['user', 'details.alat']);
        return view('peminjamans.show', compact('peminjaman'));
    }

    public function edit(Peminjaman $peminjaman)
    {
        $users = User::all();
        return view('peminjamans.edit', compact('peminjaman', 'users'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $validated = $request->validate([
            'user_id'         => 'required|exists:users,id',
            'tanggal_pinjam'  => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'status'          => 'required|in:menunggu,disetujui,ditolak,dikembalikan',
        ]);

        $peminjaman->update($validated);

        $this->logActivity('update_peminjaman', "Admin memperbarui peminjaman ID #{$peminjaman->id} → status: {$validated['status']}", [
            'peminjaman_id' => $peminjaman->id, 'status' => $validated['status'],
        ]);

        return redirect()->route('peminjamans.index')->with('success', 'Peminjaman berhasil diperbarui.');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        $id = $peminjaman->id;
        $peminjaman->delete();

        $this->logActivity('delete_peminjaman', "Menghapus peminjaman ID #{$id}", [
            'peminjaman_id' => $id,
        ]);

        return redirect()->route('peminjamans.index')->with('success', 'Peminjaman berhasil dihapus.');
    }
}
