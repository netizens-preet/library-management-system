@extends('layouts.app')

@section('content')
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Borrowing Records</h2>
        <a href="{{ route('borrows.create') }}" class="btn btn-success">+ Issue New Book</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Member</th>
                <th>Book</th>
                <th>Due Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $record)
                <tr style="{{ !$record->returned_at && $record->due_date->isPast() ? 'background-color: #fff3cd;' : '' }}">
                    <td>{{ $record->member->name ?? 'Unknown Member' }}</td>
                    <td>
                        {{ $record->book->title ?? 'Book Deleted' }}
                        @if($record->book && $record->book->trashed())
                            <span style="color: red; font-size: 0.7em;">(OUT OF CATALOG)</span>
                        @endif
                    </td>
                    <td>
                        {{ $record->due_date->format('d M, Y') }}
                        @if(!$record->returned_at && $record->due_date->isPast())
                            <br><small style="color: red; font-weight: bold;">⚠️ OVERDUE</small>
                        @endif
                    </td>
                    <td>
                        @if(!$record->returned_at)
                            <form action="{{ route('borrows.update', $record->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-sm btn-success">Mark Returned</button>
                            </form>
                        @else
                            <span style="color: green;">✓ Returned ({{ $record->returned_at->format('d M') }})</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 30px;">No borrowing history found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection