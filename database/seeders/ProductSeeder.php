<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $makanan = Category::where('name', 'Makanan')->first();
        $minuman = Category::where('name', 'Minuman')->first();
        $snack = Category::where('name', 'Snack')->first();

        $products = [
            [
                'category_id' => $makanan->id,
                'name' => 'Nasi Goreng Spesial',
                'sku' => 'FOOD-001',
                'barcode' => '8991001',
                'price' => 25000,
                'stock' => 100,
            ],
            [
                'category_id' => $minuman->id,
                'name' => 'Es Teh Manis',
                'sku' => 'DRINK-001',
                'barcode' => '8992001',
                'price' => 5000,
                'stock' => 200,
            ],
            [
                'category_id' => $snack->id,
                'name' => 'Keripik Singkong',
                'sku' => 'SNACK-001',
                'barcode' => '8993001',
                'price' => 10000,
                'stock' => 50,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
