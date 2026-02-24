@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Authors List</h2>
    <a href="{{ route('authors.create') }}" class="btn btn-primary mb-3">Add Author</a>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>email</th>
                <th>Total Books</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($authors as $author)
            <tr>
                <td>{{ $author->name }}</td>
                <td>{{ $author->email }}</td>
                <td><strong>{{ $author->books_count }}</strong></td> <td>
                    <a href="{{ route('authors.edit', $author->id) }}">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection