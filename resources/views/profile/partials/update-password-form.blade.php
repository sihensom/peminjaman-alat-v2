<section class="space-y-8">
    <header class="flex items-center gap-4">
        <div class="w-1.5 h-10 bg-amber-500 rounded-full"></div>
        <div>
            <h2 class="text-xl font-black text-foreground uppercase tracking-tight">
                {{ __('Ganti Kata Sandi') }}
            </h2>
            <p class="text-[10px] font-bold text-muted-foreground uppercase opacity-60 tracking-widest mt-1">
                {{ __('Gunakan kombinasi karakter yang kuat untuk keamanan optimal.') }}
            </p>
        </div>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-10 space-y-6">
        @csrf
        @method('put')

        <div class="space-y-2">
            <label for="update_password_current_password" class="text-[10px] font-black uppercase text-muted-foreground tracking-widest px-1">Sandi Saat Ini</label>
            <input id="update_password_current_password" name="current_password" type="password" 
                class="w-full px-5 py-4 bg-slate-100 dark:bg-slate-800 border-none rounded-2xl focus:ring-4 focus:ring-indigo-500/20 focus:bg-white dark:focus:bg-slate-800 transition-all font-bold text-sm text-foreground" 
                autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="space-y-2">
            <label for="update_password_password" class="text-[10px] font-black uppercase text-muted-foreground tracking-widest px-1">Kata Sandi Baru</label>
            <input id="update_password_password" name="password" type="password" 
                class="w-full px-5 py-4 bg-slate-100 dark:bg-slate-800 border-none rounded-2xl focus:ring-4 focus:ring-indigo-500/20 focus:bg-white dark:focus:bg-slate-800 transition-all font-bold text-sm text-foreground" 
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div class="space-y-2">
            <label for="update_password_password_confirmation" class="text-[10px] font-black uppercase text-muted-foreground tracking-widest px-1">Konfirmasi Sandi</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" 
                class="w-full px-5 py-4 bg-slate-100 dark:bg-slate-800 border-none rounded-2xl focus:ring-4 focus:ring-indigo-500/20 focus:bg-white dark:focus:bg-slate-800 transition-all font-bold text-sm text-foreground" 
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-6 pt-6">
             <button type="submit" class="px-10 py-4 bg-amber-600 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl shadow-amber-600/20 hover:shadow-amber-600/40 hover:-translate-y-1 transition-all active:scale-95">
                {{ __('Ubah Kata Sandi') }}
            </button>

            @if (session('status') === 'password-updated')
                <div class="px-4 py-2 bg-emerald-50 dark:bg-emerald-900/30 rounded-xl" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)">
                    <span class="text-[9px] font-black text-emerald-600 uppercase tracking-widest">{{ __('Sandi Diperbarui') }}</span>
                </div>
            @endif
        </div>
    </form>
</section>
