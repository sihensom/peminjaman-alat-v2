<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-indigo-500/10 rounded-lg text-indigo-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-black text-foreground tracking-tight">Detail Pengembalian</h2>
                <p class="text-xs text-muted-foreground font-medium">Informasi lengkap transaksi pengembalian #{{ $pengembalian->id }}</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Main Content Area -->
            <div class="md:col-span-2 space-y-8">
                <div class="card-premium p-8">
                    <div class="flex items-center justify-between pb-8 mb-8">
                        <h3 class="font-black text-sm uppercase tracking-widest text-foreground">Detail Transaksi Pengembalian</h3>
                        <span class="px-5 py-2 bg-emerald-500 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-emerald-500/20">Selesai</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                        <div class="space-y-1">
                            <p class="text-[10px] font-black uppercase text-muted-foreground tracking-widest">Peminjam</p>
                            <p class="font-bold text-foreground text-lg">{{ $pengembalian->peminjaman->user->name }}</p>
                            <p class="text-xs text-muted-foreground">{{ $pengembalian->peminjaman->user->email }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[10px] font-black uppercase text-muted-foreground tracking-widest">ID Peminjaman</p>
                            <p class="font-mono text-foreground font-bold text-lg">#{{ str_pad($pengembalian->peminjaman_id, 4, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[10px] font-black uppercase text-muted-foreground tracking-widest">Tgl Pinjam</p>
                            <p class="font-bold text-foreground">{{ \Carbon\Carbon::parse($pengembalian->peminjaman->tanggal_pinjam)->format('d F Y') }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[10px] font-black uppercase text-muted-foreground tracking-widest">Tgl Dikembalikan</p>
                            <p class="font-black text-indigo-600 text-lg">{{ \Carbon\Carbon::parse($pengembalian->tanggal_dikembalikan)->format('d F Y') }}</p>
                        </div>
                    </div>

                    <div class="mt-12 pt-10">
                        <div class="flex items-center gap-3 mb-8">
                            <div class="w-1.5 h-6 bg-indigo-600 rounded-full"></div>
                            <h4 class="text-[10px] font-black uppercase text-muted-foreground tracking-widest">Alat yang Dikembalikan</h4>
                        </div>
                        <div class="space-y-4">
                            @foreach($pengembalian->peminjaman->details as $detail)
                                <div class="flex items-center gap-4 p-5 bg-slate-50 dark:bg-slate-800/50 rounded-2xl group hover:bg-white dark:hover:bg-slate-800 transition-all shadow-sm">
                                    <div class="h-12 w-12 rounded-2xl bg-indigo-600 text-white flex items-center justify-center shadow-lg shadow-indigo-600/20">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-bold text-foreground">{{ $detail->alat->nama_alat }}</p>
                                        <p class="text-[10px] text-muted-foreground uppercase">{{ $detail->alat->kategori->nama_kategori }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-black text-foreground">{{ $detail->jumlah }} Unit</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats/Summary Sidebar -->
            <div class="space-y-8">
                <div class="card-premium p-8 bg-gradient-to-br from-indigo-600 to-indigo-800 text-white border-none shadow-xl shadow-indigo-500/20">
                    <h4 class="text-[10px] font-black uppercase tracking-widest opacity-80 mb-4">Total Denda</h4>
                    <div class="flex items-baseline gap-2">
                        <span class="text-xl font-bold opacity-60">Rp</span>
                        <span class="text-4xl font-black">{{ number_format($pengembalian->denda, 0, ',', '.') }}</span>
                    </div>
                    @if($pengembalian->denda > 0)
                        <div class="mt-6 p-3 bg-white/10 rounded-xl border border-white/20">
                            <p class="text-[10px] leading-relaxed">Peminjaman ini dikembalikan terlambat. Harap pastikan denda telah dilunasi.</p>
                        </div>
                    @else
                        <div class="mt-6 p-3 bg-white/10 rounded-xl border border-white/20">
                            <p class="text-[10px] leading-relaxed">Pengembalian tepat waktu. Tidak ada denda yang dikenakan.</p>
                        </div>
                    @endif
                </div>

                <div class="card-premium p-8">
                    <h4 class="text-[10px] font-black uppercase tracking-widest text-muted-foreground mb-6">Status Log</h4>
                    <div class="space-y-4">
                        <div class="flex gap-4">
                            <div class="h-1 bg-green-500 w-1 mt-2.5 rounded-full"></div>
                            <div>
                                <p class="text-xs font-bold text-foreground">Dikembalikan</p>
                                <p class="text-[10px] text-muted-foreground">{{ $pengembalian->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="h-1 bg-indigo-500 w-1 mt-2.5 rounded-full"></div>
                            <div>
                                <p class="text-xs font-bold text-foreground">Dipinjam</p>
                                <p class="text-[10px] text-muted-foreground">{{ $pengembalian->peminjaman->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                    <button onclick="window.print()" class="w-full mt-10 py-3 bg-muted hover:bg-border text-foreground rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all">Cetak Kuitansi</button>
                </div>
            </div>
        </div>

        <div class="flex justify-start">
            <a href="{{ route('pengembalians.index') }}" class="flex items-center gap-2 text-xs font-black uppercase tracking-widest text-muted-foreground hover:text-foreground transition-all">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Kembali ke Daftar
            </a>
        </div>
    </div>
</x-app-layout>
