@extends('layouts.app')

@section('content')
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Member Management</h2>
        <a href="{{ route('members.create') }}" class="btn btn-success">+ Register New Member</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($members as $member)
                <tr style="{{ !$member->is_active ? 'background-color: #f8f9fa; color: #6c757d;' : '' }}">
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->email }}</td>
                    <td>
                        @if($member->is_active)
                            <span style="color: green; font-weight: bold;">● Active</span>
                        @else
                            <span style="color: red;">○ Inactive</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 10px;">
                            <a href="{{ route('members.edit', $member->id) }}" class="btn btn-sm btn-info">Edit</a>

                            @if($member->is_active)
                                <form action="{{ route('members.destroy', $member->id) }}" method="POST">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-warning" 
                                            onclick="return confirm('Are you sure you want to deactivate {{ $member->name }}?')">
                                        Deactivate
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('members.update', $member->id) }}" method="POST">
                                    @csrf 
                                    @method('PUT')
                                    <input type="hidden" name="is_active" value="1">
                                    <input type="hidden" name="name" value="{{ $member->name }}">
                                    <input type="hidden" name="email" value="{{ $member->email }}">
                                    <button type="submit" class="btn btn-sm btn-success">
                                        Reactivate
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 50px; color: #888;">
                        <p>No members found in the system.</p>
                        <a href="{{ route('members.create') }}" class="btn btn-primary">Add your first member</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection