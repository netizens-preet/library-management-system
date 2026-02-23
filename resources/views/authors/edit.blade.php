<form action="{{ route('authors.update', $author->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label>Author Name</label>
        <input type="text" name="name" value="{{ old('name', $author->name) }}">
        @error('name') <small style="color:red">{{ $message }}</small> @enderror
    </div>

    <div>
        <label>Email Address</label>
        <input type="email" name="email" value="{{ old('email', $author->email) }}">
        @error('email') <small style="color:red">{{ $message }}</small> @enderror
    </div>

    <button type="submit">Update Author</button>
</form>