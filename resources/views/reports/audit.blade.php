<x-app-layout>
    <x-slot name="header">
        Log Aktivitas Pengguna
    </x-slot>

    <div class="space-y-6">
        <div class="card-premium overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-muted/50 text-muted-foreground uppercase text-xs font-semibold">
                        <tr>
                            <th class="px-6 py-4">Waktu</th>
                            <th class="px-6 py-4">User</th>
                            <th class="px-6 py-4">Aksi</th>
                            <th class="px-6 py-4">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse($logs as $log)
                            <tr class="hover:bg-muted/30 transition-colors">
                                <td class="px-6 py-4 text-muted-foreground whitespace-nowrap">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 font-bold text-foreground">{{ $log->user->name ?? 'System' }}</td>
                                <td class="px-6 py-4 uppercase text-[10px] font-extrabold tracking-tighter">
                                    <span class="px-2 py-1 {{ str_contains($log->action, 'approve') ? 'bg-green-100 text-green-700' : 'bg-indigo-100 text-indigo-700' }} rounded">
                                        {{ str_replace('_', ' ', $log->action) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-muted-foreground">{{ $log->description }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-muted-foreground italic">Belum ada aktivitas tercatat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4">
            {{ $logs->links() }}
        </div>
    </div>
</x-app-layout>
