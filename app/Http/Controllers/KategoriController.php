<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class KategoriController extends Controller
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
        $kategoris = Kategori::all();
        return view('kategoris.index', compact('kategoris'));
    }

    public function create()
    {
        return view('kategoris.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori',
            'deskripsi'     => 'nullable|string',
        ]);

        $kategori = Kategori::create($validated);

        $this->logActivity('create_kategori', "Menambahkan kategori baru: {$kategori->nama_kategori}", [
            'kategori_id' => $kategori->id, 'nama_kategori' => $kategori->nama_kategori,
        ]);

        return redirect()->route('kategoris.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show(Kategori $kategori)
    {
        return view('kategoris.show', compact('kategori'));
    }

    public function edit(Kategori $kategori)
    {
        return view('kategoris.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori,' . $kategori->id,
            'deskripsi'     => 'nullable|string',
        ]);

        $kategori->update($validated);

        $this->logActivity('update_kategori', "Memperbarui kategori: {$kategori->nama_kategori}", [
            'kategori_id' => $kategori->id, 'nama_kategori' => $kategori->nama_kategori,
        ]);

        return redirect()->route('kategoris.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Request $request, Kategori $kategori)
    {
        $alatCount = $kategori->alats()->count();

        if ($alatCount > 0 && !$request->boolean('force')) {
            return redirect()->route('kategoris.index')
                ->with('delete_warning', [
                    'id'    => $kategori->id,
                    'nama'  => $kategori->nama_kategori,
                    'count' => $alatCount,
                ]);
        }

        if ($alatCount > 0) {
            // Hapus detail_peminjaman yang terkait alat di kategori ini dulu
            foreach ($kategori->alats as $alat) {
                $alat->details()->delete();
            }
            $kategori->alats()->delete();
        }

        $nama = $kategori->nama_kategori;
        $id   = $kategori->id;
        $kategori->delete();

        $this->logActivity('delete_kategori', "Menghapus kategori: {$nama}" . ($alatCount > 0 ? " (paksa, {$alatCount} alat ikut dihapus)" : ''), [
            'kategori_id' => $id, 'nama_kategori' => $nama,
        ]);

        return redirect()->route('kategoris.index')->with('success', "Kategori \"{$nama}\" berhasil dihapus.");
    }
}
