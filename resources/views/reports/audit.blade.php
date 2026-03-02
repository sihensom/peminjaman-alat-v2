<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-violet-500/10 rounded-lg text-violet-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-black text-foreground tracking-tight">Log Aktivitas Sistem</h2>
                <p class="text-xs text-muted-foreground font-medium">Rekaman semua aktivitas pengguna dalam sistem</p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        {{-- Filter Bar --}}
        <form method="GET" action="{{ route('reports.audit') }}" class="flex flex-wrap gap-3 items-center">
            <div class="relative">
                <span class="absolute left-3 top-2.5 text-muted-foreground">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z" /></svg>
                </span>
                <select name="filter" onchange="this.form.submit()" class="pl-9 pr-4 py-2 bg-slate-100 dark:bg-slate-800 border-none rounded-xl text-xs font-bold text-foreground focus:ring-4 focus:ring-violet-500/20 appearance-none cursor-pointer">
                    <option value="" {{ !request('filter') ? 'selected' : '' }}>Semua Aktivitas</option>
                    <optgroup label="Autentikasi">
                        <option value="login"  {{ request('filter') === 'login'  ? 'selected' : '' }}>Login</option>
                        <option value="logout" {{ request('filter') === 'logout' ? 'selected' : '' }}>Logout</option>
                    </optgroup>
                    <optgroup label="Peminjaman">
                        <option value="create_peminjaman" {{ request('filter') === 'create_peminjaman' ? 'selected' : '' }}>Buat Peminjaman</option>
                        <option value="update_peminjaman" {{ request('filter') === 'update_peminjaman' ? 'selected' : '' }}>Edit Peminjaman</option>
                        <option value="delete_peminjaman" {{ request('filter') === 'delete_peminjaman' ? 'selected' : '' }}>Hapus Peminjaman</option>
                        <option value="approve_loan"      {{ request('filter') === 'approve_loan'      ? 'selected' : '' }}>Setujui Peminjaman</option>
                        <option value="reject_peminjaman" {{ request('filter') === 'reject_peminjaman' ? 'selected' : '' }}>Tolak Peminjaman</option>
                    </optgroup>
                    <optgroup label="Pengembalian">
                        <option value="create_pengembalian" {{ request('filter') === 'create_pengembalian' ? 'selected' : '' }}>Proses Pengembalian</option>
                        <option value="update_pengembalian" {{ request('filter') === 'update_pengembalian' ? 'selected' : '' }}>Edit Pengembalian</option>
                        <option value="delete_pengembalian" {{ request('filter') === 'delete_pengembalian' ? 'selected' : '' }}>Hapus Pengembalian</option>
                        <option value="process_return"     {{ request('filter') === 'process_return'     ? 'selected' : '' }}>Proses Kembali (Service)</option>
                    </optgroup>
                    <optgroup label="Inventaris">
                        <option value="create_alat" {{ request('filter') === 'create_alat' ? 'selected' : '' }}>Tambah Alat</option>
                        <option value="update_alat" {{ request('filter') === 'update_alat' ? 'selected' : '' }}>Edit Alat</option>
                        <option value="delete_alat" {{ request('filter') === 'delete_alat' ? 'selected' : '' }}>Hapus Alat</option>
                        <option value="create_kategori" {{ request('filter') === 'create_kategori' ? 'selected' : '' }}>Tambah Kategori</option>
                        <option value="update_kategori" {{ request('filter') === 'update_kategori' ? 'selected' : '' }}>Edit Kategori</option>
                        <option value="delete_kategori" {{ request('filter') === 'delete_kategori' ? 'selected' : '' }}>Hapus Kategori</option>
                    </optgroup>
                    <optgroup label="Akun">
                        <option value="create_user" {{ request('filter') === 'create_user' ? 'selected' : '' }}>Buat Akun</option>
                        <option value="update_user" {{ request('filter') === 'update_user' ? 'selected' : '' }}>Edit Akun</option>
                        <option value="delete_user" {{ request('filter') === 'delete_user' ? 'selected' : '' }}>Hapus Akun</option>
                    </optgroup>
                </select>
            </div>

            @if(request('filter'))
                <a href="{{ route('reports.audit') }}" class="px-3 py-2 bg-muted hover:bg-border text-foreground rounded-xl text-xs font-bold transition-all">
                    Reset Filter
                </a>
            @endif

            <span class="ml-auto text-xs text-muted-foreground font-semibold">
                {{ $logs->total() }} record ditemukan
            </span>
        </form>

        {{-- Table --}}
        <div class="card-premium overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-muted/50 text-muted-foreground uppercase text-[10px] font-black tracking-widest">
                        <tr>
                            <th class="px-6 py-4">Waktu</th>
                            <th class="px-6 py-4">Pengguna</th>
                            <th class="px-6 py-4">Aksi</th>
                            <th class="px-6 py-4">Keterangan</th>
                            <th class="px-6 py-4">IP Address</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse($logs as $log)
                            @php
                                $actionColors = [
                                    'login'  => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300',
                                    'logout' => 'bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-300',
                                    'approve_loan'        => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300',
                                    'process_return'      => 'bg-teal-100 text-teal-700 dark:bg-teal-900/40 dark:text-teal-300',
                                    'create_pengembalian' => 'bg-teal-100 text-teal-700 dark:bg-teal-900/40 dark:text-teal-300',
                                    'reject_peminjaman'   => 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300',
                                    'delete_peminjaman'   => 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300',
                                    'delete_pengembalian' => 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300',
                                    'delete_alat'         => 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300',
                                    'delete_kategori'     => 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300',
                                    'delete_user'         => 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300',
                                ];
                                $defaultColor = str_starts_with($log->action, 'create_') ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300'
                                              : (str_starts_with($log->action, 'update_') ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300'
                                              : 'bg-violet-100 text-violet-700 dark:bg-violet-900/40 dark:text-violet-300');
                                $color = $actionColors[$log->action] ?? $defaultColor;
                            @endphp
                            <tr class="hover:bg-muted/30 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-xs font-bold text-foreground">{{ $log->created_at->format('d M Y') }}</div>
                                    <div class="text-[10px] text-muted-foreground font-mono">{{ $log->created_at->format('H:i:s') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="h-7 w-7 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center text-[10px] font-black text-slate-600 dark:text-slate-300 uppercase">
                                            {{ substr($log->user->name ?? 'S', 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-xs font-bold text-foreground">{{ $log->user->name ?? 'System' }}</div>
                                            <div class="text-[10px] text-muted-foreground uppercase tracking-tight">{{ $log->user->role ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-tight {{ $color }}">
                                        {{ str_replace('_', ' ', $log->action) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-xs text-muted-foreground max-w-xs">{{ $log->description }}</td>
                                <td class="px-6 py-4">
                                    <span class="font-mono text-[10px] text-muted-foreground">{{ $log->ip_address ?? '-' }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-20 text-center">
                                    <div class="mx-auto w-16 h-16 bg-muted rounded-full flex items-center justify-center text-muted-foreground mb-4">
                                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                    </div>
                                    <p class="text-sm font-bold text-foreground">Belum ada aktivitas tercatat</p>
                                    <p class="text-xs text-muted-foreground mt-1">Log aktivitas akan muncul setelah pengguna berinteraksi dengan sistem.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $logs->appends(request()->query())->links() }}
        </div>
    </div>
</x-app-layout>
