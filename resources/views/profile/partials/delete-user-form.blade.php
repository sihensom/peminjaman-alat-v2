<section class="space-y-8">
    <header class="flex items-center gap-4">
        <div class="w-1.5 h-10 bg-red-600 rounded-full"></div>
        <div>
            <h2 class="text-xl font-black text-foreground uppercase tracking-tight">
                {{ __('Penghapusan Akun') }}
            </h2>
            <p class="text-[10px] font-bold text-muted-foreground uppercase opacity-60 tracking-widest mt-1 text-wrap max-w-lg">
                {{ __('Tindakan permanen. Semua data Anda akan dihapus selamanya dari sistem.') }}
            </p>
        </div>
    </header>

    <div class="p-6 bg-red-50 dark:bg-red-900/10 rounded-[1.5rem]">
        <button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="px-8 py-4 bg-red-600 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl shadow-red-600/20 hover:shadow-red-600/40 hover:-translate-y-1 transition-all"
        >{{ __('Ya, Hapus Akun Saya') }}</button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-10 bg-white dark:bg-slate-900 rounded-[2.5rem]">
            @csrf
            @method('delete')

            <h2 class="text-3xl font-black text-foreground tracking-tighter uppercase mb-4">
                {{ __('Konfirmasi Akhir') }}
            </h2>

            <p class="text-sm text-muted-foreground font-bold italic leading-relaxed mb-8">
                {{ __('Setelah dihapus, tidak ada jalan kembali. Masukkan kata sandi Anda untuk memvalidasi identitas sebelum penghapusan permanen.') }}
            </p>

            <div class="space-y-2">
                <label for="password" class="text-[10px] font-black uppercase text-muted-foreground tracking-widest px-1">Kata Sandi Anda</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="w-full px-5 py-4 bg-slate-100 dark:bg-slate-800 border-none rounded-2xl focus:ring-4 focus:ring-red-500/20 transition-all font-bold text-sm text-foreground"
                    placeholder="••••••••"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-12 flex flex-col sm:flex-row justify-end gap-4">
                <button type="button" x-on:click="$dispatch('close')" class="px-8 py-4 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-200 transition-all">
                    {{ __('Batalkan') }}
                </button>

                <button type="submit" class="px-8 py-4 bg-red-600 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl shadow-red-600/20 hover:shadow-red-600/40 transition-all active:scale-95">
                    {{ __('Konfirmasi Hapus') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
