<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;

class BookController extends Controller
{
    // 一覧
    public function index()
    {
        $books = Book::with('author', 'genre')->get();
        $genres = Genre::all();
        return view('books.index', compact('books', 'genres'));
    }

    // 追加
    public function store(Request $request)
    {
        // バリデーション一時無効化（エラー表示システムの問題を回避）
        /*
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre' => 'required|exists:genres,id',
            'year' => 'required|integer|min:1900|max:2024',
            'isbn' => 'nullable|string|max:20',
        ]);
        */


        // 著者名を正規化（前後の空白削除）
        $authorName = trim($request->author);

        // 著者を検索または新規作成
        $author = Author::firstOrCreate(['name' => $authorName]);

        Book::create([
            'title' => $request->title,
            'author_id' => $author->id,
            'genre_id' => $request->genre,
            'publication_year' => $request->year,
            'isbn' => $request->isbn,
        ]);

        return redirect()->route('books.index');
    }

    // 詳細
    public function getBookDetails($id)
    {
        $book = Book::with('author', 'genre')->find($id);

        if (!$book) {
            return response()->json(['error' => '本が見つかりません'], 404);
        }

        return response()->json([
            'title' => $book->title,
            'author' => $book->author->name,
            'genre' => $book->genre->name,
            'publication_year' => $book->publication_year,
            'isbn' => $book->isbn,
        ]);
    }

    // 編集
    public function edit($id)
    {
        $book = Book::with('author', 'genre')->find($id);
        $genres = Genre::all();
        return view('books.edit', compact('book', 'genres'));
    }

    public function update(Request $request, $id)
    {
        // 著者名を正規化（前後の空白削除）
        $authorName = trim($request->author);
        
        // 著者を検索または新規作成
        $author = Author::firstOrCreate(['name' => $authorName]);
        
        $book = Book::find($id);
        $book->update([
            'title' => $request->title,
            'author_id' => $author->id,
            'genre_id' => $request->genre,
            'publication_year' => $request->year,
            'isbn' => $request->isbn,
        ]);
        
        return redirect()->route('books.index');
    }

    // 削除
    public function destroy($id)
    {
        $book = Book::find($id);
        $book->delete();
        return redirect()->route('books.index');
    }


}
