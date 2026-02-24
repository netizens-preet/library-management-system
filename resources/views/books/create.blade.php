@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 700px;">
    <h2>Add New Book</h2>
    <hr>

    <form action="{{ route('books.store') }}" method="POST">
        @csrf

        <div class="form-group" style="margin-bottom: 15px;">
            <label>Title</label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
            @error('title') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-group" style="margin-bottom: 15px;">
            <label>Published Year</label>
    <input type="number" name="published_year" class="form-control" required>
        </div>

        <div class="form-group" style="margin-bottom: 15px;">
            <label>Author</label>
            <div style="display: flex; gap: 10px;">
                <select name="author_id" id="author_select" class="form-control" style="flex: 1;" required>
                    <option value="">-- Select Author --</option>
                    @foreach($authors as $author)
                        <option value="{{ $author->id }}" {{ old('author_id') == $author->id ? 'selected' : '' }}>
                            {{ $author->name }}
                        </option>
                    @endforeach
                </select>
                <button type="button" class="btn btn-info" onclick="toggleAuthorModal(true)">
                    + New Author
                </button>
            </div>
            @error('author_id') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div style="display: flex; gap: 20px; margin-bottom: 20px;">
            <div style="flex: 1;">
                <label>Total Copies</label>
                <input type="number" name="total_copies" class="form-control" value="1" min="1" required>
            </div>
            <div style="flex: 1;">
                <label>Available Copies</label>
                <input type="number" name="available_copies" class="form-control" value="1" min="0" required>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Save Book</button>
        <a href="{{ route('books.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<div id="authorModal" style="display:none; position:fixed; z-index:1000; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.6);">
    <div style="background:white; margin:10% auto; padding:25px; width:450px; border-radius:8px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
        <h3>Quick Add Author</h3>
        <hr>
        <form action="{{ route('authors.store') }}" method="POST">
            @csrf
            <input type="hidden" name="from_book_create" value="1">

            <div class="form-group" style="margin-bottom: 15px;">
                <label>Full Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" class="btn" style="background:#ccc" onclick="toggleAuthorModal(false)">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Author</button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleAuthorModal(show) {
        document.getElementById('authorModal').style.display = show ? 'block' : 'none';
    }
</script>
@endsection