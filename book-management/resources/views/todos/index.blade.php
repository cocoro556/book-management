<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>ToDoリスト - レアル・マドリード風</title>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
        <link
            href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
            rel="stylesheet"
        />
    </head>
    <body class="todo-body">
        <div class="todo-background-overlay"></div>
        <!-- ヘッダー -->
        <header class="todo-header">
            <div class="container">
                <h1>ToDoリスト</h1>
            </div>
        </header>

        <!-- メインコンテンツ -->
        <main class="todo-container">
            <!-- 統計情報 -->
            <div class="todo-stats">
                <h3>📊 タスク統計</h3>
                <div class="todo-stats-grid">
                    <div class="todo-stat-item">
                        <div class="todo-stat-number" id="total-todos">
                            {{ $stats["total"] }}
                        </div>
                        <div class="todo-stat-label">総タスク数</div>
                    </div>
                    <div class="todo-stat-item">
                        <div class="todo-stat-number" id="completed-todos">
                            {{ $stats["completed"] }}
                        </div>
                        <div class="todo-stat-label">完了済み</div>
                    </div>
                    <div class="todo-stat-item">
                        <div class="todo-stat-number" id="pending-todos">
                            {{ $stats["pending"] }}
                        </div>
                        <div class="todo-stat-label">未完了</div>
                    </div>
                    <div class="todo-stat-item">
                        <div class="todo-stat-number" id="today-todos">
                            {{ $stats["today"] }}
                        </div>
                        <div class="todo-stat-label">今日のタスク</div>
                    </div>
                </div>
            </div>

            <!-- タスク追加フォーム -->
            <div class="todo-add-form">
                <form
                    id="todo-form"
                    action="{{ route('todos.store') }}"
                    method="post"
                >
                    @csrf

                    <!-- タスクタイトル行 -->
                    <div class="form-group">
                        <label for="todo-input" class="form-label"
                            >タスクタイトル</label
                        >
                        <input
                            type="text"
                            id="todo-input"
                            name="title"
                            class="todo-input"
                            placeholder="タスクを入力してください..."
                            required
                        />
                    </div>

                    <!-- 説明と優先度の行 -->
                    <div class="form-row">
                        <div class="form-group">
                            <label for="description" class="form-label"
                                >説明</label
                            >
                            <input
                                type="text"
                                name="description"
                                id="description"
                                class="todo-description"
                                placeholder="説明を入力してください..."
                            />
                        </div>
                        <div class="form-group">
                            <label for="priority" class="form-label"
                                >優先度</label
                            >
                            <select
                                name="priority"
                                id="priority"
                                class="todo-priority"
                                required
                            >
                                <option value="low">🔵 低</option>
                                <option value="medium" selected>🟡 中</option>
                                <option value="high">🔴 高</option>
                            </select>
                        </div>
                    </div>

                    <!-- 期限日と追加ボタンの行 -->
                    <div class="form-row">
                        <div class="form-group">
                            <label for="todo-date" class="form-label"
                                >期限日</label
                            >
                            <input
                                type="date"
                                id="todo-date"
                                name="due_date"
                                class="todo-date"
                                value="{{ date('Y-m-d') }}"
                                required
                            />
                        </div>
                        <div class="form-group form-group-button">
                            <button type="submit" class="todo-add-btn">
                                タスクを追加
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- タスクリスト -->
            <div class="todo-list">
                <!-- サンプルタスク（実際のデータに置き換えられます） -->
                @foreach ($todos as $todo)
                <div class="todo-item {{ $todo->completed ? 'completed' : '' }}" data-id="{{ $todo->id }}">
                    <!-- チェックボックスと送信ボタンを組み合わせ -->
                    <form
                        action="{{ route('todos.complete', $todo->id) }}"
                        method="post"
                        style="display: inline"
                    >
                        @csrf @method('PATCH')
                        <input
                            type="checkbox"
                            class="todo-checkbox"
                            {{ $todo->completed ? 'checked' : '' }}
                            onchange="this.form.submit()"
                        />
                    </form>
                    <div class="todo-content">
                        <div class="todo-title-row">
                            <div class="todo-text {{ $todo->completed ? 'completed' : '' }}">
                                {{$todo->title}}
                            </div>
                            <div class="todo-priority-display">
                                {{$todo->priority_with_emoji}}
                            </div>
                        </div>
                        <div class="todo-date-display">
                            📅 {{$todo->due_date}}
                        </div>
                    </div>
                    <div class="todo-actions">
                        <button class="todo-detail-btn" onclick="showDetail()">
                            詳細
                        </button>
                        <button class="todo-edit-btn">編集</button>
                        <form
                            action="{{ route('todos.destroy', $todo->id) }}"
                            method="post"
                            style="display: inline"
                        >
                            @csrf @method('DELETE')
                            <button class="todo-delete-btn" type="submit">
                                削除
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </main>

        <!-- 詳細モーダル -->
        <div id="detailModal" class="modal" style="display: none">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>📋 タスク詳細</h3>
                    <span class="close" onclick="closeDetail()">&times;</span>
                </div>
                <div class="modal-body">
                    <div class="detail-item">
                        <label>📝 タイトル:</label>
                        <p id="detail-title"></p>
                    </div>
                    <div class="detail-item">
                        <label>📄 説明:</label>
                        <p id="detail-description"></p>
                    </div>
                    <div class="detail-item">
                        <label>⚡ 優先度:</label>
                        <p id="detail-priority"></p>
                    </div>
                    <div class="detail-item">
                        <label>📅 期限日:</label>
                        <p id="detail-due-date"></p>
                    </div>
                    <div class="detail-item">
                        <label>✅ 完了状況:</label>
                        <p id="detail-completed"></p>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('js/main.js') }}"></script>
        <script>
            // 詳細表示関数
            function showDetail(id) {
                // 実際のデータベースから取得する場合は、ここでAjaxリクエストを送信
                // 今回はサンプルデータを使用
                const todoData = {
                    title: "サンプルタスク",
                    description: "これはサンプルの説明です。",
                    priority: "🔵 低",
                    due_date: "2024-01-20",
                    completed: "未完了",
                };

                document.getElementById("detail-title").textContent =
                    todoData.title;
                document.getElementById("detail-description").textContent =
                    todoData.description;
                document.getElementById("detail-priority").textContent =
                    todoData.priority;
                document.getElementById("detail-due-date").textContent =
                    todoData.due_date;
                document.getElementById("detail-completed").textContent =
                    todoData.completed;

                document.getElementById("detailModal").style.display = "block";
            }

            // 詳細モーダルを閉じる
            function closeDetail() {
                document.getElementById("detailModal").style.display = "none";
            }

            // モーダル外クリックで閉じる
            window.onclick = function (event) {
                const modal = document.getElementById("detailModal");
                if (event.target === modal) {
                    modal.style.display = "none";
                }
            };

            // シンプルな関数（後で実装予定）
            function toggleComplete(id) {
                alert("チェックボックス機能は後で実装します！");
            }
        </script>
    </body>
</html>
