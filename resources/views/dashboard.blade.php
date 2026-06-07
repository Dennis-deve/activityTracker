@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Daily Activity Tracker')
@section('content')

<!-- Date Navigation -->
<div class="date-nav">
    <a href="{{ route('dashboard', ['date' => $selectedDate->copy()->subDay()->toDateString()]) }}" class="date-nav__arrow" title="Previous Day">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
    </a>
    <div class="date-nav__current">
        <form method="GET" action="{{ route('dashboard') }}" class="date-nav__form">
            <input type="date" name="date" value="{{ $selectedDate->toDateString() }}" class="date-nav__input" onchange="this.form.submit()">
        </form>
        <span class="date-nav__label">{{ $selectedDate->format('l, F j, Y') }}</span>
        @if($selectedDate->isToday())
            <span class="badge badge--info">Today</span>
        @endif
    </div>
    <a href="{{ route('dashboard', ['date' => $selectedDate->copy()->addDay()->toDateString()]) }}" class="date-nav__arrow" title="Next Day">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
    </a>
</div>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card stat-card--total">
        <div class="stat-card__icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/></svg>
        </div>
        <div class="stat-card__info">
            <span class="stat-card__value">{{ $totalActivities }}</span>
            <span class="stat-card__label">Total Activities</span>
        </div>
    </div>
    <div class="stat-card stat-card--done">
        <div class="stat-card__icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        </div>
        <div class="stat-card__info">
            <span class="stat-card__value">{{ $doneCount }}</span>
            <span class="stat-card__label">Completed</span>
        </div>
    </div>
    <div class="stat-card stat-card--pending">
        <div class="stat-card__icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>
        <div class="stat-card__info">
            <span class="stat-card__value">{{ $pendingCount }}</span>
            <span class="stat-card__label">Pending</span>
        </div>
    </div>
    <div class="stat-card stat-card--assigned">
        <div class="stat-card__icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
        </div>
        <div class="stat-card__info">
            <span class="stat-card__value">{{ $assignedCount }}</span>
            <span class="stat-card__label">Assigned</span>
        </div>
    </div>
</div>

<!-- Activity Cards -->
<div class="activity-list">
    @forelse($dailyLogs as $log)
    <div class="activity-card {{ $log->current_status === 'done' ? 'activity-card--done' : 'activity-card--pending' }}">
        <div class="activity-card__header">
            <div class="activity-card__title-row">
                <span class="activity-card__status-dot"></span>
                <h3 class="activity-card__title">{{ $log->activity->title }}</h3>
                <span class="badge badge--{{ $log->current_status }}">{{ ucfirst($log->current_status) }}</span>
            </div>
            @if($log->activity->description)
                <p class="activity-card__desc">{{ $log->activity->description }}</p>
            @endif
            @if($log->activity->category)
                <span class="activity-card__category">{{ $log->activity->category }}</span>
            @endif
        </div>

        <!-- Assignment Info -->
        @if($log->assignedUser)
        <div class="activity-card__assignment">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            <span>Assigned to <strong>{{ $log->assignedUser->name }}</strong></span>
            @if($log->assignedByUser)
                <span class="text-muted">by {{ $log->assignedByUser->name }} at {{ $log->assigned_at->format('H:i') }}</span>
            @endif
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="activity-card__actions">
            <button class="btn btn--sm btn--primary" onclick="openUpdateModal({{ $log->id }}, '{{ $log->current_status }}')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Update Status
            </button>
            <button class="btn btn--sm btn--secondary" onclick="openHandoverModal({{ $log->id }}, '{{ addslashes($log->activity->title) }}')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><path d="M16 3h5v5M4 20L21 3M21 16v5h-5M15 15l6 6M4 4l5 5"/></svg>
                Handover
            </button>
        </div>

        <!-- Update Timeline -->
        @if($log->updates->count() > 0)
        <div class="activity-card__timeline">
            <h4 class="timeline__title">Update History</h4>
            @foreach($log->updates as $update)
            <div class="timeline__entry">
                <div class="timeline__dot {{ $update->status === 'done' ? 'timeline__dot--done' : 'timeline__dot--pending' }}"></div>
                <div class="timeline__content">
                    <div class="timeline__meta">
                        <span class="timeline__user">
                            <strong>{{ $update->user->name }}</strong>
                            @if($update->user->employee_id)
                                <span class="text-muted">({{ $update->user->employee_id }})</span>
                            @endif
                        </span>
                        <span class="badge badge--{{ $update->status }} badge--sm">{{ ucfirst($update->status) }}</span>
                        <span class="timeline__time">{{ $update->updated_at_time->format('h:i A') }}</span>
                    </div>
                    @if($update->remark)
                        <p class="timeline__remark">{{ $update->remark }}</p>
                    @endif
                    <span class="timeline__user-dept text-muted">{{ $update->user->department ?? 'No department' }} &middot; {{ $update->user->phone ?? '' }}</span>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
    @empty
    <div class="empty-state">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="64" height="64"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        <h3>No activities for this date</h3>
        <p>There are no activities logged for {{ $selectedDate->format('F j, Y') }}.</p>
        @if(auth()->user()->isAdmin())
            <a href="{{ route('activities.create') }}" class="btn btn--primary">Create Activity</a>
        @endif
    </div>
    @endforelse
</div>

<!-- Update Status Modal -->
<div class="modal" id="updateModal">
    <div class="modal__overlay" onclick="closeModal('updateModal')"></div>
    <div class="modal__card">
        <div class="modal__header">
            <h3>Update Activity Status</h3>
            <button class="modal__close" onclick="closeModal('updateModal')">&times;</button>
        </div>
        <form id="updateForm" method="POST">
            @csrf
            <div class="modal__body">
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <div class="status-toggle">
                        <label class="status-option">
                            <input type="radio" name="status" value="done" id="status-done">
                            <span class="status-option__label status-option__label--done">Done</span>
                        </label>
                        <label class="status-option">
                            <input type="radio" name="status" value="pending" id="status-pending">
                            <span class="status-option__label status-option__label--pending">Pending</span>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="update-remark" class="form-label">Remark</label>
                    <textarea id="update-remark" name="remark" class="form-input" rows="3" placeholder="Add a remark about this update..."></textarea>
                </div>
            </div>
            <div class="modal__footer">
                <button type="button" class="btn btn--secondary" onclick="closeModal('updateModal')">Cancel</button>
                <button type="submit" class="btn btn--primary">Save Update</button>
            </div>
        </form>
    </div>
</div>

<!-- Handover Modal -->
<div class="modal" id="handoverModal">
    <div class="modal__overlay" onclick="closeModal('handoverModal')"></div>
    <div class="modal__card">
        <div class="modal__header">
            <h3>Handover Activity</h3>
            <button class="modal__close" onclick="closeModal('handoverModal')">&times;</button>
        </div>
        <form id="handoverForm" method="POST">
            @csrf
            <div class="modal__body">
                <p class="modal__activity-name" id="handoverActivityName"></p>
                <div class="form-group">
                    <label for="assigned_to" class="form-label">Assign To</label>
                    <select name="assigned_to" id="assigned_to" class="form-input" required>
                        <option value="">Select team member...</option>
                        @foreach($teamMembers as $member)
                            <option value="{{ $member->id }}">{{ $member->name }} ({{ $member->employee_id ?? $member->email }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="handover-remark" class="form-label">Handover Note</label>
                    <textarea id="handover-remark" name="remark" class="form-input" rows="3" placeholder="Add notes for the next person..."></textarea>
                </div>
            </div>
            <div class="modal__footer">
                <button type="button" class="btn btn--secondary" onclick="closeModal('handoverModal')">Cancel</button>
                <button type="submit" class="btn btn--primary">Assign</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openUpdateModal(logId, currentStatus) {
    const modal = document.getElementById('updateModal');
    const form = document.getElementById('updateForm');
    form.action = '/activity-logs/' + logId + '/update';
    
    // Set current status
    if (currentStatus === 'done') {
        document.getElementById('status-done').checked = true;
    } else {
        document.getElementById('status-pending').checked = true;
    }
    document.getElementById('update-remark').value = '';
    modal.classList.add('modal--active');
}

function openHandoverModal(logId, activityTitle) {
    const modal = document.getElementById('handoverModal');
    const form = document.getElementById('handoverForm');
    form.action = '/activity-logs/' + logId + '/assign';
    document.getElementById('handoverActivityName').textContent = activityTitle;
    document.getElementById('handover-remark').value = '';
    document.getElementById('assigned_to').value = '';
    modal.classList.add('modal--active');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.remove('modal--active');
}
</script>
@endpush
@endsection
