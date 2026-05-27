@extends('layouts.app')
@section('title', 'Manajemen Supplier')

@section('content')
<div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-slate-800">Daftar Supplier</h2>
        <a href="{{ route('suppliers.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Tambah Supplier</a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 border-b">
                <tr>
                    <th class="px-4 py-3">Nama Supplier</th>
                    <th class="px-4 py-3">Kontak Person</th>
                    <th class="px-4 py-3">Telepon</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($suppliers as $s)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3 font-medium text-slate-800">{{ $s->name }}</td>
                    <td class="px-4 py-3">{{ $s->contact_person }}</td>
                    <td class="px-4 py-3">{{ $s->phone }}</td>
                    <td class="px-4 py-3 flex gap-2">
                        <a href="{{ route('suppliers.edit', $s->id) }}" class="text-amber-600 hover:underline">Edit</a>
                        <form action="{{ route('suppliers.destroy', $s->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-8 text-center text-slate-400">Belum ada data supplier.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection