@extends('layouts.app')
@section('title', 'Manajemen User')

@section('content')
<div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
    <h2 class="text-xl font-bold mb-4">Daftar Pengguna</h2>
    <table class="w-full text-left">
        <thead class="bg-slate-50">
            <tr><th class="p-3">Nama</th><th class="p-3">Email</th><th class="p-3">Role</th></tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr class="border-b">
                <td class="p-3">{{ $user->name }}</td>
                <td class="p-3">{{ $user->email }}</td>
                <td class="p-3 capitalize">{{ $user->role }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">{{ $users->links() }}</div>
</div>
@endsection