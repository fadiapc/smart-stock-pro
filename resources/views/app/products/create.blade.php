@extends('layouts.app')
@section('title', 'Tambah Produk')

@section('content')
<div class="max-w-xl mx-auto bg-white p-8 rounded-xl shadow-sm border border-slate-200">
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium">SKU / Kode Barang</label>
            <input type="text" name="sku" value="{{ old('sku') }}" class="w-full border p-2 rounded-lg {{ $errors->has('sku') ? 'border-red-500' : '' }}">
            @error('sku') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium">Nama Produk</label>
            <input type="text" name="name" required class="w-full border p-2 rounded-lg">
        </div>
        <div>
            <label class="block text-sm font-medium">Kategori</label>
            <select name="category_id" class="w-full border p-2 rounded-lg">
                @foreach($categories as $cat) <option value="{{ $cat->id }}">{{ $cat->name }}</option> @endforeach
            </select>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Harga</label>
                <input type="number" name="price" required class="w-full border p-2 rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium">Stok Awal</label>
                <input type="number" name="stock" required class="w-full border p-2 rounded-lg">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium">Foto Produk</label>
            <input type="file" name="image" class="w-full border p-2 rounded-lg {{ $errors->has('image') ? 'border-red-500' : '' }}">
            @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700">Simpan Produk</button>
    </form>
</div>
@endsection