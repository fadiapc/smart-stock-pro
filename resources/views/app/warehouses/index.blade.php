@extends('layouts.app')
@section('title', 'Manajemen Gudang')

@section('content')
<div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-slate-800">Daftar Gudang</h2>
        <a href="{{ route('warehouses.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-2"></i> Tambah Gudang
        </a>
    </div>

    <div class="mb-4">
        <input type="text" placeholder="Cari nama gudang..." class="w-full md:w-1/3 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 border-b">
                <tr>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Lokasi</th>
                    <th class="px-4 py-3">Kapasitas</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($warehouses as $warehouse)
                <tr class="border-b hover:bg-slate-50">
                    <td class="px-4 py-3 font-semibold">{{ $warehouse->name }}</td>
                    <td class="px-4 py-3">{{ $warehouse->location }}</td>
                    <td class="px-4 py-3">{{ $warehouse->capacity }} Unit</td>
                    <td class="px-4 py-3">
                        <button class="text-blue-600 hover:underline mr-3">Edit</button>
                        <button class="text-red-600 hover:underline">Hapus</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $warehouses->links() }}
    </div>
</div>
@endsection