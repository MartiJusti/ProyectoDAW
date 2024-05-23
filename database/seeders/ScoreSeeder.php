<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('scores')->insert([
            ['points' => 100],
            ['points' => 150],
            ['points' => 200],
            ['points' => 250],
            ['points' => 300],
        ]);
    }
}
