<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-primary/10 rounded-lg">
                <svg class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-black text-foreground tracking-tight">Tambah Alat</h2>
                <p class="text-xs text-muted-foreground font-medium">Input data perangkat baru ke sistem</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="card-premium overflow-hidden bg-gradient-to-b from-card to-muted/20">
            <!-- Form Header Decor -->
            <div class="h-2 bg-gradient-to-r from-indigo-500 via-primary to-blue-500"></div>
            
            <form method="POST" action="{{ route('alats.store') }}" class="p-8 space-y-10">
                @csrf
                
                <!-- Section: Identitas Alat -->
                <div class="space-y-6">
                    <div class="flex items-center gap-3 pb-6">
                        <div class="h-10 w-10 rounded-2xl bg-indigo-600 text-white flex items-center justify-center shadow-lg shadow-indigo-600/20">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        </div>
                        <div>
                            <h3 class="font-black text-sm uppercase tracking-widest text-foreground">Identitas Alat</h3>
                            <p class="text-[9px] font-bold text-muted-foreground uppercase tracking-widest leading-none mt-1">Data dasar perangkat</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="md:col-span-2 group">
                            <x-input-label for="nama_alat" value="Nama Lengkap Alat" class="text-[10px] font-black uppercase text-muted-foreground mb-2 group-focus-within:text-primary transition-colors" />
                            <div class="relative">
                                <span class="absolute left-4 top-3 text-muted-foreground group-focus-within:text-primary transition-colors">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                                </span>
                                <input id="nama_alat" name="nama_alat" type="text" 
                                    class="block w-full pl-12 pr-4 py-3 bg-slate-100 dark:bg-slate-800 border-none rounded-2xl text-foreground focus:ring-4 focus:ring-indigo-500/20 focus:bg-white dark:focus:bg-slate-800 transition-all font-bold placeholder:font-normal placeholder:text-muted-foreground/50" 
                                    placeholder="Contoh: Kamera Sony A7 III" 
                                    value="{{ old('nama_alat') }}" required autofocus />
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('nama_alat')" />
                        </div>

                        <div class="group">
                            <x-input-label for="kategori_id" value="Kategori Perangkat" class="text-[10px] font-black uppercase text-muted-foreground mb-2 group-focus-within:text-indigo-500 transition-colors" />
                            <div class="relative">
                                <span class="absolute left-4 top-3 text-muted-foreground group-focus-within:text-indigo-500 transition-colors">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
                                </span>
                                <select name="kategori_id" id="kategori_id" 
                                    class="block w-full pl-12 pr-4 py-3 bg-slate-100 dark:bg-slate-800 border-none rounded-2xl text-foreground focus:ring-4 focus:ring-indigo-500/20 focus:bg-white dark:focus:bg-slate-800 transition-all font-bold appearance-none cursor-pointer" required>
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    @foreach($kategoris as $k)
                                        <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('kategori_id')" />
                        </div>

                        <div class="group">
                            <x-input-label for="stok" value="Jumlah Unit" class="text-[10px] font-black uppercase text-muted-foreground mb-2 group-focus-within:text-emerald-500 transition-colors" />
                            <div class="relative">
                                <span class="absolute left-4 top-3 text-muted-foreground group-focus-within:text-emerald-500 transition-colors">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                                </span>
                                <input id="stok" name="stok" type="number" 
                                    class="block w-full pl-12 pr-4 py-3 bg-slate-100 dark:bg-slate-800 border-none rounded-2xl text-foreground focus:ring-4 focus:ring-emerald-500/20 focus:bg-white dark:focus:bg-slate-800 transition-all font-bold" 
                                    value="{{ old('stok', 0) }}" required min="0" />
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('stok')" />
                        </div>
                    </div>
                </div>

                <!-- Section: Status Operasional -->
                <div class="space-y-6 pt-6">
                    <div class="flex items-center gap-3 pb-6">
                        <div class="h-10 w-10 rounded-2xl bg-amber-500 text-white flex items-center justify-center shadow-lg shadow-amber-500/20">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <h3 class="font-black text-sm uppercase tracking-widest text-foreground">Status Operasional</h3>
                            <p class="text-[9px] font-bold text-muted-foreground uppercase tracking-widest leading-none mt-1">Kondisi & Kelayakan</p>
                        </div>
                    </div>

                    <div class="group">
                        <x-input-label for="kondisi" value="Kondisi Fisik Saat Ini" class="text-[10px] font-black uppercase text-muted-foreground mb-4 block" />
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            @foreach(['baik', 'rusak ringan', 'rusak berat'] as $val)
                                <label class="relative cursor-pointer group/label">
                                    <input type="radio" name="kondisi" value="{{ $val }}" class="peer sr-only" {{ old('kondisi', 'baik') == $val ? 'checked' : '' }}>
                                    <div class="p-4 rounded-2xl border-none bg-slate-100 dark:bg-slate-800 text-center transition-all peer-checked:bg-indigo-600 peer-checked:text-white shadow-sm peer-checked:shadow-xl peer-checked:shadow-indigo-600/20 group-hover/label:bg-slate-200 dark:group-hover/label:bg-slate-700">
                                        <div class="h-8 w-8 mx-auto mb-2 rounded-full flex items-center justify-center 
                                            {{ $val == 'baik' ? 'bg-green-100 text-green-600' : ($val == 'rusak ringan' ? 'bg-amber-100 text-amber-600' : 'bg-red-100 text-red-600') }}">
                                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <span class="text-xs font-black uppercase tracking-tight text-foreground">{{ $val }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('kondisi')" />
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end gap-6 pt-10 border-t border-border mt-10">
                    <a href="{{ route('alats.index') }}" class="text-xs font-black uppercase tracking-widest text-muted-foreground hover:text-foreground transition-all">Batalkan</a>
                    <button type="submit" class="px-8 py-3 bg-primary text-primary-foreground rounded-2xl text-xs font-black uppercase tracking-widest shadow-xl shadow-primary/20 hover:shadow-primary/40 hover:-translate-y-0.5 active:translate-y-0 transition-all">
                        Daftarkan Perangkat
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
