<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $names = ['Akademik', 'Olahraga', 'Seni', 'Sosial'];

        foreach ($names as $name) {
            Category::firstOrCreate(['name' => $name]);
        }
    }
}