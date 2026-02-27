<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-primary/10 rounded-lg">
                <svg class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-black text-foreground tracking-tight">Inventaris Alat</h2>
                <p class="text-xs text-muted-foreground font-medium">Kelola dan pantau ketersediaan perangkat</p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="relative w-full sm:w-64">
                <input type="text" placeholder="Cari alat..." class="w-full pl-10 pr-4 py-2 bg-slate-100 dark:bg-slate-800 border-none rounded-xl text-sm focus:ring-4 focus:ring-indigo-500/20 transition-all font-bold">
                <svg class="absolute left-3 top-2.5 h-4 w-4 text-muted-foreground" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            @if(Auth::user()->role !== 'peminjam')
                <a href="{{ route('alats.create') }}" class="btn-primary flex items-center gap-2 shadow-indigo-500/20 shadow-lg">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    Tambah Alat Baru
                </a>
            @endif
        </div>

        <div class="card-premium overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-muted/50 text-muted-foreground uppercase text-[10px] font-black tracking-widest">
                        <tr>
                            <th class="px-6 py-4">Informasi Alat</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4">Status & Stok</th>
                            <th class="px-6 py-4">Kondisi</th>
                            @if(Auth::user()->role !== 'peminjam')
                                <th class="px-6 py-4 text-right">Manajemen</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse($alats as $alat)
                            <tr class="hover:bg-muted/30 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-xl bg-muted flex items-center justify-center text-muted-foreground group-hover:bg-primary/10 group-hover:text-primary transition-colors">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                                        </div>
                                        <div>
                                            <div class="font-bold text-foreground">{{ $alat->nama_alat }}</div>
                                            <div class="text-[10px] text-muted-foreground font-mono uppercase">REF-{{ str_pad($alat->id, 4, '0', STR_PAD_LEFT) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-tight bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300">
                                        {{ $alat->kategori->nama_kategori }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="space-y-1.5">
                                        <div class="flex justify-between items-center text-[10px] font-bold">
                                            <span class="{{ $alat->stok > 0 ? 'text-green-600' : 'text-destructive' }}">
                                                {{ $alat->stok > 0 ? 'Tersedia' : 'Habis' }}
                                            </span>
                                            <span class="text-muted-foreground">{{ $alat->stok }} Unit</span>
                                        </div>
                                        <div class="w-24 bg-muted rounded-full h-1.5 overflow-hidden">
                                            <div class="h-full {{ $alat->stok > 3 ? 'bg-green-500' : ($alat->stok > 0 ? 'bg-amber-500' : 'bg-destructive') }}" style="width: {{ min(100, ($alat->stok / 10) * 100) }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-1.5">
                                        <div class="h-1.5 w-1.5 rounded-full {{ $alat->kondisi === 'baik' ? 'bg-green-500' : 'bg-amber-500' }}"></div>
                                        <span class="text-xs font-semibold capitalize">{{ $alat->kondisi }}</span>
                                    </div>
                                </td>
                                @if(Auth::user()->role !== 'peminjam')
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('alats.edit', $alat) }}" class="p-2 text-muted-foreground hover:text-primary hover:bg-primary/10 rounded-lg transition-all" title="Edit Alat">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                            </a>
                                            <form method="POST" action="{{ route('alats.destroy', $alat) }}" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Hapus alat ini?')" class="p-2 text-muted-foreground hover:text-destructive hover:bg-destructive/10 rounded-lg transition-all" title="Hapus Alat">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-20 text-center">
                                    <div class="mx-auto w-16 h-16 bg-muted rounded-full flex items-center justify-center text-muted-foreground mb-4">
                                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                                    </div>
                                    <p class="text-sm font-bold text-foreground">Inventaris Kosong</p>
                                    <p class="text-xs text-muted-foreground mt-1">Belum ada alat yang terdaftar di sistem.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
