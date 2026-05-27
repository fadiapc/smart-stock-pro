<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed User
        \App\Models\User::factory()->create(['name' => 'Super Admin', 'email' => 'admin@smartstock.com', 'password' => bcrypt('password'), 'role' => 'admin']);
        \App\Models\User::factory()->create(['name' => 'Manajer Gudang', 'email' => 'manajer@smartstock.com', 'password' => bcrypt('password'), 'role' => 'manajer']);
        \App\Models\User::factory()->create(['name' => 'Staf Operasional', 'email' => 'staf@smartstock.com', 'password' => bcrypt('password'), 'role' => 'staf']);
        \App\Models\User::factory()->create(['name' => 'Viewer Laporan', 'email' => 'viewer@smartstock.com', 'password' => bcrypt('password'), 'role' => 'viewer']);

        // 2. Seed Warehouse (Gudang)
        \App\Models\Warehouse::create(['name' => 'Gudang Utama BSD', 'location' => 'BSD', 'lat' => '-6.2828', 'lng' => '106.6648', 'capacity' => 10000]);
        \App\Models\Warehouse::create(['name' => 'Gudang Cabang Bogor', 'location' => 'Bogor', 'lat' => '-6.5950', 'lng' => '106.8166', 'capacity' => 5000]);

        \App\Models\Supplier::create(['name' => 'PT Maju Jaya', 'contact_person' => 'Budi', 'phone' => '0812345678', 'address' => 'Jl. Raya Bogor No. 123']);

    // Memanggil seeder bawaan untuk memunculkan produk dan stok
    $this->call([
        InventorySeeder::class,
    ]);
    }
}

