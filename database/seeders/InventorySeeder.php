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
            ['Laptop Lenovo ThinkPad', $electronics->id, 25, 10],
            ['Printer Canon', $electronics->id, 8, 10],
            ['Kertas A4', $office->id, 120, 50],
            ['Mouse Wireless', $electronics->id, 35, 15],
        ];

        foreach ($items as [$name, $categoryId, $stock, $minStock]) {
            $product = Product::firstOrCreate(
                ['name' => $name],
                ['category_id' => $categoryId, 'stock' => $stock, 'min_stock' => $minStock]
            );

            Stock::firstOrCreate(
                ['product_id' => $product->id, 'location' => 'Gudang Utama'],
                ['quantity' => $stock]
            );
        }
    }
}
