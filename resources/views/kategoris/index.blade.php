<x-app-layout>
    <x-slot name="header">
        Kelola Kategori Alat
    </x-slot>

    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h3 class="text-xl font-bold text-foreground">Daftar Kategori</h3>
            <a href="{{ route('kategoris.create') }}" class="btn-primary">
                + Kategori Baru
            </a>
        </div>

        <div class="card-premium overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-muted/50 text-muted-foreground uppercase text-xs font-semibold">
                        <tr>
                            <th class="px-6 py-4">Nama Kategori</th>
                            <th class="px-6 py-4">Deskripsi</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse($kategoris as $k)
                            <tr class="hover:bg-muted/30 transition-colors">
                                <td class="px-6 py-4 font-bold text-foreground">{{ $k->nama_kategori }}</td>
                                <td class="px-6 py-4 text-muted-foreground">{{ $k->deskripsi ?? '-' }}</td>
                                <td class="px-6 py-4 text-right space-x-3">
                                    <a href="{{ route('kategoris.edit', $k) }}" class="text-indigo-600 dark:text-indigo-400 font-semibold hover:underline">Edit</a>
                                    <form method="POST" action="{{ route('kategoris.destroy', $k) }}" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Hapus kategori ini?')" class="text-destructive font-semibold hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-10 text-center text-muted-foreground italic">
                                    Belum ada kategori. Klik "+ Kategori Baru" untuk menambahkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
