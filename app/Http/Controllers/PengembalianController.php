<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Services\LoanService;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    protected $loanService;

    public function __construct(LoanService $loanService)
    {
        $this->loanService = $loanService;
    }

    public function index()
    {
        $pengembalians = Pengembalian::with('peminjaman.user')->latest()->get();
        return view('pengembalians.index', compact('pengembalians'));
    }

    public function create()
    {
        $peminjamans = Peminjaman::where('status', 'disetujui')->get();
        return view('pengembalians.create', compact('peminjamans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'peminjaman_id' => 'required|exists:peminjamans,id',
            'tanggal_dikembalikan' => 'required|date',
        ]);

        try {
            $peminjaman = Peminjaman::findOrFail($validated['peminjaman_id']);
            $fine = $this->loanService->processReturn($peminjaman, $validated['tanggal_dikembalikan']);
            
            $msg = 'Pengembalian berhasil diproses.';
            if ($fine > 0) {
                $msg .= " Denda sebesar Rp " . number_format($fine, 0, ',', '.') . " telah dicatat.";
            }

            return redirect()->route('pengembalians.index')->with('success', $msg);
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
        $peminjamans = Peminjaman::all();
        return view('pengembalians.edit', compact('pengembalian', 'peminjamans'));
    }

    public function update(Request $request, Pengembalian $pengembalian)
    {
        $validated = $request->validate([
            'peminjaman_id' => 'required|exists:peminjamans,id',
            'tanggal_dikembalikan' => 'required|date',
            'denda' => 'nullable|numeric|min:0',
        ]);

        $pengembalian->update($validated);

        return redirect()->route('pengembalians.index')->with('success', 'Pengembalian berhasil diperbarui.');
    }

    public function destroy(Pengembalian $pengembalian)
    {
        $pengembalian->delete();
        return redirect()->route('pengembalians.index')->with('success', 'Pengembalian berhasil dihapus.');
    }
}
