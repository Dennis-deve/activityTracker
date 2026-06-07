@extends('layouts.app')
@section('title', 'Team Members')
@section('page-title', 'Team Members')
@section('content')
<div class="page-header">
    <p class="page-header__subtitle">Manage applications support team personnel</p>
    <a href="{{ route('users.create') }}" class="btn btn--primary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
        Add Member
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Employee ID</th>
                    <th>Department</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td><strong>{{ $user->name }}</strong></td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->employee_id ?? '—' }}</td>
                    <td>{{ $user->department ?? '—' }}</td>
                    <td>{{ $user->phone ?? '—' }}</td>
                    <td><span class="badge {{ $user->role === 'admin' ? 'badge--info' : 'badge--done' }}">{{ ucfirst($user->role) }}</span></td>
                    <td>
                        <div class="table-actions">
                            <a href="{{ route('users.edit', $user) }}" class="btn btn--sm btn--ghost">Edit</a>
                            @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Delete this user?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn--sm btn--ghost btn--danger">Delete</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center">No team members found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card__footer">
        {{ $users->links() }}
    </div>
</div>
@endsection
