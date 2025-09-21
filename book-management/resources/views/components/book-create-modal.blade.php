<div id="bookModal" class="modal">
    <div class="modal-content">
        <h3>📚 新しい本を追加</h3>
        <form method="post" action="{{ route('books.store') }}">
            @csrf 
            <div class="form-group">
                <label for="title">タイトル</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required />
                @error('title')
                    <div style="color: red; font-size: 0.9em; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="author">著者</label>
                <input type="text" id="author" name="author" placeholder="著者名を入力してください..." value="{{ old('author') }}" required />
                @error('author')
                    <div style="color: red; font-size: 0.9em; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="genre">ジャンル</label>
                <select id="genre" name="genre" required>
                    <option value="">ジャンルを選択...</option>
                    @foreach($genres as $genre)
                        <option value="{{ $genre->id }}" {{ old('genre') == $genre->id ? 'selected' : '' }}>
                            {{ $genre->name }}
                        </option>
                    @endforeach
                </select>
                @error('genre')
                    <div style="color: red; font-size: 0.9em; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="year">出版年</label>
                <input
                    type="number"
                    id="year"
                    name="year"
                    min="1900"
                    max="2024"
                    value="{{ old('year') }}"
                    required
                />
                @error('year')
                    <div style="color: red; font-size: 0.9em; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="isbn">ISBN</label>
                <input type="text" id="isbn" name="isbn" value="{{ old('isbn') }}" />
                @error('isbn')
                    <div style="color: red; font-size: 0.9em; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <div style="text-align: right; margin-top: 2rem">
                <button
                    type="button"
                    onclick="closeModal('bookModal')"
                    style="background: #ccc; margin-right: 1rem"
                >
                    キャンセル
                </button>
                <button type="submit" class="btn">💾 保存</button>
            </div>
        </form>
    </div>
</div>
