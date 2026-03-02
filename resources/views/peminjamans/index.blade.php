<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-primary/10 rounded-lg">
                <svg class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 00-2 2z" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-black text-foreground tracking-tight">Daftar Peminjaman</h2>
                <p class="text-xs text-muted-foreground font-medium">Riwayat dan pemantauan transaksi alat</p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            @php
                $baseUrl = Auth::user()->role === 'peminjam'
                    ? route('peminjam.peminjamans.index')
                    : (Auth::user()->role === 'petugas'
                        ? route('petugas.peminjamans.index')
                        : route('peminjamans.index'));
                $activeClass = 'px-4 py-2 bg-indigo-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-indigo-600/20';
                $inactiveClass = 'px-4 py-2 bg-slate-100 dark:bg-slate-800 rounded-xl text-[10px] font-black uppercase tracking-widest text-muted-foreground hover:bg-slate-200 dark:hover:bg-slate-700 transition-all';
            @endphp
            <div class="flex items-center gap-2">
                <a href="{{ $baseUrl }}" class="{{ is_null($status) ? $activeClass : $inactiveClass }}">Semua</a>
                <a href="{{ $baseUrl }}?status=menunggu" class="{{ $status === 'menunggu' ? $activeClass : $inactiveClass }}">Menunggu</a>
                <a href="{{ $baseUrl }}?status=aktif" class="{{ $status === 'aktif' ? $activeClass : $inactiveClass }}">Aktif</a>
            </div>

            @if(Auth::user()->role === 'peminjam')
                <a href="{{ route('peminjam.peminjamans.create') }}" class="btn-primary flex items-center gap-2 shadow-indigo-500/20 shadow-lg">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    Ajukan Peminjaman
                </a>
            @elseif(Auth::user()->role === 'admin')
                <a href="{{ route('peminjamans.create') }}" class="btn-primary flex items-center gap-2 shadow-indigo-500/20 shadow-lg">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    Tambah Peminjaman
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
                            <th class="px-6 py-4">Periode Pinjam</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Manajemen</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse($peminjamans as $p)
                            <tr class="hover:bg-muted/30 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-9 w-9 rounded-lg bg-muted flex items-center justify-center text-muted-foreground group-hover:bg-primary/10 group-hover:text-primary transition-colors font-mono text-xs font-bold">
                                            #{{ str_pad($p->id, 3, '0', STR_PAD_LEFT) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-foreground">{{ count($p->details) }} Item Alat</div>
                                            <div class="text-[10px] text-muted-foreground">{{ $p->created_at->format('d M Y, H:i') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="h-6 w-6 rounded-full bg-primary/10 flex items-center justify-center text-[10px] font-bold text-primary">
                                            {{ substr($p->user->name, 0, 1) }}
                                        </div>
                                        <span class="font-semibold text-foreground text-xs">{{ $p->user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2 text-xs font-medium">
                                        <span class="text-muted-foreground">{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d/m') }}</span>
                                        <svg class="h-3 w-3 text-muted-foreground" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                                        <span class="text-foreground">{{ \Carbon\Carbon::parse($p->tanggal_kembali)->format('d/m/Y') }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusClass = [
                                            'menunggu' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300',
                                            'disetujui' => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300',
                                            'dikembalikan' => 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300',
                                            'ditolak' => 'bg-destructive/10 text-destructive'
                                        ][$p->status] ?? 'bg-muted text-muted-foreground';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-tight {{ $statusClass }}">
                                        {{ $p->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end items-center gap-2">
                                        @php
                                            $showRoute = Auth::user()->role === 'peminjam' ? route('peminjam.peminjamans.show', $p) : (Auth::user()->role === 'petugas' ? route('petugas.peminjamans.show', $p) : route('peminjamans.show', $p));
                                        @endphp
                                        <a href="{{ $showRoute }}" class="px-3 py-1.5 bg-muted hover:bg-border text-foreground rounded-lg text-xs font-bold transition-all">Detail</a>
                                        
                                        @if(Auth::user()->role === 'admin')
                                            <a href="{{ route('peminjamans.edit', $p) }}" class="px-3 py-1.5 bg-amber-500/10 text-amber-600 hover:bg-amber-500 hover:text-white rounded-lg text-xs font-bold transition-all">Edit</a>
                                            <form method="POST" action="{{ route('peminjamans.destroy', $p) }}" class="inline-block" onsubmit="return confirm('Hapus peminjaman #{{ $p->id }}?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 bg-destructive/10 text-destructive hover:bg-destructive hover:text-white rounded-lg text-xs font-bold transition-all">Hapus</button>
                                            </form>
                                        @endif

                                        @if($p->status === 'menunggu' && Auth::user()->role === 'petugas')
                                            <div class="flex gap-1">
                                                <form method="POST" action="{{ route('peminjamans.approve', $p) }}">
                                                    @csrf
                                                    <button type="submit" class="p-1.5 bg-green-500/10 text-green-600 hover:bg-green-500 hover:text-white rounded-lg transition-all" title="Setujui">
                                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('peminjamans.reject', $p) }}">
                                                    @csrf
                                                    <button type="submit" class="p-1.5 bg-destructive/10 text-destructive hover:bg-destructive hover:text-white rounded-lg transition-all" title="Tolak">
                                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-20 text-center">
                                    <div class="mx-auto w-16 h-16 bg-muted rounded-full flex items-center justify-center text-muted-foreground mb-4">
                                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 00-2 2z" /></svg>
                                    </div>
                                    <p class="text-sm font-bold text-foreground">Belum ada Transaksi</p>
                                    <p class="text-xs text-muted-foreground mt-1">Gunakan tombol "Ajukan Peminjaman" untuk mulai meminjam alat.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
