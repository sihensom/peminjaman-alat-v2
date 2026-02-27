<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-slate-50 dark:bg-slate-950 p-6">
        <div class="w-full max-w-lg bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl overflow-hidden border-none text-center">
            <div class="p-10 lg:p-16">
                <div class="mb-12">
                    <div class="inline-flex items-center gap-3 mb-8">
                        <div class="p-4 bg-amber-500 rounded-3xl text-white shadow-2xl shadow-amber-500/30 transform -rotate-6">
                            <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        </div>
                    </div>
                    <h3 class="text-3xl font-black text-foreground tracking-tighter uppercase">Validasi Sandi</h3>
                    <p class="text-sm text-muted-foreground font-bold mt-3 leading-relaxed max-w-xs mx-auto">Keamanan diutamakan. Masukkan kembali kata sandi Anda untuk konfirmasi akses.</p>
                </div>

                <form method="POST" action="{{ route('password.confirm') }}" class="space-y-8 text-left">
                    @csrf

                    <!-- Password -->
                    <div class="space-y-2">
                        <label for="password" class="text-[10px] font-black uppercase tracking-widest text-muted-foreground px-1">Sandi Anda</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password" 
                            class="w-full px-5 py-4 bg-slate-100 dark:bg-slate-800 border-none rounded-2xl focus:ring-4 focus:ring-indigo-500/20 focus:bg-white dark:focus:bg-slate-800 transition-all font-bold text-sm text-foreground"
                            placeholder="••••••••">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-5 bg-indigo-600 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-2xl shadow-indigo-600/30 hover:shadow-indigo-600/50 hover:-translate-y-1 transition-all active:scale-95 duration-300">
                            Konfirmasi Akses
                        </button>
                    </div>
                </form>

                <div class="mt-12 text-center pt-8 border-t border-slate-100 dark:border-slate-800">
                    <a href="{{ route('dashboard') }}" class="text-[10px] font-black uppercase tracking-[0.3em] text-muted-foreground hover:text-indigo-600 transition-all">
                        Batalkan Sesi
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
