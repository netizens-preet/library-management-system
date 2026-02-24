<form action="{{ route('borrow.update', $borrow->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Member: {{ $borrow->member->name }}</label>
    <label>Book: {{ $borrow->book->title }}</label>

    <div>
        <label>Adjust Due Date</label>
        <input type="date" name="due_date" value="{{ $borrow->due_date->format('Y-m-d') }}">
    </div>

    <button type="submit">Update Due Date</button>
</form>