<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-amber-500/10 rounded-lg text-amber-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-black text-foreground tracking-tight">Edit Pengembalian</h2>
                <p class="text-xs text-muted-foreground font-medium">ID Pengembalian: #{{ str_pad($pengembalian->id, 4, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="card-premium overflow-hidden bg-gradient-to-b from-card to-muted/20">
            <div class="h-1.5 bg-gradient-to-r from-amber-500 to-orange-500"></div>

            <form method="POST" action="{{ route('pengembalians.update', $pengembalian) }}" class="p-8 space-y-8">
                @csrf
                @method('PUT')

                @if(session('error'))
                    <div class="p-4 bg-destructive/10 text-destructive rounded-2xl text-sm font-semibold">{{ session('error') }}</div>
                @endif

                {{-- Transaksi Peminjaman --}}
                <div class="group">
                    <x-input-label for="peminjaman_id" value="Transaksi Peminjaman" class="text-[10px] font-black uppercase text-muted-foreground mb-2" />
                    <div class="relative">
                        <span class="absolute left-4 top-3 text-muted-foreground">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                        </span>
                        <select name="peminjaman_id" id="peminjaman_id"
                            class="block w-full pl-12 pr-4 py-3 bg-slate-100 dark:bg-slate-800 border-none rounded-2xl text-foreground focus:ring-4 focus:ring-amber-500/20 focus:bg-white dark:focus:bg-slate-800 transition-all font-bold appearance-none cursor-pointer" required>
                            @foreach($peminjamans as $p)
                                <option value="{{ $p->id }}" {{ old('peminjaman_id', $pengembalian->peminjaman_id) == $p->id ? 'selected' : '' }}>
                                    #{{ $p->id }} - {{ $p->user->name }} ({{ $p->status }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('peminjaman_id')" />
                </div>

                {{-- Tanggal Dikembalikan --}}
                <div class="group">
                    <x-input-label for="tanggal_dikembalikan" value="Tanggal Dikembalikan" class="text-[10px] font-black uppercase text-muted-foreground mb-2" />
                    <div class="relative">
                        <span class="absolute left-4 top-3 text-muted-foreground">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </span>
                        <input id="tanggal_dikembalikan" name="tanggal_dikembalikan" type="date"
                            class="block w-full pl-12 pr-4 py-3 bg-slate-100 dark:bg-slate-800 border-none rounded-2xl text-foreground focus:ring-4 focus:ring-amber-500/20 focus:bg-white dark:focus:bg-slate-800 transition-all font-bold"
                            value="{{ old('tanggal_dikembalikan', \Carbon\Carbon::parse($pengembalian->tanggal_dikembalikan)->format('Y-m-d')) }}" required />
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('tanggal_dikembalikan')" />
                </div>

                {{-- Denda --}}
                <div class="group">
                    <x-input-label for="denda" value="Denda (Rp)" class="text-[10px] font-black uppercase text-muted-foreground mb-2" />
                    <div class="relative">
                        <span class="absolute left-4 top-3 text-muted-foreground font-bold text-sm">Rp</span>
                        <input id="denda" name="denda" type="number" min="0" step="1000"
                            class="block w-full pl-12 pr-4 py-3 bg-slate-100 dark:bg-slate-800 border-none rounded-2xl text-foreground focus:ring-4 focus:ring-amber-500/20 focus:bg-white dark:focus:bg-slate-800 transition-all font-bold"
                            value="{{ old('denda', $pengembalian->denda) }}" />
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('denda')" />
                    <p class="mt-1 text-[10px] text-muted-foreground">Isi 0 jika tidak ada denda. Admin dapat menyesuaikan nominal denda secara manual.</p>
                </div>

                <div class="flex items-center justify-end gap-6 pt-8 border-t border-border">
                    <a href="{{ route('pengembalians.index') }}" class="text-xs font-black uppercase tracking-widest text-muted-foreground hover:text-foreground transition-all">Batal</a>
                    <button type="submit" class="px-8 py-3 bg-amber-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest shadow-xl shadow-amber-500/20 hover:shadow-amber-500/40 hover:-translate-y-0.5 active:translate-y-0 transition-all">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
