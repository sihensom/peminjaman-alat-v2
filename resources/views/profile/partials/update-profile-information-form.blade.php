<section class="space-y-8">
    <header class="flex items-center gap-4">
        <div class="w-1.5 h-10 bg-indigo-600 rounded-full"></div>
        <div>
            <h2 class="text-xl font-black text-foreground uppercase tracking-tight">
                {{ __('Informasi Profil') }}
            </h2>
            <p class="text-[10px] font-bold text-muted-foreground uppercase opacity-60 tracking-widest mt-1">
                {{ __("Kelola identitas digital dan alamat kontak Anda.") }}
            </p>
        </div>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-10 space-y-6">
        @csrf
        @method('patch')

        <div class="space-y-2">
            <label for="name" class="text-[10px] font-black uppercase text-muted-foreground tracking-widest px-1">Nama Lengkap</label>
            <input id="name" name="name" type="text" 
                class="w-full px-5 py-4 bg-slate-100 dark:bg-slate-800 border-none rounded-2xl focus:ring-4 focus:ring-indigo-500/20 focus:bg-white dark:focus:bg-slate-800 transition-all font-bold text-sm text-foreground" 
                value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div class="space-y-2">
            <label for="email" class="text-[10px] font-black uppercase text-muted-foreground tracking-widest px-1">Alamat Email</label>
            <input id="email" name="email" type="email" 
                class="w-full px-5 py-4 bg-slate-100 dark:bg-slate-800 border-none rounded-2xl focus:ring-4 focus:ring-indigo-500/20 focus:bg-white dark:focus:bg-slate-800 transition-all font-bold text-sm text-foreground" 
                value="{{ old('email', $user->email) }}" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="p-6 bg-amber-50 dark:bg-amber-900/20 rounded-[1.5rem] mt-6">
                    <p class="text-xs font-bold text-amber-800 dark:text-amber-400">
                        {{ __('Alamat email Anda belum diverifikasi.') }}
                        <button form="send-verification" class="ml-2 px-3 py-1 bg-amber-200 dark:bg-amber-800 rounded-lg text-amber-900 dark:text-amber-100 hover:bg-amber-300 transition-colors uppercase text-[9px] font-black">
                            {{ __('Kirim Ulang') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-3 text-[10px] font-black uppercase text-emerald-600 tracking-widest">
                            {{ __('Link verifikasi baru telah dikirim.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-6 pt-6">
            <button type="submit" class="px-10 py-4 bg-indigo-600 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl shadow-indigo-600/20 hover:shadow-indigo-600/40 hover:-translate-y-1 transition-all active:scale-95">
                {{ __('Simpan Data') }}
            </button>

            @if (session('status') === 'profile-updated')
                <div class="px-4 py-2 bg-emerald-50 dark:bg-emerald-900/30 rounded-xl" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)">
                    <span class="text-[9px] font-black text-emerald-600 uppercase tracking-widest">{{ __('Berhasil Diperbarui') }}</span>
                </div>
            @endif
        </div>
    </form>
</section>
