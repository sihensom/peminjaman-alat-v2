<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-indigo-500/10 rounded-lg text-indigo-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
            </div>
            <div>
                <h2 class="text-xl font-black text-foreground tracking-tight">Kelola User</h2>
                <p class="text-xs text-muted-foreground font-medium">Manajemen akun pengguna sistem</p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <div></div>
            <a href="{{ route('users.create') }}" class="btn-primary flex items-center gap-2 shadow-indigo-500/20 shadow-lg">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Tambah User
            </a>
        </div>

        @if(session('success'))
            <div class="p-4 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-2xl text-sm font-bold">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="p-4 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 rounded-2xl text-sm font-bold">{{ session('error') }}</div>
        @endif

        <div class="card-premium overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-muted/50 text-muted-foreground uppercase text-[10px] font-black tracking-widest">
                        <tr>
                            <th class="px-6 py-4">User</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Role</th>
                            <th class="px-6 py-4">Terdaftar</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse($users as $user)
                            <tr class="hover:bg-muted/30 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-9 w-9 rounded-xl {{ $user->role === 'admin' ? 'bg-indigo-500/10 text-indigo-600' : ($user->role === 'petugas' ? 'bg-blue-500/10 text-blue-600' : 'bg-emerald-500/10 text-emerald-600') }} flex items-center justify-center text-xs font-black uppercase">
                                            {{ substr($user->name, 0, 2) }}
                                        </div>
                                        <span class="font-bold text-foreground">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-xs text-muted-foreground font-medium">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $roleClass = [
                                            'admin' => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300',
                                            'petugas' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300',
                                            'peminjam' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300',
                                        ][$user->role] ?? 'bg-muted text-muted-foreground';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-tight {{ $roleClass }}">{{ $user->role }}</span>
                                </td>
                                <td class="px-6 py-4 text-xs text-muted-foreground">{{ $user->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end items-center gap-2">
                                        <a href="{{ route('users.edit', $user) }}" class="px-3 py-1.5 bg-muted hover:bg-border text-foreground rounded-lg text-xs font-bold transition-all">Edit</a>
                                        @if($user->id !== auth()->id())
                                            <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Hapus user ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 bg-destructive/10 text-destructive hover:bg-destructive hover:text-white rounded-lg text-xs font-bold transition-all">Hapus</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-20 text-center">
                                    <p class="text-sm font-bold text-foreground">Belum ada user.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
