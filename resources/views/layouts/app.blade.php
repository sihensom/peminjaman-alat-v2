<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Theme Script -->
        <script>
            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-foreground bg-background">
        <div class="flex h-screen overflow-hidden">
            <!-- Sidebar -->
            <x-sidebar />

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
                <!-- Top Header -->
                <header class="h-16 flex items-center justify-between px-6 bg-white dark:bg-slate-950 shrink-0 shadow-sm z-10">
                    <div class="flex items-center">
                        @isset($header)
                            <h2 class="font-semibold text-xl leading-tight">
                                {{ $header }}
                            </h2>
                        @endisset
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Theme Toggle -->
                        <x-theme-toggle />

                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border-none text-sm leading-4 font-bold rounded-xl text-muted-foreground bg-slate-50 dark:bg-slate-900 hover:text-foreground focus:outline-none transition ease-in-out duration-150">
                                    <div>{{ Auth::user()->name }}</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto p-6 bg-muted/30">
                    {{ $slot }}
                </main>
            </div>
        </div>

        <!-- =========================================
             GLOBAL TOAST NOTIFICATIONS
             ========================================= -->
        @if(session('success') || session('error') || session('warning') || session('info'))
        <div id="toast-container" class="fixed bottom-6 right-6 z-50 flex flex-col gap-3 max-w-sm w-full">

            @if(session('success'))
            <div id="toast-success" class="flex items-start gap-3 w-full bg-white dark:bg-slate-900 border border-green-200 dark:border-green-800 rounded-2xl shadow-2xl shadow-green-500/10 p-4 animate-[slideIn_0.3s_ease-out]">
                <div class="h-9 w-9 rounded-xl bg-green-500/10 flex items-center justify-center text-green-600 shrink-0">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-[10px] font-black uppercase tracking-widest text-green-600 mb-0.5">Berhasil</p>
                    <p class="text-sm font-semibold text-foreground leading-snug">{{ session('success') }}</p>
                </div>
                <button onclick="dismissToast('toast-success')" class="text-muted-foreground hover:text-foreground transition-colors shrink-0">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            @endif

            @if(session('error'))
            <div id="toast-error" class="flex items-start gap-3 w-full bg-white dark:bg-slate-900 border border-red-200 dark:border-red-800 rounded-2xl shadow-2xl shadow-red-500/10 p-4 animate-[slideIn_0.3s_ease-out]">
                <div class="h-9 w-9 rounded-xl bg-red-500/10 flex items-center justify-center text-red-600 shrink-0">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-[10px] font-black uppercase tracking-widest text-red-600 mb-0.5">Peringatan</p>
                    <p class="text-sm font-semibold text-foreground leading-snug">{{ session('error') }}</p>
                </div>
                <button onclick="dismissToast('toast-error')" class="text-muted-foreground hover:text-foreground transition-colors shrink-0">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            @endif

            @if(session('warning'))
            <div id="toast-warning" class="flex items-start gap-3 w-full bg-white dark:bg-slate-900 border border-amber-200 dark:border-amber-800 rounded-2xl shadow-2xl shadow-amber-500/10 p-4 animate-[slideIn_0.3s_ease-out]">
                <div class="h-9 w-9 rounded-xl bg-amber-500/10 flex items-center justify-center text-amber-600 shrink-0">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-[10px] font-black uppercase tracking-widest text-amber-600 mb-0.5">Perhatian</p>
                    <p class="text-sm font-semibold text-foreground leading-snug">{{ session('warning') }}</p>
                </div>
                <button onclick="dismissToast('toast-warning')" class="text-muted-foreground hover:text-foreground transition-colors shrink-0">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            @endif

            @if(session('info'))
            <div id="toast-info" class="flex items-start gap-3 w-full bg-white dark:bg-slate-900 border border-indigo-200 dark:border-indigo-800 rounded-2xl shadow-2xl shadow-indigo-500/10 p-4 animate-[slideIn_0.3s_ease-out]">
                <div class="h-9 w-9 rounded-xl bg-indigo-500/10 flex items-center justify-center text-indigo-600 shrink-0">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-[10px] font-black uppercase tracking-widest text-indigo-600 mb-0.5">Informasi</p>
                    <p class="text-sm font-semibold text-foreground leading-snug">{{ session('info') }}</p>
                </div>
                <button onclick="dismissToast('toast-info')" class="text-muted-foreground hover:text-foreground transition-colors shrink-0">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            @endif

        </div>
        @endif
        <script>
            function togglePassword(inputId, btn) {
                const input = document.getElementById(inputId);
                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                btn.querySelector('.eye-off').classList.toggle('hidden', isPassword);
                btn.querySelector('.eye-on').classList.toggle('hidden', !isPassword);
            }

            // Toast notification system
            function dismissToast(id) {
                const el = document.getElementById(id);
                if (el) {
                    el.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                    el.style.opacity = '0';
                    el.style.transform = 'translateX(100%)';
                    setTimeout(() => el.remove(), 300);
                }
            }

            // Auto-dismiss all toasts after 4.5 seconds
            document.addEventListener('DOMContentLoaded', function() {
                const toastIds = ['toast-success', 'toast-error', 'toast-warning', 'toast-info'];
                toastIds.forEach(id => {
                    const el = document.getElementById(id);
                    if (el) setTimeout(() => dismissToast(id), 4500);
                });
            });
        </script>
        <style>
            @@keyframes slideIn {
                from { opacity: 0; transform: translateX(100%); }
                to   { opacity: 1; transform: translateX(0); }
            }
        </style>
    </body>
</html>
