<div class="flex flex-col h-screen w-16 md:w-64 bg-white dark:bg-slate-950 transition-all duration-300 overflow-hidden group hover:w-64 shadow-2xl shadow-slate-200/50 dark:shadow-none z-50">
    <!-- Role-based Accent Header -->
    @php
        $roleColor = [
            'admin' => 'bg-indigo-600',
            'petugas' => 'bg-blue-600',
            'peminjam' => 'bg-emerald-600'
        ][Auth::user()->role] ?? 'bg-primary';
    @endphp

    <div class="flex items-center h-16 px-4 {{ $roleColor }} text-primary-foreground shrink-0 shadow-lg z-10">
        <div class="p-1.5 bg-white/20 rounded-lg">
            <x-application-logo class="h-6 w-auto fill-current" />
        </div>
        <div class="ml-3 overflow-hidden whitespace-nowrap hidden md:block">
            <h1 class="font-black text-sm uppercase tracking-tighter leading-none">SIPENAL</h1>
            <p class="text-[10px] opacity-80 font-medium">Sistem Peminjaman Alat</p>
        </div>
    </div>

    <div class="flex-1 overflow-y-auto py-6 custom-scrollbar px-3">
        <nav class="space-y-6">
            <!-- Dashboard (Semua Role) -->
            <div>
                <p class="px-3 mb-2 text-[10px] font-black text-muted-foreground uppercase tracking-[0.2em] hidden md:block">Menu Utama</p>
                <div class="space-y-1">
                    <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="layout-dashboard">
                        Dashboard
                    </x-sidebar-link>
                </div>
            </div>

            {{-- ============================================= --}}
            {{-- ADMIN SIDEBAR --}}
            {{-- ============================================= --}}
            @if(Auth::user()->role === 'admin')
                <div>
                    <p class="px-3 mb-2 text-[10px] font-black text-muted-foreground uppercase tracking-[0.2em] hidden md:block">Manajemen</p>
                    <div class="space-y-1">
                        <x-sidebar-link :href="route('users.index')" :active="request()->routeIs('users.*')" icon="users">
                            Kelola User
                        </x-sidebar-link>
                        <x-sidebar-link :href="route('kategoris.index')" :active="request()->routeIs('kategoris.*')" icon="tags">
                            Kategori
                        </x-sidebar-link>
                        <x-sidebar-link :href="route('alats.index')" :active="request()->routeIs('alats.*')" icon="box">
                            Data Alat
                        </x-sidebar-link>
                    </div>
                </div>
                <div>
                    <p class="px-3 mb-2 text-[10px] font-black text-muted-foreground uppercase tracking-[0.2em] hidden md:block">Transaksi</p>
                    <div class="space-y-1">
                        <x-sidebar-link :href="route('peminjamans.index')" :active="request()->routeIs('peminjamans.*')" icon="calendar-clock">
                            Peminjaman
                        </x-sidebar-link>
                        <x-sidebar-link :href="route('pengembalians.index')" :active="request()->routeIs('pengembalians.*')" icon="refresh-cw">
                            Pengembalian
                        </x-sidebar-link>
                    </div>
                </div>
                <div>
                    <p class="px-3 mb-2 text-[10px] font-black text-muted-foreground uppercase tracking-[0.2em] hidden md:block">Sistem</p>
                    <div class="space-y-1">
                        <x-sidebar-link :href="route('reports.audit')" :active="request()->routeIs('reports.audit')" icon="shield-check">
                            Log Aktifitas
                        </x-sidebar-link>
                    </div>
                </div>
            @endif

            {{-- ============================================= --}}
            {{-- PETUGAS SIDEBAR --}}
            {{-- ============================================= --}}
            @if(Auth::user()->role === 'petugas')
                <div>
                    <p class="px-3 mb-2 text-[10px] font-black text-muted-foreground uppercase tracking-[0.2em] hidden md:block">Tugas</p>
                    <div class="space-y-1">
                        <x-sidebar-link :href="route('petugas.peminjamans.index')" :active="request()->routeIs('petugas.peminjamans.*')" icon="calendar-clock">
                            Peminjaman
                        </x-sidebar-link>
                        <x-sidebar-link :href="route('petugas.pengembalians.index')" :active="request()->routeIs('petugas.pengembalians.*')" icon="refresh-cw">
                            Pengembalian
                        </x-sidebar-link>
                    </div>
                </div>
                <div>
                    <p class="px-3 mb-2 text-[10px] font-black text-muted-foreground uppercase tracking-[0.2em] hidden md:block">Laporan</p>
                    <div class="space-y-1">
                        <x-sidebar-link :href="route('reports.monthly')" :active="request()->routeIs('reports.monthly')" icon="file-text">
                            Cetak Laporan
                        </x-sidebar-link>
                    </div>
                </div>
            @endif

            {{-- ============================================= --}}
            {{-- PEMINJAM SIDEBAR --}}
            {{-- ============================================= --}}
            @if(Auth::user()->role === 'peminjam')
                <div>
                    <p class="px-3 mb-2 text-[10px] font-black text-muted-foreground uppercase tracking-[0.2em] hidden md:block">Inventori</p>
                    <div class="space-y-1">
                        <x-sidebar-link :href="route('peminjam.alats.index')" :active="request()->routeIs('peminjam.alats.*')" icon="box">
                            Daftar Alat
                        </x-sidebar-link>
                    </div>
                </div>
                <div>
                    <p class="px-3 mb-2 text-[10px] font-black text-muted-foreground uppercase tracking-[0.2em] hidden md:block">Transaksi Saya</p>
                    <div class="space-y-1">
                        <x-sidebar-link :href="route('peminjam.peminjamans.index')" :active="request()->routeIs('peminjam.peminjamans.*')" icon="calendar-clock">
                            Peminjaman Saya
                        </x-sidebar-link>
                        <x-sidebar-link :href="route('peminjam.pengembalians.index')" :active="request()->routeIs('peminjam.pengembalians.*')" icon="refresh-cw">
                            Pengembalian Saya
                        </x-sidebar-link>
                    </div>
                </div>
            @endif
        </nav>
    </div>

    <!-- User Profile Footer -->
    <div class="p-6 bg-slate-50 dark:bg-slate-900 shrink-0">
        <div class="flex items-center">
            <div class="h-10 w-10 rounded-2xl {{ $roleColor }} text-white flex items-center justify-center font-black text-xs shrink-0 shadow-lg">
                {{ substr(Auth::user()->name, 0, 2) }}
            </div>
            <div class="ml-3 hidden md:block overflow-hidden">
                <p class="text-xs font-bold text-foreground truncate">{{ Auth::user()->name }}</p>
                <p class="text-[10px] text-muted-foreground capitalize">{{ Auth::user()->role }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="ml-auto hidden md:block">
                @csrf
                <button type="submit" class="p-1.5 text-muted-foreground hover:text-destructive transition-colors">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>
