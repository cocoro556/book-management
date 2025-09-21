<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\TodoController;

// 本一覧
Route::get('/', [BookController::class, 'index'])->name('books.index');

// 本詳細
Route::get('/api/books/{id}', [BookController::class, 'getBookDetails'])->name('books.getBookDetails');

// 本追加
Route::post('/books', [BookController::class, 'store'])->name('books.store');

// 本削除
Route::delete('/books/{id}', [BookController::class, 'destroy'])->name('books.destroy');

// 編集
Route::get('/books/{id}/edit', [BookController::class, 'edit'])->name('books.edit');
Route::patch('/books/{id}', [BookController::class, 'update'])->name('books.update');


// ToDoリスト
// 一覧
Route::get('/todos', [TodoController::class, 'index'])->name('todos.index');
// 追加
Route::post('/todos', [TodoController::class, 'store'])->name('todos.store');
// 削除
Route::delete('/todos/{id}', [TodoController::class, 'destroy'])->name('todos.destroy');
// 完了状態切り替え
Route::patch('/todos/{id}/complete', [TodoController::class, 'toggleComplete'])->name('todos.complete');
// Route::patch('/todos/{id}/toggle', [TodoController::class, 'toggleComplete'])->name('todos.toggle');