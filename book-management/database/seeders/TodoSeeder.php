<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Todo;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Todo::create([
            'title' => 'タスク1',
            'description' => 'タスク1の説明',
            'completed' => false,
            'due_date' => '2025-09-20',
            'priority' => 'medium',
        ]);
    }
}
