<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-slate-50 dark:bg-slate-950 p-6">
        <div class="w-full max-w-lg bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl overflow-hidden border-none">
            <div class="p-10 lg:p-16">
                <div class="text-center mb-12">
                    <div class="inline-flex items-center gap-3 mb-8">
                        <div class="p-4 bg-indigo-600 rounded-3xl text-white shadow-2xl shadow-indigo-600/30 transform -rotate-3">
                            <x-application-logo class="w-10 h-10 fill-current" />
                        </div>
                    </div>
                    <h3 class="text-3xl font-black text-foreground tracking-tighter uppercase">Lupa Sandi</h3>
                    <p class="text-sm text-muted-foreground font-bold mt-3 max-w-xs mx-auto leading-relaxed italic">Masukkan email terdaftar untuk menerima tautan bantuan pemulihan.</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-8" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}" class="space-y-8">
                    @csrf

                    <!-- Email Address -->
                    <div class="space-y-2">
                        <label for="email" class="text-[10px] font-black uppercase tracking-widest text-muted-foreground px-1">Email Pemulihan</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                            class="w-full px-5 py-4 bg-slate-100 dark:bg-slate-800 border-none rounded-2xl focus:ring-4 focus:ring-indigo-500/20 focus:bg-white dark:focus:bg-slate-800 transition-all font-bold text-sm text-foreground"
                            placeholder="nama@email.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-5 bg-indigo-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest shadow-2xl shadow-indigo-600/30 hover:shadow-indigo-600/50 hover:-translate-y-1 transition-all">
                            Kirim Bantuan Reset
                        </button>
                    </div>
                </form>

                <div class="mt-12 text-center pt-10 border-t border-slate-100 dark:border-slate-800">
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-3 text-[10px] font-black uppercase tracking-[0.2em] text-muted-foreground hover:text-indigo-600 transition-all group">
                        <svg class="h-4 w-4 transform group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                        Kembali Masuk
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
