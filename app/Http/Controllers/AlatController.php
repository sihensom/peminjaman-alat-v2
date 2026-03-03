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

    public function destroy(Request $request, Alat $alat)
    {
        $detailCount = $alat->details()->count();

        if ($detailCount > 0 && !$request->boolean('force')) {
            // Ada relasi — redirect balik dengan info supaya modal force-delete muncul
            return redirect()->route('alats.index')
                ->with('delete_warning', [
                    'id'    => $alat->id,
                    'nama'  => $alat->nama_alat,
                    'count' => $detailCount,
                ]);
        }

        // Jika force delete — hapus detail peminjaman terkait dulu
        if ($detailCount > 0) {
            $alat->details()->delete();
        }

        $nama = $alat->nama_alat;
        $id   = $alat->id;
        $alat->delete();

        $this->logActivity('delete_alat', "Menghapus alat: {$nama}" . ($detailCount > 0 ? " (paksa, {$detailCount} detail peminjaman ikut dihapus)" : ''), [
            'alat_id' => $id, 'nama_alat' => $nama, 'force' => $detailCount > 0,
        ]);

        return redirect()->route('alats.index')->with('success', "Alat \"{$nama}\" berhasil dihapus.");
    }
}
