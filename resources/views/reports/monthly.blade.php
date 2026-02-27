<x-app-layout>
    <x-slot name="header">
        Laporan Bulanan
    </x-slot>

    <div class="space-y-8">
        <!-- Filter Card -->
        <div class="card-premium p-6 print:hidden">
            <form method="GET" action="{{ route('reports.monthly') }}" class="flex flex-wrap items-end gap-6">
                <div class="flex-1 min-w-[200px]">
                    <x-input-label for="month" value="Pilih Bulan" class="mb-2" />
                    <select name="month" id="month" class="block w-full border-border bg-background text-foreground rounded-lg focus:ring-primary focus:border-primary shadow-sm">
                        @foreach(range(1, 12) as $m)
                            <option value="{{ sprintf('%02d', $m) }}" {{ $month == $m ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $m, 10)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1 min-w-[200px]">
                    <x-input-label for="year" value="Pilih Tahun" class="mb-2" />
                    <select name="year" id="year" class="block w-full border-border bg-background text-foreground rounded-lg focus:ring-primary focus:border-primary shadow-sm">
                        @foreach(range(date('Y')-3, date('Y')) as $y)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-3">
                    <x-primary-button class="bg-indigo-600 hover:bg-indigo-700">Filter</x-primary-button>
                    <button type="button" onclick="window.print()" class="px-4 py-2 bg-slate-200 dark:bg-slate-700 text-slate-800 dark:text-slate-100 rounded-md font-bold text-xs uppercase tracking-widest hover:bg-slate-300 transition-colors">Cetak</button>
                </div>
            </form>
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="card-premium p-6 border-l-4 border-indigo-500">
                <p class="text-[10px] font-extrabold text-muted-foreground uppercase tracking-widest">Total Pinjam</p>
                <p class="text-3xl font-black mt-1">{{ $peminjamans->count() }} <span class="text-xs font-normal text-muted-foreground">Kali</span></p>
            </div>
            <div class="card-premium p-6 border-l-4 border-green-500">
                <p class="text-[10px] font-extrabold text-muted-foreground uppercase tracking-widest">Total Kembali</p>
                <p class="text-3xl font-black mt-1">{{ $pengembalians->count() }} <span class="text-xs font-normal text-muted-foreground">Kali</span></p>
            </div>
            <div class="card-premium p-6 border-l-4 border-orange-500">
                <p class="text-[10px] font-extrabold text-muted-foreground uppercase tracking-widest">Denda Terkumpul</p>
                <p class="text-3xl font-black mt-1 text-orange-600">Rp {{ number_format($totalFines, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Detailed Table -->
        <div class="card-premium overflow-hidden">
            <div class="p-6 border-b border-border bg-muted/20">
                <h4 class="font-bold text-foreground capitalize">Daftar Transaksi Periode {{ date('F Y', mktime(0,0,0,$month, 1, $year)) }}</h4>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-muted text-muted-foreground uppercase text-[10px] font-black tracking-widest">
                        <tr>
                            <th class="px-6 py-4">Peminjam</th>
                            <th class="px-6 py-4">Tanggal Pinjam</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Alat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @foreach($peminjamans as $p)
                            <tr class="hover:bg-muted/30">
                                <td class="px-6 py-4">
                                    <div class="font-bold">{{ $p->user->name }}</div>
                                    <div class="text-[10px] text-muted-foreground">{{ $p->user->email }}</div>
                                </td>
                                <td class="px-6 py-4">{{ $p->tanggal_pinjam }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $p->status === 'dikembalikan' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                        {{ $p->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @foreach($p->details as $d)
                                        <div class="text-xs">{{ $d->alat->nama_alat }} ({{ $d->jumlah }})</div>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
