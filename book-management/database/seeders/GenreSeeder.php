<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Genre::create([
            'name' => '技術書',
        ]);
        Genre::create([
            'name' => '文学',
        ]);
        Genre::create([
            'name' => '歴史',
        ]);
    }
}
