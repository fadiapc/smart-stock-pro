@extends('layouts.app')
@section('title', 'Transaksi Barang')

@section('content')
<div class="max-w-xl mx-auto bg-white p-8 rounded-xl shadow border">
    <form action="{{ route('transactions.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium">Pilih Produk</label>
            <select name="product_id" class="w-full border p-2 rounded">
                @foreach($products as $p) <option value="{{ $p->id }}">{{ $p->name }} (Stok: {{ $p->stock }})</option> @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium">Jenis Transaksi</label>
            <select name="type" class="w-full border p-2 rounded">
                <option value="in">Barang Masuk</option>
                <option value="out">Barang Keluar</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium">Jumlah</label>
            <input type="number" name="quantity" required class="w-full border p-2 rounded">
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded hover:bg-blue-700">Proses Transaksi</button>
    </form>
</div>
@endsection