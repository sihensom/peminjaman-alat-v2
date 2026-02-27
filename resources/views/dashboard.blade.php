<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-indigo-600 rounded-2xl shadow-xl shadow-indigo-600/20 text-white">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-black text-foreground tracking-tight uppercase">Dashboard</h2>
                    <p class="text-[10px] text-muted-foreground font-black tracking-widest uppercase opacity-60">Ringkasan Operasional & Aktivitas</p>
                </div>
            </div>
            
            <div class="hidden md:flex items-center gap-3 px-4 py-2 bg-indigo-50 dark:bg-indigo-950/30 rounded-xl">
                <div class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></div>
                <span class="text-[10px] font-black uppercase tracking-widest text-indigo-700 dark:text-indigo-400">Sistem Online</span>
            </div>
        </div>
    </x-slot>

    <div class="space-y-10">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $statConfigs = [
                    'total_users' => [
                        'color' => 'indigo', 
                        'label' => 'Total Pengguna',
                        'svg' => '<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>'
                    ],
                    'total_alats' => [
                        'color' => 'sky', 
                        'label' => 'Total Alat',
                        'svg' => '<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>'
                    ],
                    'pending_loans' => [
                        'color' => 'amber', 
                        'label' => 'Menunggu',
                        'svg' => '<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>'
                    ],
                    'active_loans' => [
                        'color' => 'emerald', 
                        'label' => 'Peminjaman Aktif',
                        'svg' => '<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>'
                    ],
                    'total_fines' => [
                        'color' => 'rose', 
                        'label' => 'Total Denda',
                        'svg' => '<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>'
                    ],
                    'my_loans' => [
                        'color' => 'violet', 
                        'label' => 'Riwayat Pinjam',
                        'svg' => '<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>'
                    ],
                    'my_pending' => [
                        'color' => 'orange', 
                        'label' => 'Status Pending',
                        'svg' => '<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>'
                    ],
                ];
            @endphp

            @foreach($stats as $key => $value)
                @if(isset($statConfigs[$key]))
                    @php $config = $statConfigs[$key]; @endphp
                    <div class="group card-premium p-6 overflow-hidden relative border-none bg-white dark:bg-slate-900 shadow-xl shadow-slate-200/50 dark:shadow-none">
                        <div class="absolute -right-6 -top-6 w-24 h-24 bg-{{ explode('-', $config['color'])[0] }}-500/5 rounded-full group-hover:scale-125 transition-transform duration-700"></div>
                        <div class="relative z-10 flex items-start justify-between">
                            <div>
                                <p class="text-[10px] font-black text-muted-foreground uppercase tracking-[0.2em] mb-4">{{ $config['label'] }}</p>
                                <h4 class="text-3xl font-black text-foreground tracking-tighter">
                                    @if($key === 'total_fines')
                                        <span class="text-sm font-bold opacity-30 mr-1">Rp</span>{{ number_format($value, 0, ',', '.') }}
                                    @else
                                        {{ $value }}
                                    @endif
                                </h4>
                            </div>
                            <div class="p-3 bg-{{ explode('-', $config['color'])[0] }}-500/10 text-{{ explode('-', $config['color'])[0] }}-600 rounded-2xl group-hover:bg-{{ explode('-', $config['color'])[0] }}-600 group-hover:text-white group-hover:shadow-lg group-hover:shadow-{{ explode('-', $config['color'])[0] }}-500/30 transition-all duration-300">
                                {!! $config['svg'] !!}
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Area -->
            <div class="lg:col-span-2 space-y-8">
                <div class="card-premium overflow-hidden bg-white dark:bg-slate-900 border-none shadow-xl shadow-slate-200/40 dark:shadow-none">
                    <div class="px-8 py-6 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-6 bg-indigo-600 rounded-full"></div>
                            <h3 class="font-black text-foreground uppercase tracking-widest text-xs">
                                {{ (Auth::user()->role === 'peminjam') ? 'Aktivitas Pinjaman Saya' : 'Daftar Antrean' }}
                            </h3>
                        </div>
                        <a href="{{ route('peminjamans.index') }}" class="px-4 py-2 bg-slate-100 dark:bg-slate-800 text-[10px] font-black uppercase tracking-widest text-slate-600 dark:text-slate-400 rounded-xl hover:bg-slate-200 dark:hover:bg-slate-700 transition-all">Lihat Semua</a>
                    </div>
                    
                    <div class="divide-y divide-slate-100 dark:divide-slate-800">
                        @php $items = (Auth::user()->role === 'peminjam') ? ($stats['active_items'] ?? []) : ($stats['pending_items'] ?? []); @endphp
                        @forelse($items as $item)
                            <div class="px-8 py-6 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-all flex items-center gap-6 group">
                                <div class="h-12 w-12 rounded-2xl {{ (Auth::user()->role === 'peminjam') ? 'bg-emerald-500/10 text-emerald-600' : 'bg-amber-500/10 text-amber-600' }} flex items-center justify-center font-black text-lg group-hover:scale-110 transition-transform">
                                    {{ (Auth::user()->role === 'peminjam') ? count($item->details) : substr($item->user->name, 0, 1) }}
                                </div>
                                
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-black text-foreground group-hover:text-indigo-600 transition-colors truncate">{{ (Auth::user()->role === 'peminjam') ? 'Tempo: '.\Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') : $item->user->name }}</h4>
                                    <div class="flex flex-wrap gap-2 mt-2">
                                        @foreach($item->details as $d)
                                            <span class="px-2 py-0.5 bg-slate-100 dark:bg-slate-800 text-[9px] font-black uppercase text-slate-500 tracking-tighter rounded-md">{{ $d->alat->nama_alat }}</span>
                                        @endforeach
                                    </div>
                                </div>

                                <a href="{{ route('peminjamans.show', $item) }}" class="h-10 w-10 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center hover:bg-indigo-600 hover:text-white hover:shadow-lg hover:shadow-indigo-500/20 transition-all">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" /></svg>
                                </a>
                            </div>
                        @empty
                            <div class="py-20 text-center">
                                <div class="w-16 h-16 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4 opacity-40">
                                    <svg class="h-8 w-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                                </div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Belum ada aktivitas terbaru.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right Area -->
            <div class="space-y-8">
                @if(Auth::user()->role === 'admin')
                    <div class="card-premium p-8 bg-white dark:bg-slate-900 border-none shadow-xl shadow-slate-200/40 dark:shadow-none">
                        <div class="flex items-center gap-3 mb-8">
                            <div class="w-2 h-4 bg-indigo-500 rounded-full"></div>
                            <h3 class="font-black text-foreground text-[10px] uppercase tracking-[0.2em]">Log Audit Terakhir</h3>
                        </div>
                        <div class="space-y-6">
                            @foreach($stats['recent_logs'] ?? [] as $log)
                                <div class="flex gap-4">
                                    <div class="h-2 w-2 rounded-full mt-1.5 shrink-0 bg-indigo-500 shadow-pulse"></div>
                                    <div class="min-w-0">
                                        <p class="text-xs font-bold text-foreground leading-tight tracking-tight">{{ $log->description }}</p>
                                        <p class="text-[10px] text-muted-foreground mt-1 uppercase font-black opacity-60">{{ $log->user->name }} • {{ $log->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <a href="{{ route('reports.audit') }}" class="mt-10 block w-full py-3 bg-slate-50 dark:bg-slate-800/50 text-center text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-indigo-600 hover:text-white transition-all border border-transparent">Panel Audit</a>
                    </div>
                @endif
                
                <div class="card-premium p-8 bg-slate-900 dark:bg-indigo-950 text-white border-none shadow-2xl relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/20 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-1000"></div>
                    <div class="relative z-10">
                        <h3 class="font-black text-xl leading-tight">Hubungi <br/>Petugas</h3>
                        <p class="text-[10px] mt-4 opacity-60 font-black uppercase tracking-widest">Helpdesk Operasional</p>
                        <div class="mt-8 flex items-center gap-3 p-3 bg-white/5 rounded-2xl border-none">
                            <div class="p-2 bg-indigo-600 rounded-lg">
                                <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                            </div>
                            <span class="text-[10px] font-black tracking-widest uppercase truncate">support@sipenal.id</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
