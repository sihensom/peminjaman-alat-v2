<x-app-layout>
    <x-slot name="header">
        Kelola Kategori Alat
    </x-slot>

    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h3 class="text-xl font-bold text-foreground">Daftar Kategori</h3>
            <a href="{{ route('kategoris.create') }}" class="btn-primary">
                + Kategori Baru
            </a>
        </div>

        <div class="card-premium overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-muted/50 text-muted-foreground uppercase text-xs font-semibold">
                        <tr>
                            <th class="px-6 py-4">Nama Kategori</th>
                            <th class="px-6 py-4">Deskripsi</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse($kategoris as $k)
                            <tr class="hover:bg-muted/30 transition-colors">
                                <td class="px-6 py-4 font-bold text-foreground">{{ $k->nama_kategori }}</td>
                                <td class="px-6 py-4 text-muted-foreground">{{ $k->deskripsi ?? '-' }}</td>
                                <td class="px-6 py-4 text-right space-x-3">
                                    <a href="{{ route('kategoris.edit', $k) }}" class="text-indigo-600 dark:text-indigo-400 font-semibold hover:underline">Edit</a>
                                    <form method="POST" action="{{ route('kategoris.destroy', $k) }}" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Hapus kategori {{ $k->nama_kategori }}?')" class="text-destructive font-semibold hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-10 text-center text-muted-foreground italic">
                                    Belum ada kategori. Klik "+ Kategori Baru" untuk menambahkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ======== FORCE DELETE WARNING MODAL ======== --}}
    @if(session('delete_warning'))
    @php $warn = session('delete_warning'); @endphp
    <div id="force-delete-modal" class="fixed inset-0 z-[100] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="document.getElementById('force-delete-modal').remove()"></div>
        <div class="relative bg-white dark:bg-slate-900 rounded-3xl shadow-2xl max-w-md w-full overflow-hidden animate-[slideIn_0.3s_ease-out]">
            <div class="h-1.5 bg-gradient-to-r from-red-500 to-orange-500"></div>
            <div class="p-8 text-center">
                <div class="mx-auto h-16 w-16 bg-red-500/10 rounded-full flex items-center justify-center mb-4">
                    <svg class="h-8 w-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-black text-foreground mb-2">Tidak Dapat Menghapus</h3>
                <p class="text-sm text-muted-foreground leading-relaxed mb-1">
                    Kategori <strong class="text-foreground">"{{ $warn['nama'] }}"</strong> masih memiliki
                    <strong class="text-red-600">{{ $warn['count'] }} alat</strong> yang terdaftar.
                </p>
                <p class="text-xs text-muted-foreground mb-6">
                    Jika Anda tetap menghapus, semua alat beserta data peminjaman terkait juga akan dihapus secara permanen.
                </p>
                <div class="flex gap-3 justify-center">
                    <button onclick="document.getElementById('force-delete-modal').remove()" class="px-5 py-2.5 bg-muted hover:bg-border text-foreground rounded-xl text-xs font-black uppercase tracking-widest transition-all">
                        Batalkan
                    </button>
                    <form method="POST" action="{{ route('kategoris.destroy', $warn['id']) }}">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="force" value="1">
                        <button type="submit" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl text-xs font-black uppercase tracking-widest shadow-lg shadow-red-500/20 hover:shadow-red-500/40 transition-all">
                            Ya, Hapus Paksa
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
</x-app-layout>
