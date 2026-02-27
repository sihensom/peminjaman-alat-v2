<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-slate-50 dark:bg-slate-950 p-6">
        <div class="w-full max-w-lg bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl overflow-hidden border-none text-center">
            <div class="p-10 lg:p-16">
                <div class="mb-12">
                    <div class="inline-flex items-center gap-3 mb-8">
                        <div class="p-4 bg-indigo-600 rounded-3xl text-white shadow-2xl shadow-indigo-600/30 transform rotate-3">
                            <x-application-logo class="w-10 h-10 fill-current" />
                        </div>
                    </div>
                    <h3 class="text-3xl font-black text-foreground tracking-tighter uppercase">Reset Sandi</h3>
                    <p class="text-sm text-muted-foreground font-bold mt-3 leading-relaxed">Masukkan detail baru untuk mengamankan kembali akses akun Anda.</p>
                </div>

                <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Address -->
                    <div class="space-y-2 text-left">
                        <label for="email" class="text-[10px] font-black uppercase tracking-widest text-muted-foreground px-1">Email Akun</label>
                        <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" 
                            class="w-full px-5 py-4 bg-slate-100 dark:bg-slate-800 border-none rounded-2xl focus:ring-4 focus:ring-indigo-500/20 focus:bg-white dark:focus:bg-slate-800 transition-all font-bold text-sm text-foreground">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="space-y-2 text-left">
                        <label for="password" class="text-[10px] font-black uppercase tracking-widest text-muted-foreground px-1">Sandi Baru</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password" 
                            class="w-full px-5 py-4 bg-slate-100 dark:bg-slate-800 border-none rounded-2xl focus:ring-4 focus:ring-indigo-500/20 focus:bg-white dark:focus:bg-slate-800 transition-all font-bold text-sm text-foreground"
                            placeholder="••••••••">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-2 text-left">
                        <label for="password_confirmation" class="text-[10px] font-black uppercase tracking-widest text-muted-foreground px-1">Ulangi Sandi</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" 
                            class="w-full px-5 py-4 bg-slate-100 dark:bg-slate-800 border-none rounded-2xl focus:ring-4 focus:ring-indigo-500/20 focus:bg-white dark:focus:bg-slate-800 transition-all font-bold text-sm text-foreground"
                            placeholder="••••••••">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="w-full py-5 bg-indigo-600 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-2xl shadow-indigo-600/30 hover:shadow-indigo-600/50 hover:-translate-y-1 transition-all active:scale-95 duration-300">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
