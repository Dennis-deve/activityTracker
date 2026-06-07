@extends('layouts.app')
@section('title', 'Create Activity')
@section('page-title', 'Create New Activity')
@section('content')
<div class="card" style="max-width: 700px;">
    <form method="POST" action="{{ route('activities.store') }}" class="card__body">
        @csrf
        <div class="form-group">
            <label for="title" class="form-label">Activity Title <span class="required">*</span></label>
            <input type="text" id="title" name="title" class="form-input" value="{{ old('title') }}" required placeholder="e.g., Daily SMS count in comparison to SMS count from logs">
        </div>
        <div class="form-group">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" class="form-input" rows="3" placeholder="Detailed description of the activity...">{{ old('description') }}</textarea>
        </div>
        <div class="form-group">
            <label for="category" class="form-label">Category</label>
            <input type="text" id="category" name="category" class="form-input" value="{{ old('category') }}" placeholder="e.g., Monitoring, Health Check, Compliance">
        </div>
        <div class="form-group">
            <label class="form-checkbox">
                <input type="hidden" name="is_recurring" value="0">
                <input type="checkbox" name="is_recurring" value="1" {{ old('is_recurring', true) ? 'checked' : '' }}>
                <span>Recurring daily activity</span>
            </label>
            <small class="form-help">If checked, this activity will automatically appear each day on the dashboard.</small>
        </div>
        <div class="form-actions">
            <a href="{{ route('activities.index') }}" class="btn btn--secondary">Cancel</a>
            <button type="submit" class="btn btn--primary">Create Activity</button>
        </div>
    </form>
</div>
@endsection
