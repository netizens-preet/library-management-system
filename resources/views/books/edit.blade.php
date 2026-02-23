<form action="{{ route('books.update', $book->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label>Book Title</label>
        <input type="text" name="title" value="{{ old('title', $book->title) }}">
    </div>

    <div>
        <label>Author</label>
        <select name="author_id">
            @foreach($authors as $author)
                <option value="{{ $author->id }}" {{ (old('author_id', $book->author_id) == $author->id) ? 'selected' : '' }}>
                    {{ $author->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Available Copies</label>
        <input type="number" name="available_copies" value="{{ old('available_copies', $book->available_copies) }}">
    </div>

    <button type="submit">Update Book</button>
</form>