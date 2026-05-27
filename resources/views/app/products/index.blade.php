@extends('layouts.app')
@section('title', 'Manajemen Produk')

@section('content')
<div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200" x-data="{ viewMode: 'grid' }">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-slate-800">Daftar Produk</h2>
        <div class="flex items-center gap-4">
            <div class="bg-slate-100 rounded-lg p-1 flex">
                <button @click="viewMode = 'grid'" :class="viewMode === 'grid' ? 'bg-white shadow-sm' : ''" class="p-2 rounded-md text-slate-600 transition"><i class="fas fa-th-large"></i></button>
                <button @click="viewMode = 'table'" :class="viewMode === 'table' ? 'bg-white shadow-sm' : ''" class="p-2 rounded-md text-slate-600 transition"><i class="fas fa-list"></i></button>
            </div>
            <a href="{{ route('products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-plus mr-2"></i> Tambah Produk
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div x-show="viewMode === 'grid'" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($products as $product)
        <div class="bg-white border border-slate-200 rounded-xl p-4 hover:shadow-lg transition">
            <div class="h-40 bg-slate-100 rounded-lg mb-4 flex items-center justify-center overflow-hidden">
                @if($product->image) <img src="{{ asset('storage/'.$product->image) }}" class="object-cover w-full h-full"> @else <i class="fas fa-box-open text-4xl text-slate-300"></i> @endif
            </div>
            <h3 class="font-bold text-slate-800 truncate">{{ $product->name }}</h3>
            <div class="flex justify-between mt-2 mb-4">
                <span class="text-blue-600 font-semibold text-sm">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                <span class="text-xs bg-slate-100 px-2 py-1 rounded">Stok: {{ $product->stock }}</span>
            </div>
            <div class="mt-4 flex gap-2">
                <a href="{{ route('products.edit', $product->id) }}" class="flex-1 bg-amber-500 text-white text-center py-1 rounded text-xs hover:bg-amber-600">Edit</a>
                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="flex-1">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full bg-red-500 text-white py-1 rounded text-xs hover:bg-red-600" onclick="return confirm('Yakin hapus?')">Hapus</button>
                </form>
            </div>
        </div>
        @empty <p class="text-center col-span-full">Belum ada produk.</p> @endforelse
    </div>

    <div x-show="viewMode === 'table'" class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 border-b">
                <tr>
                    <th class="px-4 py-3">SKU</th>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Harga</th>
                    <th class="px-4 py-3">Stok</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr class="border-b hover:bg-slate-50">
                    <td class="px-4 py-3 font-mono text-xs">{{ $product->sku }}</td>
                    <td class="px-4 py-3">{{ $product->name }}</td>
                    <td class="px-4 py-3">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="px-4 py-3">{{ $product->stock }}</td>
                    <td class="px-4 py-3">
                        <a href="{{ route('products.edit', $product->id) }}" class="text-amber-600 hover:underline">Edit</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Yakin?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $products->links() }}</div>
</div>
@endsection