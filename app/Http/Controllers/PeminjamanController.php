<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\User;
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

    public function index()
    {
        $peminjamans = Peminjaman::with(['user', 'details.alat'])->latest()->get();
        return view('peminjamans.index', compact('peminjamans'));
    }

    public function create()
    {
        $users = User::all();
        return view('peminjamans.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'items' => 'required|array|min:1',
            'items.*.alat_id' => 'required|exists:alats,id',
            'items.*.jumlah' => 'required|integer|min:1',
        ]);

        return \DB::transaction(function () use ($validated) {
            $peminjaman = Peminjaman::create([
                'user_id' => $validated['user_id'],
                'tanggal_pinjam' => $validated['tanggal_pinjam'],
                'tanggal_kembali' => $validated['tanggal_kembali'],
                'status' => 'menunggu',
            ]);

            foreach ($validated['items'] as $item) {
                $peminjaman->details()->create([
                    'alat_id' => $item['alat_id'],
                    'jumlah' => $item['jumlah'],
                ]);
            }

            return redirect()->route('peminjamans.show', $peminjaman)->with('success', 'Permintaan peminjaman berhasil diajukan.');
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
            'user_id' => 'required|exists:users,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'status' => 'required|in:menunggu,disetujui,ditolak,dikembalikan',
        ]);

        $peminjaman->update($validated);

        return redirect()->route('peminjamans.index')->with('success', 'Peminjaman berhasil diperbarui.');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        $peminjaman->delete();
        return redirect()->route('peminjamans.index')->with('success', 'Peminjaman berhasil dihapus.');
    }
}
