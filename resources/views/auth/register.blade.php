<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-slate-50 dark:bg-slate-950 p-6">
        <div class="w-full max-w-4xl bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl overflow-hidden grid grid-cols-1 lg:grid-cols-2 border-none">
            
            <!-- Left Panel: Visual/Branding -->
            <div class="hidden lg:flex flex-col justify-between p-16 bg-gradient-to-br from-indigo-700 to-indigo-900 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 -mr-24 -mt-24 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -ml-24 -mb-24 w-80 h-80 bg-indigo-400/20 rounded-full blur-3xl"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-16 text-white">
                        <div class="p-3 bg-white/10 backdrop-blur-md rounded-2xl">
                            <x-application-logo class="w-8 h-8 fill-current" />
                        </div>
                        <h1 class="text-2xl font-black tracking-tighter uppercase">SIPENAL</h1>
                    </div>
                    
                    <h2 class="text-4xl font-extrabold leading-tight mb-8">Mulai Petualangan <br/> Inventori Anda.</h2>
                    <p class="text-indigo-100/70 font-bold max-w-sm leading-relaxed">Bergabunglah dengan komunitas praktikan dan peneliti dalam pengelolaan alat yang lebih modern dan transparan.</p>
                </div>

                <div class="relative z-10 flex items-center gap-4 py-4 px-6 bg-white/5 backdrop-blur-xl rounded-2xl border-none">
                     <div class="h-10 w-10 bg-indigo-500 rounded-full flex items-center justify-center shadow-lg">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                     </div>
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-80">Sistem Keamanan Berlapis</p>
                </div>
            </div>

            <!-- Right Panel: Form -->
            <div class="p-10 lg:p-16 flex flex-col justify-center">
                <div class="mb-12 lg:hidden text-center">
                     <div class="inline-flex items-center gap-3 mb-4">
                        <div class="p-3 bg-indigo-600 rounded-2xl text-white shadow-xl shadow-indigo-600/20">
                            <x-application-logo class="w-8 h-8 fill-current" />
                        </div>
                    </div>
                </div>

                <div class="mb-10 text-center lg:text-left">
                    <h3 class="text-3xl font-black text-foreground tracking-tight">Pendaftaran Akun</h3>
                    <p class="text-sm text-muted-foreground font-bold mt-2">Lengkapi data diri Anda untuk mendaftar.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div class="space-y-2">
                        <label for="name" class="text-[10px] font-black uppercase tracking-widest text-muted-foreground">Nama Lengkap</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" 
                            class="w-full px-5 py-4 bg-slate-100 dark:bg-slate-800 border-none rounded-2xl focus:ring-4 focus:ring-indigo-500/20 focus:bg-white dark:focus:bg-slate-800 transition-all font-bold text-sm text-foreground"
                            placeholder="Contoh: John Doe">
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    <!-- Email Address -->
                    <div class="space-y-2">
                        <label for="email" class="text-[10px] font-black uppercase tracking-widest text-muted-foreground">Alamat Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" 
                            class="w-full px-5 py-4 bg-slate-100 dark:bg-slate-800 border-none rounded-2xl focus:ring-4 focus:ring-indigo-500/20 focus:bg-white dark:focus:bg-slate-800 transition-all font-bold text-sm text-foreground"
                            placeholder="nama@email.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Password -->
                        <div class="space-y-2">
                            <label for="password" class="text-[10px] font-black uppercase tracking-widest text-muted-foreground">Kata Sandi</label>
                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                class="w-full px-5 py-4 bg-slate-100 dark:bg-slate-800 border-none rounded-2xl focus:ring-4 focus:ring-indigo-500/20 focus:bg-white dark:focus:bg-slate-800 transition-all font-bold text-sm text-foreground"
                                placeholder="••••••••">
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="space-y-2">
                            <label for="password_confirmation" class="text-[10px] font-black uppercase tracking-widest text-muted-foreground">Konfirmasi</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                                class="w-full px-5 py-4 bg-slate-100 dark:bg-slate-800 border-none rounded-2xl focus:ring-4 focus:ring-indigo-500/20 focus:bg-white dark:focus:bg-slate-800 transition-all font-bold text-sm text-foreground"
                                placeholder="••••••••">
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                        </div>
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="w-full py-4 bg-indigo-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest shadow-2xl shadow-indigo-600/30 hover:shadow-indigo-600/50 hover:-translate-y-1 transition-all active:scale-95 duration-300">
                            Konfirmasi & Daftar
                        </button>
                    </div>
                </form>

                <div class="mt-12 text-center pt-8 border-t border-slate-100 dark:border-slate-800">
                    <p class="text-xs text-muted-foreground font-bold italic">Sudah punya akun? <a href="{{ route('login') }}" class="text-indigo-600 font-black hover:underline ml-1">Masuk Sekarang</a></p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
