<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\ActivityLog;
use App\Services\LoanService;
use Illuminate\Http\Request;

class PengembalianController extends Controller
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

    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'peminjam') {
            $pengembalians = Pengembalian::with('peminjaman.user')
                ->whereHas('peminjaman', fn($q) => $q->where('user_id', $user->id))
                ->latest()->get();
        } else {
            $pengembalians = Pengembalian::with('peminjaman.user')->latest()->get();
        }

        return view('pengembalians.index', compact('pengembalians'));
    }

    public function create()
    {
        $peminjamans = Peminjaman::with('user')->where('status', 'disetujui')->get();
        return view('pengembalians.create', compact('peminjamans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'peminjaman_id'         => 'required|exists:peminjamans,id',
            'tanggal_dikembalikan'  => 'required|date',
        ]);

        try {
            $peminjaman = Peminjaman::findOrFail($validated['peminjaman_id']);
            $fine       = $this->loanService->processReturn($peminjaman, $validated['tanggal_dikembalikan']);

            $msg = 'Pengembalian berhasil diproses.';
            if ($fine > 0) {
                $msg .= " Denda sebesar Rp " . number_format($fine, 0, ',', '.') . " telah dicatat.";
            }

            $this->logActivity('create_pengembalian', "Memproses pengembalian untuk peminjaman ID #{$peminjaman->id}", [
                'peminjaman_id' => $peminjaman->id, 'denda' => $fine,
            ]);

            $redirectRoute = auth()->user()->role === 'petugas'
                ? 'petugas.pengembalians.index'
                : 'pengembalians.index';

            return redirect()->route($redirectRoute)->with('success', $msg);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Pengembalian $pengembalian)
    {
        return view('pengembalians.show', compact('pengembalian'));
    }

    public function edit(Pengembalian $pengembalian)
    {
        $peminjamans = Peminjaman::with('user')->get();
        return view('pengembalians.edit', compact('pengembalian', 'peminjamans'));
    }

    public function update(Request $request, Pengembalian $pengembalian)
    {
        $validated = $request->validate([
            'peminjaman_id'        => 'required|exists:peminjamans,id',
            'tanggal_dikembalikan' => 'required|date',
            'denda'                => 'nullable|numeric|min:0',
        ]);

        $pengembalian->update($validated);

        $this->logActivity('update_pengembalian', "Admin memperbarui pengembalian ID #{$pengembalian->id}", [
            'pengembalian_id' => $pengembalian->id,
            'peminjaman_id'   => $validated['peminjaman_id'],
            'denda'           => $validated['denda'] ?? 0,
        ]);

        return redirect()->route('pengembalians.index')->with('success', 'Pengembalian berhasil diperbarui.');
    }

    public function destroy(Pengembalian $pengembalian)
    {
        $id = $pengembalian->id;
        $pengembalian->delete();

        $this->logActivity('delete_pengembalian', "Menghapus data pengembalian ID #{$id}", [
            'pengembalian_id' => $id,
        ]);

        return redirect()->route('pengembalians.index')->with('success', 'Pengembalian berhasil dihapus.');
    }
}
