@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Dashboard</h2>
    <hr>

    <div style="display: flex; gap: 20px; margin-bottom: 30px;">
        <div style="background: #e9ecef; padding: 20px; border-radius: 8px; flex: 1;">
            <h3>Total Books</h3>
            <p style="font-size: 2rem;">{{ \App\Models\Book::count() }}</p>
        </div>
        <div style="background: #d4edda; padding: 20px; border-radius: 8px; flex: 1;">
            <h3>Active Members</h3>
            <p style="font-size: 2rem;">{{ \App\Models\member::where('is_active', true)->count() }}</p>
        </div>
        <div style="background: #fff3cd; padding: 20px; border-radius: 8px; flex: 1;">
            <h3>Books Borrowed</h3>
            <p style="font-size: 2rem;">{{ \App\Models\borrowrecord::whereNull('returned_at')->count() }}</p>
        </div>
    </div>

    <div style="margin-top: 20px;">
        <h3>Quick Actions</h3>
        <a href="{{ route('borrows.create') }}" class="btn btn-success">Issue New Book</a>
        <a href="{{ route('members.create') }}" class="btn btn-info">Add New Member</a>
    </div>

    @php
        $overdueBooks = \App\Models\BorrowRecord::whereNull('returned_at')
            ->where('due_date', '<', now())
            ->with(['member', 'book'])
            ->get();
    @endphp

    <div style="margin-top: 30px;">
        <h3>Overdue Books ({{ $overdueBooks->count() }})</h3>
        @if($overdueBooks->isNotEmpty())
            <table>
                <thead>
                    <tr><th>Member</th><th>Book</th><th>Due Date</th></tr>
                </thead>
                <tbody>
                    @foreach($overdueBooks as $record)
                        <tr>
                            <td>{{ $record->member->name }}</td>
                            <td>{{ $record->book->title }}</td>
                            <td>{{ $record->due_date->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No overdue books. Great job!</p>
        @endif
    </div>
</div>
@endsection