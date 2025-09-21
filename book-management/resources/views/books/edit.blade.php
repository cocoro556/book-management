<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>本の編集 - 図書館管理システム</title>
        <link rel="stylesheet" href="{{ url('css/style.css') }}" />
    </head>
    <body>
        <x-page-header></x-page-header>
        
        <main class="main-content">
            <div class="container">
                <!-- ページヘッダー -->
                <div class="page-header">
                    <h2>✏️ 本の編集</h2>
                    <a href="{{ route('books.index') }}" class="btn" style="background: #6c757d;">← 戻る</a>
                </div>

                <!-- 編集フォーム -->
                <div class="modal-content" style="max-width: 600px; margin: 2rem auto; position: static; transform: none;">
                    <h3>📚 「{{ $book->title }}」を編集</h3>
                    
                    <form method="post" action="{{ route('books.update', $book->id) }}">
                        @csrf
                        @method('PATCH')
                        
                        <div class="form-group">
                            <label for="title">タイトル</label>
                            <input type="text" id="title" name="title" value="{{ $book->title }}" required />
                        </div>
                        
                        <div class="form-group">
                            <label for="author">著者</label>
                            <input type="text" id="author" name="author" value="{{ $book->author->name }}" required />
                        </div>
                        
                        <div class="form-group">
                            <label for="genre">ジャンル</label>
                            <select id="genre" name="genre" required>
                                @foreach($genres as $genre)
                                    <option value="{{ $genre->id }}" {{ $book->genre_id == $genre->id ? 'selected' : '' }}>
                                        {{ $genre->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="year">出版年</label>
                            <input type="number" id="year" name="year" min="1900" max="2024" value="{{ $book->publication_year }}" required />
                        </div>

                        <div class="form-group">
                            <label for="isbn">ISBN</label>
                            <input type="text" id="isbn" name="isbn" value="{{ $book->isbn }}" />
                        </div>

                        <div style="text-align: right; margin-top: 2rem;">
                            <a href="{{ route('books.index') }}" class="btn" style="background: #6c757d; margin-right: 1rem; text-decoration: none; display: inline-block;">キャンセル</a>
                            <button type="submit" class="btn">💾 更新</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </body>
</html>