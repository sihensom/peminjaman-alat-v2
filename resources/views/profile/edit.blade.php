<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
             <div class="p-3 bg-indigo-600 rounded-2xl text-white shadow-xl shadow-indigo-600/20">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-black text-foreground tracking-tight uppercase">Pengaturan Akun</h2>
                <p class="text-[10px] text-muted-foreground font-black uppercase tracking-widest opacity-60">Personalisasi & Keamanan</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto space-y-10">
        <!-- Profile Overview Block -->
        <div class="card-premium p-10 bg-white dark:bg-slate-900 overflow-hidden relative border-none shadow-2xl shadow-slate-200/50 dark:shadow-none flex flex-col md:flex-row items-center gap-10">
            <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-600/5 rounded-full -mr-32 -mt-32"></div>
            
            <div class="relative z-10 shrink-0">
                <div class="h-28 w-28 rounded-[2rem] bg-indigo-600 text-white flex items-center justify-center text-4xl font-black shadow-2xl shadow-indigo-600/40 transform -rotate-3">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>

            <div class="relative z-10 flex-1 text-center md:text-left">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-indigo-50 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300 rounded-lg text-[10px] font-black uppercase tracking-widest mb-4">
                    {{ Auth::user()->role }}
                </div>
                <h3 class="text-3xl font-black text-foreground tracking-tight mb-2 uppercase">{{ Auth::user()->name }}</h3>
                <p class="text-sm text-muted-foreground font-bold italic tracking-wide">Member Aktif sejak {{ Auth::user()->created_at->translatedFormat('d F Y') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">
            <!-- Navigation Block -->
            <div class="lg:col-span-1 space-y-4">
                <p class="text-[10px] font-black uppercase text-muted-foreground tracking-[0.2em] mb-6 px-1">Menu Navigasi</p>
                <div class="space-y-2">
                    <div class="p-4 bg-indigo-600 text-white rounded-2xl flex items-center gap-4 shadow-xl shadow-indigo-600/20">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        <span class="text-xs font-black uppercase tracking-[0.1em]">Informasi Profil</span>
                    </div>
                </div>
            </div>

            <!-- Content Area: Blocks of Settings -->
            <div class="lg:col-span-3 space-y-10">
                <div class="card-premium p-10 bg-white dark:bg-slate-900 border-none shadow-xl shadow-slate-200/30 dark:shadow-none">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <div class="card-premium p-10 bg-white dark:bg-slate-900 border-none shadow-xl shadow-slate-200/30 dark:shadow-none">
                    @include('profile.partials.update-password-form')
                </div>

                <div class="card-premium p-10 bg-white dark:bg-slate-900 border-none shadow-xl shadow-slate-200/30 dark:shadow-none">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
