<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        $electronics = Category::firstOrCreate(['name' => 'Elektronik']);
        $office = Category::firstOrCreate(['name' => 'Perlengkapan Kantor']);

        $items = [
            ['sku' => 'LAP-LEN-001', 'name' => 'Laptop Lenovo ThinkPad', 'category_id' => $electronics->id, 'price' => 15000000, 'stock' => 25, 'min_stock' => 10, 'description' => 'Laptop operasional standar.'],
            ['sku' => 'PRN-CAN-001', 'name' => 'Printer Canon Pixma', 'category_id' => $electronics->id, 'price' => 2500000, 'stock' => 8, 'min_stock' => 10, 'description' => 'Printer warna multifungsi.'],
            ['sku' => 'KRT-A4-080', 'name' => 'Kertas A4 80gsm', 'category_id' => $office->id, 'price' => 55000, 'stock' => 120, 'min_stock' => 50, 'description' => 'Kertas HVS kualitas premium.'],
            ['sku' => 'MOU-WIR-001', 'name' => 'Mouse Wireless Logitech', 'category_id' => $electronics->id, 'price' => 150000, 'stock' => 35, 'min_stock' => 15, 'description' => 'Mouse nirkabel ergonomis.'],
            ['sku' => 'DSK-OFF-001', 'name' => 'Meja Kerja Minimalis', 'category_id' => $office->id, 'price' => 1200000, 'stock' => 12, 'min_stock' => 5, 'description' => 'Meja kerja kayu.'],
        ];

        foreach ($items as $item) {
            // 1. Simpan data ke tabel Products
            // Kita ambil 'stock' dari $item untuk disimpan ke tabel Stock nanti
            $stockQuantity = $item['stock']; 
            
            // Buat produk (hapus 'stock' dari array agar tidak error karena kolom 'stock' di tabel products mungkin tidak ada kalau kamu pakai sistem stok terpisah)
            $productData = collect($item)->except(['stock'])->toArray();
            $product = Product::create($productData);

            // 2. Simpan stok ke tabel Stocks (sekarang $product sudah didefinisikan!)
            Stock::firstOrCreate(
                ['product_id' => $product->id, 'location' => 'Gudang Utama'],
                ['quantity' => $stockQuantity]
            );
        }
    }
}

