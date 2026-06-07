@extends('layouts.app')
@section('title', 'Manage Activities')
@section('page-title', 'Manage Activities')
@section('content')
<div class="page-header">
    <div>
        <p class="page-header__subtitle">Define and manage daily activities for the support team</p>
    </div>
    <a href="{{ route('activities.create') }}" class="btn btn--primary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        New Activity
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Recurring</th>
                    <th>Status</th>
                    <th>Created By</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activities as $activity)
                <tr>
                    <td>
                        <strong>{{ $activity->title }}</strong>
                        @if($activity->description)
                            <br><small class="text-muted">{{ Str::limit($activity->description, 60) }}</small>
                        @endif
                    </td>
                    <td><span class="activity-card__category">{{ $activity->category ?? '—' }}</span></td>
                    <td>{{ $activity->is_recurring ? 'Yes' : 'No' }}</td>
                    <td>
                        <span class="badge {{ $activity->is_active ? 'badge--done' : 'badge--pending' }}">
                            {{ $activity->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>{{ $activity->creator->name ?? 'N/A' }}</td>
                    <td>
                        <div class="table-actions">
                            <a href="{{ route('activities.edit', $activity) }}" class="btn btn--sm btn--ghost">Edit</a>
                            <form method="POST" action="{{ route('activities.destroy', $activity) }}" onsubmit="return confirm('Deactivate this activity?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn--sm btn--ghost btn--danger">Deactivate</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center">No activities defined yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card__footer">
        {{ $activities->links() }}
    </div>
</div>
@endsection
