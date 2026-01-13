<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'Coffee',
            'Matcha',
            'Milky Way',
            'Tea',
            'Summer',
            'Kombucha',
            'Paasta',
            'Platter',
            'Snack',
            'Local Food',
            'Rice Bowl',
        ];

        foreach ($names as $name) {
            Category::firstOrCreate(['name' => $name]);
        }
    }
}
