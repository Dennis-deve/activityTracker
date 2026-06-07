@extends('layouts.app')
@section('title', 'Reports')
@section('page-title', 'Activity Reports')
@section('content')

<!-- Filters Card -->
<div class="card card--filter">
    <form method="GET" action="{{ route('reports.index') }}" class="filter-form">
        <div class="filter-form__row">
            <div class="form-group">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" id="start_date" name="start_date" class="form-input" value="{{ $startDate }}">
            </div>
            <div class="form-group">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" id="end_date" name="end_date" class="form-input" value="{{ $endDate }}">
            </div>
            <div class="form-group">
                <label for="activity_id" class="form-label">Activity</label>
                <select id="activity_id" name="activity_id" class="form-input">
                    <option value="">All Activities</option>
                    @foreach($activities as $activity)
                        <option value="{{ $activity->id }}" {{ $activityId == $activity->id ? 'selected' : '' }}>{{ $activity->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-input">
                    <option value="">All Statuses</option>
                    <option value="done" {{ $status === 'done' ? 'selected' : '' }}>Done</option>
                    <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                </select>
            </div>
            <div class="form-group">
                <label for="user_id" class="form-label">Updated By</label>
                <select id="user_id" name="user_id" class="form-input">
                    <option value="">All Members</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $userId == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="filter-form__actions">
            <button type="submit" class="btn btn--primary">Apply Filters</button>
            <a href="{{ route('reports.index') }}" class="btn btn--ghost">Reset</a>
            <a href="{{ route('reports.export', request()->query()) }}" class="btn btn--secondary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                Export CSV
            </a>
        </div>
    </form>
</div>

<!-- Quick Date Presets -->
<div class="date-presets">
    <a href="{{ route('reports.index', ['start_date' => now()->toDateString(), 'end_date' => now()->toDateString()]) }}" class="btn btn--sm btn--ghost">Today</a>
    <a href="{{ route('reports.index', ['start_date' => now()->subDays(7)->toDateString(), 'end_date' => now()->toDateString()]) }}" class="btn btn--sm btn--ghost">Last 7 Days</a>
    <a href="{{ route('reports.index', ['start_date' => now()->startOfMonth()->toDateString(), 'end_date' => now()->toDateString()]) }}" class="btn btn--sm btn--ghost">This Month</a>
    <a href="{{ route('reports.index', ['start_date' => now()->subMonth()->startOfMonth()->toDateString(), 'end_date' => now()->subMonth()->endOfMonth()->toDateString()]) }}" class="btn btn--sm btn--ghost">Last Month</a>
</div>

<!-- Summary Stats -->
<div class="stats-grid stats-grid--3">
    <div class="stat-card stat-card--total">
        <div class="stat-card__info">
            <span class="stat-card__value">{{ $totalUpdates }}</span>
            <span class="stat-card__label">Total Updates</span>
        </div>
    </div>
    <div class="stat-card stat-card--done">
        <div class="stat-card__info">
            <span class="stat-card__value">{{ $doneUpdates }}</span>
            <span class="stat-card__label">Done Updates</span>
        </div>
    </div>
    <div class="stat-card stat-card--pending">
        <div class="stat-card__info">
            <span class="stat-card__value">{{ $pendingUpdates }}</span>
            <span class="stat-card__label">Pending Updates</span>
        </div>
    </div>
</div>

<!-- Results Table -->
<div class="card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Activity</th>
                    <th>Status</th>
                    <th>Updated By</th>
                    <th>Employee ID</th>
                    <th>Time</th>
                    <th>Remark</th>
                </tr>
            </thead>
            <tbody>
                @forelse($updates as $update)
                <tr>
                    <td>{{ $update->dailyLog->log_date->format('M d, Y') }}</td>
                    <td><strong>{{ $update->dailyLog->activity->title ?? 'N/A' }}</strong></td>
                    <td><span class="badge badge--{{ $update->status }}">{{ ucfirst($update->status) }}</span></td>
                    <td>
                        {{ $update->user->name ?? 'N/A' }}
                        @if($update->user->department)
                            <br><small class="text-muted">{{ $update->user->department }}</small>
                        @endif
                    </td>
                    <td>{{ $update->user->employee_id ?? '—' }}</td>
                    <td>{{ $update->updated_at_time->format('h:i A') }}</td>
                    <td>{{ Str::limit($update->remark ?? '—', 80) }}</td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center">No activity updates found for the selected criteria.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card__footer">
        {{ $updates->links() }}
    </div>
</div>
@endsection
