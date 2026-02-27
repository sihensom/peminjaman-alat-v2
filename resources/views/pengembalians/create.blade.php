<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-indigo-500/10 rounded-lg text-indigo-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 11l3 3L22 4" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-black text-foreground tracking-tight">Proses Pengembalian</h2>
                <p class="text-xs text-muted-foreground font-medium">Validasi kondisi alat dan hitung denda jika ada</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="card-premium overflow-hidden bg-gradient-to-b from-card to-muted/20">
            <div class="h-1.5 bg-gradient-to-r from-indigo-500 to-primary"></div>
            
            <form method="POST" action="{{ route('pengembalians.store') }}" class="p-8 space-y-8">
                @csrf
                
                <div class="space-y-6">
                    <div class="group">
                        <x-input-label for="peminjaman_id" value="Pilih Transaksi Peminjaman" class="text-[10px] font-black uppercase text-muted-foreground mb-2 group-focus-within:text-indigo-600 transition-colors" />
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-muted-foreground group-focus-within:text-indigo-600 transition-colors">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                            </span>
                            <select name="peminjaman_id" id="peminjaman_id" 
                                class="block w-full pl-12 pr-4 py-3 bg-slate-100 dark:bg-slate-800 border-none rounded-2xl text-foreground focus:ring-4 focus:ring-indigo-500/20 focus:bg-white dark:focus:bg-slate-800 transition-all font-bold appearance-none cursor-pointer" required>
                                <option value="" disabled selected>Pilih Pinjaman Aktif...</option>
                                @foreach($peminjamans as $p)
                                    <option value="{{ $p->id }}" {{ old('peminjaman_id') == $p->id ? 'selected' : '' }}>
                                        #{{ $p->id }} - {{ $p->user->name }} ({{ count($p->details) }} Item)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('peminjaman_id')" />
                        <p class="mt-2 text-[10px] text-muted-foreground">Hanya menampilkan peminjaman dengan status "disetujui".</p>
                    </div>

                    <div class="group">
                        <x-input-label for="tanggal_dikembalikan" value="Tanggal Dikembalikan" class="text-[10px] font-black uppercase text-muted-foreground mb-2 group-focus-within:text-emerald-500 transition-colors" />
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-muted-foreground group-focus-within:text-emerald-500 transition-colors">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 00-2 2z" /></svg>
                            </span>
                            <input id="tanggal_dikembalikan" name="tanggal_dikembalikan" type="date" 
                                class="block w-full pl-12 pr-4 py-3 bg-slate-100 dark:bg-slate-800 border-none rounded-2xl text-foreground focus:ring-4 focus:ring-emerald-500/20 focus:bg-white dark:focus:bg-slate-800 transition-all font-bold" 
                                value="{{ old('tanggal_dikembalikan', date('Y-m-d')) }}" required />
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('tanggal_dikembalikan')" />
                    </div>
                </div>

                <div class="flex items-center justify-end gap-6 pt-10 mt-10">
                    <a href="{{ route('pengembalians.index') }}" class="text-xs font-black uppercase tracking-widest text-muted-foreground hover:text-foreground transition-all">Batalkan</a>
                    <button type="submit" class="px-8 py-3 bg-indigo-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest shadow-xl shadow-indigo-500/20 hover:shadow-indigo-500/40 hover:-translate-y-0.5 active:translate-y-0 transition-all">
                        Proses Pengembalian Alat
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
