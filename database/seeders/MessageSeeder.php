<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('messages')->insert([
            ['content' => 'This is a message content', 'date_sent' => '2024-05-08', 'date_received' => '2024-05-09', 'read' => false],
            ['content' => 'Another message content', 'date_sent' => '2024-05-10', 'date_received' => '2024-05-11', 'read' => true],
            ['content' => 'Yet another message content', 'date_sent' => '2024-05-12', 'date_received' => '2024-05-13', 'read' => false],
            ['content' => 'Message 4 content', 'date_sent' => '2024-05-14', 'date_received' => '2024-05-15', 'read' => true],
            ['content' => 'Message 5 content', 'date_sent' => '2024-05-16', 'date_received' => '2024-05-17', 'read' => false],
        ]);
    }
}
