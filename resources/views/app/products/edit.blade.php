@extends('layouts.app')
@section('title', 'Edit Produk')

@section('content')
<div class="max-w-xl mx-auto bg-white p-8 rounded-xl shadow-sm border border-slate-200">
    <h2 class="text-xl font-bold mb-6">Edit Produk: {{ $product->name }}</h2>
    
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf @method('PUT')
        
        <div>
            <label class="block text-sm font-medium">SKU</label>
            <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="w-full border p-2 rounded-lg">
        </div>
        
        <div>
            <label class="block text-sm font-medium">Nama Produk</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full border p-2 rounded-lg">
        </div>

        <div>
            <label class="block text-sm font-medium">Kategori</label>
            <select name="category_id" class="w-full border p-2 rounded-lg">
                @foreach($categories as $cat) 
                    <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option> 
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Harga</label>
                <input type="number" name="price" value="{{ old('price', $product->price) }}" class="w-full border p-2 rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium">Stok</label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="w-full border p-2 rounded-lg">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium">Ganti Foto (Opsional)</label>
            @if($product->image)
                <div class="mb-2">
                    <img src="{{ asset('storage/'.$product->image) }}" class="h-20 rounded shadow">
                </div>
            @endif
            <input type="file" name="image" class="w-full border p-2 rounded-lg">
        </div>

        <button type="submit" class="w-full bg-amber-600 text-white py-3 rounded-lg hover:bg-amber-700">Update Produk</button>
    </form>
</div>
@endsection