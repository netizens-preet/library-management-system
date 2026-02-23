@extends('layouts.app')

@section('content')
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Books Inventory</h2>
        <a href="{{ route('books.create') }}" class="btn btn-success">
            + Register New Book
        </a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Copies (Available/Total)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($books as $book)
                <tr>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author->name ?? 'N/A' }}</td>
                    <td>
                        {{ $book->available_copies }} / {{ $book->total_copies }}
                    </td>
                    <td>
                        <div style="display: flex; gap: 5px;">
                            <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-info">Edit</a>
                            
                            <form action="{{ route('books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Delete this book?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 40px; color: #666;">
                        <p>No books found in the database.</p>
                        <a href="{{ route('books.create') }}" class="btn btn-primary">Add your first book</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection