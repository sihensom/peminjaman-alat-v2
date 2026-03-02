<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alat;
use App\Models\Kategori;
use App\Models\ActivityLog;

class AlatController extends Controller
{
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
        $alats = Alat::with('kategori')->get();
        return view('alats.index', compact('alats'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('alats.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_alat'   => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'stok'        => 'required|integer|min:0',
            'kondisi'     => 'nullable|string',
        ]);

        $alat = Alat::create($validated);

        $this->logActivity('create_alat', "Menambahkan alat baru: {$alat->nama_alat}", [
            'alat_id' => $alat->id, 'nama_alat' => $alat->nama_alat, 'stok' => $alat->stok,
        ]);

        return redirect()->route('alats.index')->with('success', 'Alat berhasil ditambahkan.');
    }

    public function show(Alat $alat)
    {
        return view('alats.show', compact('alat'));
    }

    public function edit(Alat $alat)
    {
        $kategoris = Kategori::all();
        return view('alats.edit', compact('alat', 'kategoris'));
    }

    public function update(Request $request, Alat $alat)
    {
        $validated = $request->validate([
            'nama_alat'   => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'stok'        => 'required|integer|min:0',
            'kondisi'     => 'nullable|string',
        ]);

        $alat->update($validated);

        $this->logActivity('update_alat', "Memperbarui alat: {$alat->nama_alat}", [
            'alat_id' => $alat->id, 'nama_alat' => $alat->nama_alat,
        ]);

        return redirect()->route('alats.index')->with('success', 'Alat berhasil diperbarui.');
    }

    public function destroy(Alat $alat)
    {
        // Cek apakah alat masih digunakan di data peminjaman
        if ($alat->details()->count() > 0) {
            return redirect()->route('alats.index')
                ->with('error', "Alat \"{$alat->nama_alat}\" tidak dapat dihapus karena masih terdapat data peminjaman yang menggunakan alat ini.");
        }

        $nama = $alat->nama_alat;
        $id   = $alat->id;
        $alat->delete();

        $this->logActivity('delete_alat', "Menghapus alat: {$nama}", [
            'alat_id' => $id, 'nama_alat' => $nama,
        ]);

        return redirect()->route('alats.index')->with('success', 'Alat berhasil dihapus.');
    }
}
