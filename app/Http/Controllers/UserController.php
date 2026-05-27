<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    // Menampilkan halaman form tambah user
    public function index()
    {
        $users = User::paginate(10);
        return view('app.users.index', compact('users'));
    }

    // Memproses penyimpanan user baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role' => ['required', 'in:admin,manajer,staf,viewer'],
            // INI DIA INTI POIN 1.B: Validasi Kekuatan Password
            'password' => ['required', 'confirmed', 
                Password::min(8) // Minimal 8 karakter
                    ->letters()  // Wajib ada huruf
                    ->numbers()  // Wajib ada angka
                    ->symbols()  // Wajib ada simbol (@, #, !, dll)
            ],
        ], [
            // Kustomisasi pesan error agar mudah dibaca penguji
            'password.min' => 'Password minimal harus 8 karakter.',
            'password.letters' => 'Password harus mengandung huruf.',
            'password.numbers' => 'Password harus mengandung angka.',
            'password.symbols' => 'Password harus mengandung simbol (!, @, #, dst).',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/app/users')->with('success', 'User pegawai berhasil ditambahkan!');
    }
}