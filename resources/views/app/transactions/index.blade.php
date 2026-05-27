@extends('layouts.app')
@section('title', 'Riwayat Transaksi')

@section('content')
<div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-slate-800">Riwayat Transaksi</h2>
        <a href="{{ route('transactions.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i> Transaksi Baru
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 border-b">
                <tr>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3">Produk</th>
                    <th class="px-4 py-3">Tipe</th>
                    <th class="px-4 py-3">Jumlah</th>
                    <th class="px-4 py-3">Stok Akhir</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($transactions as $t)
                <tr>
                    <td class="px-4 py-3">{{ $t->created_at->format('d M Y, H:i') }}</td>
                    <td class="px-4 py-3 font-medium">{{ $t->product->name ?? 'Produk Dihapus' }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded text-xs font-bold {{ $t->type == 'in' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $t->type == 'in' ? 'MASUK' : 'KELUAR' }}
                        </span>
                    </td>
                    <td class="px-4 py-3">{{ $t->quantity }}</td>
                    <td class="px-4 py-3 font-mono">{{ $t->stock_after }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-4 py-8 text-center text-slate-400">Belum ada transaksi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection