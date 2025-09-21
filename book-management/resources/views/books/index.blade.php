<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>図書館管理システム</title>
        <link rel="stylesheet" href="{{ url('css/style.css') }}" />
    </head>
    <body>
        <x-page-header></x-page-header>
        <main class="main-content">
            <div class="container">
                <!-- 統計情報 -->
                <x-stats-cards :books="$books"></x-stats-cards>
                <!-- 本一覧ページ -->
                <div id="books-page">
                    <!-- 本一覧 -->
                    <x-book-list></x-book-list>
                    <!-- 検索フォーム -->
                    <x-book-search-form></x-book-search-form>
                    <!-- 本カードグリッド -->
                    <div class="books-grid">
                        @foreach ($books as $book)
                        <x-book-card :book="$book" />
                        @endforeach
                    </div>
                </div>
            </div>
        </main>

        <!-- 新規追加モーダル -->
        <x-book-create-modal :genres="$genres"></x-book-create-modal>
        <!-- 詳細モーダル -->
        <x-book-detail-modal></x-book-detail-modal>

        <script src="{{ url('js/main.js') }}"></script>
        
        <!-- バリデーションエラー時にモーダルを自動で開く -->
        @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('bookModal').style.display = 'block';
            });
        </script>
        @endif
    </body>
</html>
