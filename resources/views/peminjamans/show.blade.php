<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-emerald-500/10 rounded-lg text-emerald-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-black text-foreground tracking-tight">Detail Peminjaman</h2>
                    <p class="text-xs text-muted-foreground font-medium">ID Transaksi: #{{ str_pad($peminjaman->id, 4, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>
            
            <div class="flex gap-3">
                @if($peminjaman->status === 'disetujui' && Auth::user()->role !== 'peminjam')
                    <a href="{{ route('pengembalians.create', ['peminjaman_id' => $peminjaman->id]) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-500/20">
                        Proses Pengembalian
                    </a>
                @endif
                <button onclick="window.print()" class="p-2 bg-muted hover:bg-border rounded-lg text-foreground transition-all">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2-2" /></svg>
                </button>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-8">
        <!-- Status Header Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="card-premium p-6 flex flex-col items-center justify-center text-center space-y-2">
                <p class="text-[10px] font-black uppercase text-muted-foreground tracking-widest">Status Saat Ini</p>
                @php
                    $colors = [
                        'pending' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300',
                        'disetujui' => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300',
                        'dikembalikan' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300',
                        'ditolak' => 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300',
                    ];
                @endphp
                <span class="px-4 py-1.5 {{ $colors[$peminjaman->status] ?? 'bg-muted text-foreground' }} rounded-full text-xs font-black uppercase tracking-widest">
                    {{ $peminjaman->status }}
                </span>
            </div>
            <div class="card-premium p-6 flex flex-col items-center justify-center text-center space-y-2">
                <p class="text-[10px] font-black uppercase text-muted-foreground tracking-widest">Tanggal Pinjam</p>
                <p class="font-black text-foreground text-lg">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</p>
            </div>
            <div class="card-premium p-6 flex flex-col items-center justify-center text-center space-y-2">
                <p class="text-[10px] font-black uppercase text-muted-foreground tracking-widest">Batas Kembali</p>
                <p class="font-black text-amber-600 dark:text-amber-400 text-lg">{{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d M Y') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Info Area -->
            <div class="lg:col-span-2 space-y-8">
                <div class="card-premium p-8">
                    <div class="flex items-center gap-3 pb-6 mb-6">
                        <div class="w-1.5 h-6 bg-indigo-600 rounded-full"></div>
                        <h3 class="font-black text-sm uppercase tracking-widest text-foreground">Daftar Item Terlampir</h3>
                    </div>
                    <div class="space-y-4">
                        @foreach($peminjaman->details as $detail)
                            <div class="flex items-center gap-4 p-5 bg-slate-50 dark:bg-slate-800/80 border-none rounded-[1.5rem] group hover:bg-white dark:hover:bg-slate-800 transition-all shadow-sm hover:shadow-xl hover:shadow-slate-200/50 dark:hover:shadow-none hover:-translate-y-1">
                                <div class="h-12 w-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary font-black uppercase text-xs">
                                    {{ substr($detail->alat->nama_alat, 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <p class="font-bold text-foreground">{{ $detail->alat->nama_alat }}</p>
                                    <p class="text-[10px] text-muted-foreground uppercase tracking-wider">{{ $detail->alat->kategori->nama_kategori }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-black text-foreground text-lg">{{ $detail->jumlah }}</p>
                                    <p class="text-[10px] text-muted-foreground uppercase font-bold">Qty</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                @if($peminjaman->pengembalian)
                    <div class="card-premium p-8 border-t-4 border-t-emerald-500">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="font-black text-sm uppercase tracking-widest text-foreground">Informasi Pengembalian</h3>
                            <svg class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div class="grid grid-cols-2 gap-8">
                            <div class="space-y-1">
                                <p class="text-[10px] font-black uppercase text-muted-foreground tracking-widest">Dikembalikan Pada</p>
                                <p class="font-bold text-foreground">{{ \Carbon\Carbon::parse($peminjaman->pengembalian->tanggal_dikembalikan)->format('d F Y') }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-[10px] font-black uppercase text-muted-foreground tracking-widest">Total Denda</p>
                                <p class="font-black text-red-500 text-xl">Rp {{ number_format($peminjaman->pengembalian->denda, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Sidebar Area -->
            <div class="space-y-8">
                <div class="card-premium p-8">
                    <h4 class="text-[10px] font-black uppercase tracking-widest text-muted-foreground mb-6">Peminjam</h4>
                    <div class="flex items-center gap-4">
                        <div class="h-12 w-12 rounded-full bg-slate-200 flex items-center justify-center text-slate-600 font-black uppercase text-xl">
                            {{ substr($peminjaman->user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-black text-foreground leading-tight">{{ $peminjaman->user->name }}</p>
                            <p class="text-[10px] text-muted-foreground font-medium uppercase mt-0.5">{{ $peminjaman->user->role }}</p>
                        </div>
                    </div>
                    <div class="mt-8 pt-8 space-y-4">
                        <div class="flex justify-between items-center p-4 bg-slate-50 dark:bg-slate-800/50 rounded-2xl">
                             <span class="text-[9px] font-black uppercase text-muted-foreground tracking-widest">ID Akun</span>
                            <span class="font-black text-foreground text-xs uppercase">#USR-{{ $peminjaman->user_id }}</span>
                        </div>
                        <div class="flex justify-between items-center p-4 bg-slate-50 dark:bg-slate-800/50 rounded-2xl">
                            <span class="text-[9px] font-black uppercase text-muted-foreground tracking-widest">Email</span>
                            <span class="font-bold text-foreground text-xs">{{ $peminjaman->user->email }}</span>
                        </div>
                    </div>
                </div>

                @if($peminjaman->status === 'pending' && Auth::user()->role !== 'peminjam')
                    <div class="card-premium p-6 space-y-4">
                        <h4 class="text-[10px] font-black uppercase tracking-widest text-muted-foreground">Moderasi Admin</h4>
                        <div class="flex gap-3">
                            <form action="{{ route('peminjamans.update', $peminjaman) }}" method="POST" class="flex-1">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="disetujui">
                                <button class="w-full py-3 bg-emerald-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20">Setujui</button>
                            </form>
                            <form action="{{ route('peminjamans.update', $peminjaman) }}" method="POST" class="flex-1">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="ditolak">
                                <button class="w-full py-3 bg-red-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-red-700 transition-all">Tolak</button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="flex justify-start">
            <a href="{{ route('peminjamans.index') }}" class="flex items-center gap-2 text-xs font-black uppercase tracking-widest text-muted-foreground hover:text-foreground transition-all">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Daftar Peminjaman
            </a>
        </div>
    </div>
</x-app-layout>
