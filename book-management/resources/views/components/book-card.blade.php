<div class="book-card">
    <div class="book-title">{{ $book->title }}</div>
    <div class="book-meta">
        <span>👤 著者: {{ $book->author->name }}</span>
        <span>📅 出版年: {{ $book->publication_year }}</span>
        <span>📋 ISBN: {{ $book->isbn }}</span>
    </div>
    <div class="genre-badge">💻 {{ $book->genre->name }}</div>
    <div class="book-actions">
        <button class="btn" onclick="showBookDetail('{{ $book->id }}')">📖 詳細</button>
        <a class="btn btn-warning" href="{{ route('books.edit', $book->id) }}">✏️ 編集</a>
        <form action="{{ route('books.destroy', $book->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">🗑️ 削除</button>
        </form>
    </div>
</div>
