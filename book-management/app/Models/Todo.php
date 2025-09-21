<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = ['title', 'description', 'completed', 'due_date', 'priority'];

    // 優先度の絵文字付き日本語
    public function getPriorityWithEmojiAttribute()
    {
        return match($this->priority) {
            'low' => '🔵 低',
            'medium' => '🟡 中',
            'high' => '🔴 高',
            default => '🟡 中'
        };
    }
}
