<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-amber-500/10 rounded-lg text-amber-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-black text-foreground tracking-tight">Edit Peminjaman</h2>
                <p class="text-xs text-muted-foreground font-medium">ID Transaksi: #{{ str_pad($peminjaman->id, 4, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="card-premium overflow-hidden bg-gradient-to-b from-card to-muted/20">
            <div class="h-1.5 bg-gradient-to-r from-amber-500 to-orange-500"></div>

            <form method="POST" action="{{ route('peminjamans.update', $peminjaman) }}" class="p-8 space-y-8">
                @csrf
                @method('PUT')

                @if(session('error'))
                    <div class="p-4 bg-destructive/10 text-destructive rounded-2xl text-sm font-semibold">{{ session('error') }}</div>
                @endif

                {{-- Peminjam --}}
                <div class="group">
                    <x-input-label for="user_id" value="Peminjam" class="text-[10px] font-black uppercase text-muted-foreground mb-2" />
                    <div class="relative">
                        <span class="absolute left-4 top-3 text-muted-foreground">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        </span>
                        <select name="user_id" id="user_id"
                            class="block w-full pl-12 pr-4 py-3 bg-slate-100 dark:bg-slate-800 border-none rounded-2xl text-foreground focus:ring-4 focus:ring-amber-500/20 focus:bg-white dark:focus:bg-slate-800 transition-all font-bold appearance-none cursor-pointer" required>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id', $peminjaman->user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
                </div>

                {{-- Tanggal --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="group">
                        <x-input-label for="tanggal_pinjam" value="Tanggal Pinjam" class="text-[10px] font-black uppercase text-muted-foreground mb-2" />
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-muted-foreground">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </span>
                            <input id="tanggal_pinjam" name="tanggal_pinjam" type="date"
                                class="block w-full pl-12 pr-4 py-3 bg-slate-100 dark:bg-slate-800 border-none rounded-2xl text-foreground focus:ring-4 focus:ring-amber-500/20 focus:bg-white dark:focus:bg-slate-800 transition-all font-bold"
                                value="{{ old('tanggal_pinjam', \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('Y-m-d')) }}" required />
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('tanggal_pinjam')" />
                    </div>

                    <div class="group">
                        <x-input-label for="tanggal_kembali" value="Batas Kembali" class="text-[10px] font-black uppercase text-muted-foreground mb-2" />
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-muted-foreground">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </span>
                            <input id="tanggal_kembali" name="tanggal_kembali" type="date"
                                class="block w-full pl-12 pr-4 py-3 bg-slate-100 dark:bg-slate-800 border-none rounded-2xl text-foreground focus:ring-4 focus:ring-amber-500/20 focus:bg-white dark:focus:bg-slate-800 transition-all font-bold"
                                value="{{ old('tanggal_kembali', \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('Y-m-d')) }}" required />
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('tanggal_kembali')" />
                    </div>
                </div>

                {{-- Status --}}
                <div class="group">
                    <x-input-label for="status" value="Status Peminjaman" class="text-[10px] font-black uppercase text-muted-foreground mb-2" />
                    <div class="relative">
                        <span class="absolute left-4 top-3 text-muted-foreground">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </span>
                        <select name="status" id="status"
                            class="block w-full pl-12 pr-4 py-3 bg-slate-100 dark:bg-slate-800 border-none rounded-2xl text-foreground focus:ring-4 focus:ring-amber-500/20 focus:bg-white dark:focus:bg-slate-800 transition-all font-bold appearance-none cursor-pointer" required>
                            @foreach(['menunggu', 'disetujui', 'ditolak', 'dikembalikan'] as $s)
                                <option value="{{ $s }}" {{ old('status', $peminjaman->status) === $s ? 'selected' : '' }}>
                                    {{ ucfirst($s) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('status')" />
                </div>

                <div class="flex items-center justify-end gap-6 pt-8 border-t border-border">
                    <a href="{{ route('peminjamans.index') }}" class="text-xs font-black uppercase tracking-widest text-muted-foreground hover:text-foreground transition-all">Batal</a>
                    <button type="submit" class="px-8 py-3 bg-amber-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest shadow-xl shadow-amber-500/20 hover:shadow-amber-500/40 hover:-translate-y-0.5 active:translate-y-0 transition-all">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
