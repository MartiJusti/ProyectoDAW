<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'Category 1', 'description' => 'Description for Category 1'],
            ['name' => 'Category 2', 'description' => 'Description for Category 2'],
            ['name' => 'Category 3', 'description' => 'Description for Category 3'],
            ['name' => 'Category 4', 'description' => 'Description for Category 4'],
            ['name' => 'Category 5', 'description' => 'Description for Category 5'],
        ]);
    }
}
