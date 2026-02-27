<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-indigo-500/10 rounded-lg text-indigo-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-black text-foreground tracking-tight">Detail Kategori</h2>
                <p class="text-xs text-muted-foreground font-medium">Informasi pengelompokan dan daftar alat terkait</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-8">
        <div class="card-premium p-10 bg-gradient-to-r from-indigo-600/5 to-transparent border-l-4 border-l-indigo-600">
            <div class="space-y-1">
                <p class="text-[10px] font-black uppercase text-indigo-600 tracking-[0.2em]">Kategori Perangkat</p>
                <h3 class="text-3xl font-black text-foreground">{{ $kategori->nama_kategori }}</h3>
            </div>
            @if($kategori->deskripsi)
                <div class="mt-8 p-6 bg-white dark:bg-slate-800/80 rounded-[2rem] shadow-sm italic text-muted-foreground leading-relaxed">
                    {{ $kategori->deskripsi }}
                </div>
            @endif
        </div>

        <div class="space-y-6">
            <div class="flex items-center justify-between">
                 <h4 class="text-[10px] font-black uppercase text-muted-foreground tracking-[0.2em]">Daftar Alat dalam Kategori Ini</h4>
                 <p class="text-xs font-bold text-foreground bg-indigo-500/10 text-indigo-600 px-3 py-1 rounded-full">{{ count($kategori->alats) }} Alat</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($kategori->alats as $alat)
                    <a href="{{ route('alats.show', $alat) }}" class="card-premium p-8 border-none hover:shadow-2xl hover:shadow-indigo-500/10 hover:-translate-y-1 transition-all group overflow-hidden relative">
                        <div class="absolute top-0 right-0 p-4">
                             @if($alat->stok > 0)
                                <div class="h-2.5 w-2.5 rounded-full bg-emerald-500 shadow-lg shadow-emerald-500/50"></div>
                            @else
                                <div class="h-2.5 w-2.5 rounded-full bg-red-500 shadow-lg shadow-red-500/50 animate-pulse"></div>
                            @endif
                        </div>
                        <div class="flex items-center justify-between mb-6">
                            <div class="h-12 w-12 rounded-2xl bg-indigo-600 text-white flex items-center justify-center shadow-lg shadow-indigo-600/20 group-hover:scale-110 transition-transform">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" /></svg>
                            </div>
                        </div>
                        <h5 class="font-black text-foreground group-hover:text-indigo-600 transition-colors">{{ $alat->nama_alat }}</h5>
                        <p class="text-[10px] text-muted-foreground mt-1 uppercase font-black">Stok: {{ $alat->stok }} Unit</p>
                    </a>
                @empty
                    <div class="col-span-full py-20 px-6 bg-slate-50 dark:bg-slate-800/50 rounded-[3rem] text-center shadow-inner">
                        <p class="text-xs font-black uppercase tracking-widest text-muted-foreground opacity-60">Belum ada alat yang didaftarkan</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="flex items-center justify-between pt-12">
            <a href="{{ route('kategoris.index') }}" class="flex items-center gap-2 text-xs font-black uppercase tracking-widest text-muted-foreground hover:text-foreground transition-all">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Kembali
            </a>
             @if(Auth::user()->role !== 'peminjam')
                <div class="flex gap-4">
                    <form action="{{ route('kategoris.destroy', $kategori) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-xs font-black uppercase tracking-widest text-red-500 hover:text-red-700 transition-all">Hapus Kategori</button>
                    </form>
                    <a href="{{ route('kategoris.edit', $kategori) }}" class="px-6 py-2 bg-indigo-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/40 transition-all">Edit</a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
