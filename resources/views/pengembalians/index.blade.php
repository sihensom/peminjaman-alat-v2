<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-indigo-500/10 rounded-lg text-indigo-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 11l3 3L22 4" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-black text-foreground tracking-tight">Data Pengembalian</h2>
                <p class="text-xs text-muted-foreground font-medium">Riwayat pengembalian alat dan denda</p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="relative w-full sm:w-64">
                <input type="text" placeholder="Cari data..." class="w-full pl-10 pr-4 py-2 bg-slate-100 dark:bg-slate-800 border-none rounded-xl text-sm focus:ring-4 focus:ring-indigo-500/20 transition-all font-bold">
                <svg class="absolute left-3 top-2.5 h-4 w-4 text-muted-foreground" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            @if(Auth::user()->role === 'petugas')
                <a href="{{ route('petugas.pengembalians.create') }}" class="btn-primary flex items-center gap-2 shadow-indigo-500/20 shadow-lg">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                    Proses Pengembalian
                </a>
            @elseif(Auth::user()->role === 'admin')
                <a href="{{ route('pengembalians.create') }}" class="btn-primary flex items-center gap-2 shadow-indigo-500/20 shadow-lg">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    Tambah Pengembalian
                </a>
            @endif
        </div>

        <div class="card-premium overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-muted/50 text-muted-foreground uppercase text-[10px] font-black tracking-widest">
                        <tr>
                            <th class="px-6 py-4">Transaksi</th>
                            <th class="px-6 py-4">Peminjam</th>
                            <th class="px-6 py-4">Tgl Kembali</th>
                            <th class="px-6 py-4">Denda</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse($pengembalians as $p)
                            <tr class="hover:bg-muted/30 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-9 w-9 rounded-lg bg-indigo-500/10 flex items-center justify-center text-indigo-600 font-mono text-xs font-bold">
                                            #{{ str_pad($p->peminjaman_id, 3, '0', STR_PAD_LEFT) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-foreground">Alat Dikembalikan</div>
                                            <div class="text-[10px] text-muted-foreground">ID Kembali: #{{ $p->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="h-6 w-6 rounded-full bg-slate-100 flex items-center justify-center text-[10px] font-bold text-slate-600 uppercase">
                                            {{ substr($p->peminjaman->user->name, 0, 1) }}
                                        </div>
                                        <span class="font-semibold text-foreground text-xs">{{ $p->peminjaman->user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-xs font-medium text-foreground">{{ \Carbon\Carbon::parse($p->tanggal_dikembalikan)->format('d M Y') }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($p->denda > 0)
                                        <span class="px-2 py-0.5 bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300 rounded-full text-[10px] font-black uppercase tracking-tight">
                                            Rp {{ number_format($p->denda, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300 rounded-full text-[10px] font-black uppercase tracking-tight">
                                            Nihil
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @php
                                        $showRoute = Auth::user()->role === 'peminjam' ? route('peminjam.pengembalians.show', $p) : (Auth::user()->role === 'petugas' ? route('petugas.pengembalians.show', $p) : route('pengembalians.show', $p));
                                    @endphp
                                    <div class="flex justify-end items-center gap-2">
                                        <a href="{{ $showRoute }}" class="px-3 py-1.5 bg-muted hover:bg-border text-foreground rounded-lg text-xs font-bold transition-all">Detail</a>
                                        @if(Auth::user()->role === 'admin')
                                            <a href="{{ route('pengembalians.edit', $p) }}" class="px-3 py-1.5 bg-amber-500/10 text-amber-600 hover:bg-amber-500 hover:text-white rounded-lg text-xs font-bold transition-all">Edit</a>
                                            <form method="POST" action="{{ route('pengembalians.destroy', $p) }}" class="inline-block" onsubmit="return confirm('Hapus data pengembalian #{{ $p->id }}?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 bg-destructive/10 text-destructive hover:bg-destructive hover:text-white rounded-lg text-xs font-bold transition-all">Hapus</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-20 text-center">
                                    <div class="mx-auto w-16 h-16 bg-muted rounded-full flex items-center justify-center text-muted-foreground mb-4">
                                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </div>
                                    <p class="text-sm font-bold text-foreground">Belum ada Pengembalian</p>
                                    <p class="text-xs text-muted-foreground mt-1">Data pengembalian akan muncul setelah alat diproses petugas.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
