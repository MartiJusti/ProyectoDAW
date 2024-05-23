<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tasks')->insert([
            [
                'name' => 'Task 1',
                'description' => 'This is the first task',
                'date_start' => '2024-05-08',
                'date_end' => '2024-05-15'
            ],
            [
                'name' => 'Task 2',
                'description' => 'Second task description',
                'date_start' => '2024-05-10',
                'date_end' => '2024-05-20'
            ],
            [
                'name' => 'Task 3',
                'description' => 'Task with a longer description that goes on',
                'date_start' => '2024-05-12',
                'date_end' => '2024-05-25'
            ],
            [
                'name' => 'Another Task',
                'description' => 'Another task description',
                'date_start' => '2024-05-15',
                'date_end' => '2024-05-30'
            ],
            [
                'name' => 'Final Task',
                'description' => 'Final task description',
                'date_start' => '2024-05-20',
                'date_end' => '2024-06-01'
            ],
        ]);
    }
}
