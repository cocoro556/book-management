<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    // 一覧
    public function index()
    {
        $todos = Todo::all();

        // 統計データを計算して渡す
        $stats = [
            'total' => $todos->count(),
            'completed' => $todos->where('completed', true)->count(),
            'pending' => $todos->where('completed', false)->count(),
            'today' => Todo::whereDate('due_date', today())->count(),
        ];
        return view('todos.index', compact('todos', 'stats'));
    }

    // 追加
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'required|date',
        ]);

        Todo::create($request->all());
        return redirect()->route('todos.index')->with('success', 'タスクが追加されました！');
    }

    // 削除
    public function destroy($id)
    {
        Todo::find($id)->delete();
        return redirect()->route('todos.index');
    }

    // 完了状態の切り替え
    public function toggleComplete($id)
    {
        $todo = Todo::find($id);
        // 現在の状態を反転させる（0なら1に、1なら0に）
        $todo->completed = !$todo->completed;
        $todo->save();
        
        return redirect()->route('todos.index');
    }
}
