<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::create([
            'title' => 'Laravel実践入門',
            'author_id' => 1,
            'genre_id' => 1,
            'publication_year' => 2023,
            'isbn' => '978-4-123456-78-9',
        ]);
    }
}
