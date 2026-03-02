<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-indigo-500/10 rounded-lg text-indigo-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
            </div>
            <div>
                <h2 class="text-xl font-black text-foreground tracking-tight">Tambah User</h2>
                <p class="text-xs text-muted-foreground font-medium">Daftarkan pengguna baru ke sistem</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="card-premium overflow-hidden bg-gradient-to-b from-card to-muted/20">
            <div class="h-1.5 bg-gradient-to-r from-indigo-500 to-blue-500"></div>
            <form method="POST" action="{{ route('users.store') }}" class="p-8 space-y-8">
                @csrf
                <div class="space-y-6">
                    <div class="group">
                        <x-input-label for="name" value="Nama Lengkap" class="text-[10px] font-black uppercase text-muted-foreground mb-2" />
                        <input id="name" name="name" type="text" class="block w-full px-4 py-3 bg-slate-100 dark:bg-slate-800 border-none rounded-2xl text-foreground focus:ring-4 focus:ring-indigo-500/20 transition-all font-bold" value="{{ old('name') }}" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>
                    <div class="group">
                        <x-input-label for="email" value="Email" class="text-[10px] font-black uppercase text-muted-foreground mb-2" />
                        <input id="email" name="email" type="email" class="block w-full px-4 py-3 bg-slate-100 dark:bg-slate-800 border-none rounded-2xl text-foreground focus:ring-4 focus:ring-indigo-500/20 transition-all font-bold" value="{{ old('email') }}" required />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>
                    <div class="group">
                        <x-input-label for="role" value="Role / Hak Akses" class="text-[10px] font-black uppercase text-muted-foreground mb-2" />
                        <select name="role" id="role" class="block w-full px-4 py-3 bg-slate-100 dark:bg-slate-800 border-none rounded-2xl text-foreground focus:ring-4 focus:ring-indigo-500/20 transition-all font-bold appearance-none cursor-pointer" required>
                            <option value="peminjam" {{ old('role') == 'peminjam' ? 'selected' : '' }}>Peminjam</option>
                            <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('role')" />
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="group">
                            <x-input-label for="password" value="Password" class="text-[10px] font-black uppercase text-muted-foreground mb-2" />
                            <div class="relative">
                                <input id="password" name="password" type="password" class="block w-full px-4 py-3 pr-12 bg-slate-100 dark:bg-slate-800 border-none rounded-2xl text-foreground focus:ring-4 focus:ring-indigo-500/20 transition-all font-bold" required />
                                <button type="button" onclick="togglePassword('password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-muted-foreground hover:text-foreground transition-colors"><svg class="h-5 w-5 eye-off" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg><svg class="h-5 w-5 eye-on hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg></button>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('password')" />
                        </div>
                        <div class="group">
                            <x-input-label for="password_confirmation" value="Konfirmasi Password" class="text-[10px] font-black uppercase text-muted-foreground mb-2" />
                            <div class="relative">
                                <input id="password_confirmation" name="password_confirmation" type="password" class="block w-full px-4 py-3 pr-12 bg-slate-100 dark:bg-slate-800 border-none rounded-2xl text-foreground focus:ring-4 focus:ring-indigo-500/20 transition-all font-bold" required />
                                <button type="button" onclick="togglePassword('password_confirmation', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-muted-foreground hover:text-foreground transition-colors"><svg class="h-5 w-5 eye-off" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg><svg class="h-5 w-5 eye-on hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-6 pt-10 mt-10">
                    <a href="{{ route('users.index') }}" class="text-xs font-black uppercase tracking-widest text-muted-foreground hover:text-foreground transition-all">Batalkan</a>
                    <button type="submit" class="px-8 py-3 bg-indigo-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest shadow-xl shadow-indigo-500/20 hover:shadow-indigo-500/40 hover:-translate-y-0.5 active:translate-y-0 transition-all">Daftarkan User</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
