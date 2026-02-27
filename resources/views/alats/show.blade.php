<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-indigo-500/10 rounded-lg text-indigo-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-black text-foreground tracking-tight">Detail Perangkat</h2>
                <p class="text-xs text-muted-foreground font-medium">Informasi teknis dan ketersediaan alat</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Main Content Area -->
            <div class="md:col-span-2 space-y-8">
                <div class="card-premium p-8">
                    <div class="flex items-center justify-between pb-8 mb-8">
                        <div>
                            <span class="px-3 py-1 bg-indigo-600 text-white rounded-lg text-[9px] font-black uppercase tracking-widest shadow-lg shadow-indigo-600/20 mb-3 inline-block">
                                {{ $alat->kategori->nama_kategori }}
                            </span>
                            <h3 class="text-3xl font-black text-foreground tracking-tight uppercase">{{ $alat->nama_alat }}</h3>
                        </div>
                        <div class="text-right">
                             @if($alat->stok > 0)
                                <div class="px-5 py-2 bg-emerald-500 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-emerald-500/20">Tersedia</div>
                            @else
                                <div class="px-5 py-2 bg-red-500 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-red-500/20">Habis</div>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-10">
                        <div class="space-y-1">
                            <p class="text-[10px] font-black uppercase text-muted-foreground tracking-widest">Kondisi Alat</p>
                            <div class="flex items-center gap-2">
                                <div class="h-2 w-2 rounded-full {{ $alat->kondisi === 'baik' ? 'bg-emerald-500' : ($alat->kondisi === 'rusak' ? 'bg-red-500' : 'bg-amber-500') }}"></div>
                                <p class="font-bold text-foreground capitalize text-lg">{{ $alat->kondisi }}</p>
                            </div>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[10px] font-black uppercase text-muted-foreground tracking-widest">Sisa Unit</p>
                            <p class="font-black text-primary text-3xl">{{ $alat->stok }} <span class="text-sm text-muted-foreground font-bold">Unit</span></p>
                        </div>
                    </div>

                    <div class="mt-12 pt-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-1.5 h-6 bg-indigo-600 rounded-full"></div>
                            <h4 class="text-[10px] font-black uppercase text-muted-foreground tracking-widest">Informasi Tambahan</h4>
                        </div>
                        <div class="p-6 bg-slate-50 dark:bg-slate-800/50 rounded-2xl">
                            <p class="text-sm text-muted-foreground font-bold italic leading-relaxed">{{ $alat->deskripsi ?? 'Tidak ada deskripsi tambahan untuk alat ini.' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities related to this alat (Optional/Future) -->
                <div class="card-premium p-8">
                     <h4 class="text-[10px] font-black uppercase text-muted-foreground tracking-widest mb-6">Log Terakhir</h4>
                     <div class="space-y-4">
                        <p class="text-[10px] text-muted-foreground italic text-center py-4">Fitur log alat akan segera hadir di modul audit.</p>
                     </div>
                </div>
            </div>

            <!-- Stats/Summary Sidebar -->
            <div class="space-y-8">
                <div class="card-premium p-8 bg-gradient-to-br from-indigo-600 to-indigo-800 text-white border-none shadow-xl shadow-indigo-500/20">
                    <div class="h-10 w-10 bg-white/20 rounded-xl flex items-center justify-center mb-6">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 00-2 2z" /></svg>
                    </div>
                    <h4 class="text-[10px] font-black uppercase tracking-widest opacity-80 mb-2 text-white">Status</h4>
                    <p class="text-xl font-black">Aktif dalam Sistem</p>
                    <div class="mt-8 flex gap-4">
                        @if(Auth::user()->role !== 'peminjam')
                            <a href="{{ route('alats.edit', $alat) }}" class="flex-1 text-center py-2 bg-white/10 hover:bg-white/20 border border-white/20 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">Edit</a>
                        @endif
                    </div>
                </div>

                <div class="card-premium p-8 space-y-6">
                    <div class="p-6 bg-slate-50 dark:bg-slate-800/50 rounded-2xl space-y-6">
                        <div>
                            <p class="text-[9px] font-black uppercase text-muted-foreground tracking-widest mb-2 opacity-60">Ditambahkan Pada</p>
                            <p class="font-black text-foreground text-xs">{{ $alat->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-[9px] font-black uppercase text-muted-foreground tracking-widest mb-2 opacity-60">Update Terakhir</p>
                            <p class="font-black text-foreground text-xs">{{ $alat->updated_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-start">
            <a href="{{ route('alats.index') }}" class="flex items-center gap-2 text-xs font-black uppercase tracking-widest text-muted-foreground hover:text-foreground transition-all">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Kembali ke Daftar
            </a>
        </div>
    </div>
</x-app-layout>
