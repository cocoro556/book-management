<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Author;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Author::create([
            'name' => '山田太郎',
        ]);
        Author::create([
            'name' => '夏目漱石',
        ]);
        Author::create([
            'name' => '佐藤花子',
        ]);
    }
}
