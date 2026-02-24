@extends('layouts.app')

@section('content')
<div style="background: #eee; padding: 20px; border: 2px solid red;">
    <h2 style="color: black;">Issue New Book</h2>
    <form action="{{ route('borrows.store') }}" method="POST">
        @csrf
        <div style="margin-bottom: 10px;">
            <label style="color: black;">Member:</label>
            <select name="member_id" required>
                @foreach($members as $member)
                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                @endforeach
            </select>
        </div>
        <div style="margin-bottom: 10px;">
            <label style="color: black;">Book:</label>
            <select name="book_id" required>
                @foreach($books as $book)
                    <option value="{{ $book->id }}">{{ $book->title }} ({{ $book->available_copies }} left)</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Confirm Borrow</button>
    </form>
</div>
@endsection