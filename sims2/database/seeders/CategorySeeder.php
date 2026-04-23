<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Vegetables', 'description' => 'Fresh vegetables', 'color' => '#4CAF50'],
            ['name' => 'Fruits', 'description' => 'Fresh fruits', 'color' => '#FF9800'],
            ['name' => 'Pantry', 'description' => 'Pantry staples', 'color' => '#9C27B0'],
            ['name' => 'Seafood', 'description' => 'Fresh seafood', 'color' => '#2196F3'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['name' => $cat['name']],
                $cat
            );
        }
    }
}

