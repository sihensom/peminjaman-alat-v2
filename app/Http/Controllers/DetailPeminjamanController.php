<?php

namespace App\Http\Controllers;

use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use App\Models\Alat;
use Illuminate\Http\Request;

class DetailPeminjamanController extends Controller
{
    public function index()
    {
        $details = DetailPeminjaman::with(['peminjaman', 'alat'])->get();
        return view('detail_peminjamans.index', compact('details'));
    }

    public function create()
    {
        $peminjamans = Peminjaman::all();
        $alats = Alat::where('stok', '>', 0)->get();
        return view('detail_peminjamans.create', compact('peminjamans', 'alats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'peminjaman_id' => 'required|exists:peminjamans,id',
            'alat_id' => 'required|exists:alats,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        DetailPeminjaman::create($validated);

        return redirect()->route('detail-peminjamans.index')->with('success', 'Detail peminjaman berhasil ditambahkan.');
    }

    public function show(DetailPeminjaman $detailPeminjaman)
    {
        return view('detail_peminjamans.show', compact('detailPeminjaman'));
    }

    public function edit(DetailPeminjaman $detailPeminjaman)
    {
        $peminjamans = Peminjaman::all();
        $alats = Alat::all();
        return view('detail_peminjamans.edit', compact('detailPeminjaman', 'peminjamans', 'alats'));
    }

    public function update(Request $request, DetailPeminjaman $detailPeminjaman)
    {
        $validated = $request->validate([
            'peminjaman_id' => 'required|exists:peminjamans,id',
            'alat_id' => 'required|exists:alats,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $detailPeminjaman->update($validated);

        return redirect()->route('detail-peminjamans.index')->with('success', 'Detail peminjaman berhasil diperbarui.');
    }

    public function destroy(DetailPeminjaman $detailPeminjaman)
    {
        $detailPeminjaman->delete();
        return redirect()->route('detail-peminjamans.index')->with('success', 'Detail peminjaman berhasil dihapus.');
    }
}
