<form action="{{ route('members.update', $member->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Name</label>
    <input type="text" name="name" value="{{ old('name', $member->name) }}">

    <label>Email</label>
    <input type="email" name="email" value="{{ old('email', $member->email) }}">

    <label>Phone</label>
    <input type="text" name="phone" value="{{ old('phone', $member->phone) }}">

    <label>Account Status</label>
    <select name="is_active">
        <option value="1" {{ $member->is_active ? 'selected' : '' }}>Active</option>
        <option value="0" {{ !$member->is_active ? 'selected' : '' }}>Inactive (Deactivated)</option>
    </select>

    <button type="submit">Update Member</button>
</form>