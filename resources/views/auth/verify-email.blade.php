<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-slate-50 dark:bg-slate-950 p-6">
        <div class="w-full max-w-lg bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl overflow-hidden border-none text-center">
            <div class="p-10 lg:p-16">
                <div class="mb-12 text-center">
                    <div class="inline-flex items-center gap-3 mb-8">
                        <div class="p-4 bg-emerald-500 rounded-3xl text-white shadow-2xl shadow-emerald-500/30">
                            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        </div>
                    </div>
                    <h3 class="text-3xl font-black text-foreground tracking-tighter uppercase">Konfirmasi Email</h3>
                    <p class="text-sm text-muted-foreground font-bold mt-3 leading-relaxed max-w-xs mx-auto italic">Tautan verifikasi telah dikirim. Silakan periksa inbox Anda untuk instruksi aktivasi.</p>
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-10 p-6 bg-emerald-50 dark:bg-emerald-900/20 rounded-[1.5rem] shadow-inner">
                        <p class="text-[10px] font-black text-emerald-700 dark:text-emerald-400 uppercase tracking-widest text-center">
                            {{ __('Tautan baru telah berhasil dikirim ke alamat email Anda.') }}
                        </p>
                    </div>
                @endif

                <div class="space-y-6">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="w-full py-5 bg-indigo-600 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-2xl shadow-indigo-600/30 hover:shadow-indigo-600/50 hover:-translate-y-1 transition-all active:scale-95 duration-300">
                            Kirim Ulang Email
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}" class="text-center pt-6">
                        @csrf
                        <button type="submit" class="text-[10px] font-black uppercase tracking-[0.2em] text-muted-foreground hover:text-red-500 transition-colors">
                            Keluar Sementara
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
