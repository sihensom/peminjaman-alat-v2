<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-emerald-500/10 rounded-lg text-emerald-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-black text-foreground tracking-tight">Ajukan Pinjaman</h2>
                <p class="text-xs text-muted-foreground font-medium">Pilih alat dan tentukan durasi peminjaman</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="card-premium overflow-hidden bg-gradient-to-b from-card to-muted/20">
            <div class="h-2 bg-gradient-to-r from-emerald-500 via-teal-500 to-primary"></div>
            
            <form method="POST" action="{{ route('peminjamans.store') }}" class="p-8 space-y-10">
                @csrf
                
                @if(Auth::user()->role !== 'peminjam')
                    <div class="group">
                        <x-input-label for="user_id" value="Nama Peminjam" class="text-[10px] font-black uppercase text-muted-foreground mb-2 group-focus-within:text-primary transition-colors" />
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-muted-foreground group-focus-within:text-primary transition-colors">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </span>
                            <select name="user_id" id="user_id" 
                                class="block w-full pl-12 pr-4 py-3 bg-slate-100 dark:bg-slate-800 border-none rounded-2xl text-foreground focus:ring-4 focus:ring-indigo-500/20 focus:bg-white dark:focus:bg-slate-800 transition-all font-bold appearance-none cursor-pointer" required>
                                <option value="" disabled selected>Pilih Peminjam</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
                    </div>
                @else
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="group">
                        <x-input-label for="tanggal_pinjam" value="Tanggal Mulai" class="text-[10px] font-black uppercase text-muted-foreground mb-2 group-focus-within:text-emerald-500 transition-colors" />
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-muted-foreground group-focus-within:text-emerald-500 transition-colors">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 00-2 2z" /></svg>
                            </span>
                            <input id="tanggal_pinjam" name="tanggal_pinjam" type="date" 
                                class="block w-full pl-12 pr-4 py-3 bg-slate-100 dark:bg-slate-800 border-none rounded-2xl text-foreground focus:ring-4 focus:ring-emerald-500/20 focus:bg-white dark:focus:bg-slate-800 transition-all font-bold" 
                                value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" required />
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('tanggal_pinjam')" />
                    </div>

                    <div class="group">
                        <x-input-label for="tanggal_kembali" value="Estimasi Selesai" class="text-[10px] font-black uppercase text-muted-foreground mb-2 group-focus-within:text-amber-500 transition-colors" />
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-muted-foreground group-focus-within:text-amber-500 transition-colors">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </span>
                            <input id="tanggal_kembali" name="tanggal_kembali" type="date" 
                                class="block w-full pl-12 pr-4 py-3 bg-slate-100 dark:bg-slate-800 border-none rounded-2xl text-foreground focus:ring-4 focus:ring-amber-500/20 focus:bg-white dark:focus:bg-slate-800 transition-all font-bold" 
                                value="{{ old('tanggal_kembali') }}" required />
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('tanggal_kembali')" />
                    </div>
                </div>

                <div class="space-y-6 pt-6">
                    <h3 class="font-black text-sm uppercase tracking-widest text-muted-foreground flex items-center gap-2 mb-4">
                        <div class="h-8 w-8 rounded-xl bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                             <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                        </div>
                        Daftar Item Alat
                    </h3>

                    <div class="p-8 bg-slate-50 dark:bg-slate-800/50 rounded-[2.5rem] shadow-inner">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="md:col-span-2 group/select">
                                <x-input-label for="alat_id" value="Pilih Perangkat" class="text-[10px] font-black uppercase text-muted-foreground mb-2 group-focus-within/select:text-primary transition-colors" />
                                <select name="items[0][alat_id]" id="alat_id" 
                                    class="block w-full px-5 py-4 bg-white dark:bg-slate-900 border-none rounded-2xl text-foreground focus:ring-4 focus:ring-indigo-500/20 transition-all font-bold appearance-none cursor-pointer shadow-sm" required>
                                    <option value="" disabled selected>Cari Alat Terdaftar...</option>
                                    @foreach(\App\Models\Alat::where('stok', '>', 0)->get() as $alat)
                                        <option value="{{ $alat->id }}">{{ $alat->nama_alat }} (Tersedia: {{ $alat->stok }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="group/input text-center">
                                <x-input-label for="jumlah" value="Qty" class="text-[10px] font-black uppercase text-muted-foreground mb-2 group-focus-within/input:text-primary transition-colors" />
                                <input id="jumlah" name="items[0][jumlah]" type="number" 
                                    class="block w-full px-5 py-4 bg-white dark:bg-slate-900 border-none rounded-2xl text-foreground focus:ring-4 focus:ring-indigo-500/20 transition-all font-black text-center shadow-sm" 
                                    value="1" min="1" required />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-6 pt-10 border-t border-border mt-10">
                    <a href="{{ route('peminjamans.index') }}" class="text-xs font-black uppercase tracking-widest text-muted-foreground hover:text-foreground transition-all">Kembali</a>
                    <button type="submit" class="px-10 py-4 bg-emerald-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest shadow-xl shadow-emerald-500/20 hover:shadow-emerald-500/40 hover:-translate-y-0.5 active:translate-y-0 transition-all">
                        Kirim Pengajuan Pinjam
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
