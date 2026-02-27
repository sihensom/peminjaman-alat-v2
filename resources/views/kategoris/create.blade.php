<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-indigo-500/10 rounded-lg text-indigo-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-black text-foreground tracking-tight">Kategori Baru</h2>
                <p class="text-xs text-muted-foreground font-medium">Klasifikasikan alat berdasarkan jenisnya</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="card-premium overflow-hidden bg-gradient-to-b from-card to-muted/20">
            <div class="h-1.5 bg-gradient-to-r from-indigo-500 to-blue-500"></div>
            
            <form method="POST" action="{{ route('kategoris.store') }}" class="p-8 space-y-8">
                @csrf
                
                <div class="space-y-6">
                    <div class="group">
                        <x-input-label for="nama_kategori" value="Nama Kategori" class="text-[10px] font-black uppercase text-muted-foreground mb-2 group-focus-within:text-primary transition-colors" />
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-muted-foreground group-focus-within:text-primary transition-colors">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2z" /></svg>
                            </span>
                            <input id="nama_kategori" name="nama_kategori" type="text" 
                                class="block w-full pl-12 pr-4 py-3 bg-slate-100 dark:bg-slate-800 border-none rounded-2xl text-foreground focus:ring-4 focus:ring-indigo-500/20 focus:bg-white dark:focus:bg-slate-800 transition-all font-bold placeholder:font-normal placeholder:text-muted-foreground/50" 
                                placeholder="Misal: Elektronik, Perkakas..." 
                                value="{{ old('nama_kategori') }}" required autofocus />
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('nama_kategori')" />
                    </div>

                    <div class="group">
                        <x-input-label for="deskripsi" value="Deskripsi Kategori" class="text-[10px] font-black uppercase text-muted-foreground mb-2 group-focus-within:text-slate-500 transition-colors" />
                        <textarea id="deskripsi" name="deskripsi" 
                            class="block w-full p-6 bg-slate-100 dark:bg-slate-800 border-none rounded-2xl text-foreground focus:ring-4 focus:ring-slate-500/20 focus:bg-white dark:focus:bg-slate-800 transition-all font-medium min-h-[140px] placeholder:font-normal placeholder:text-muted-foreground/50"
                            placeholder="Jelaskan secara singkat kegunaan kategori ini...">{{ old('deskripsi') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('deskripsi')" />
                    </div>
                </div>

                <div class="flex items-center justify-end gap-6 pt-10 mt-10">
                    <a href="{{ route('kategoris.index') }}" class="text-xs font-black uppercase tracking-widest text-muted-foreground hover:text-foreground transition-all">Batalkan</a>
                    <button type="submit" class="px-8 py-3 bg-indigo-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest shadow-xl shadow-indigo-500/20 hover:shadow-indigo-500/40 hover:-translate-y-0.5 active:translate-y-0 transition-all">
                        Simpan Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
