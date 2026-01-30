<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Makanan',
                'description' => 'Aneka makanan berat dan ringan',
            ],
            [
                'name' => 'Minuman',
                'description' => 'Aneka minuman dingin dan hangat',
            ],
            [
                'name' => 'Snack',
                'description' => 'Camilan kemasan',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
