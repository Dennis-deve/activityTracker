@extends('layouts.app')
@section('title', 'Edit Activity')
@section('page-title', 'Edit Activity')
@section('content')
<div class="card" style="max-width: 700px;">
    <form method="POST" action="{{ route('activities.update', $activity) }}" class="card__body">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title" class="form-label">Activity Title <span class="required">*</span></label>
            <input type="text" id="title" name="title" class="form-input" value="{{ old('title', $activity->title) }}" required>
        </div>
        <div class="form-group">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" class="form-input" rows="3">{{ old('description', $activity->description) }}</textarea>
        </div>
        <div class="form-group">
            <label for="category" class="form-label">Category</label>
            <input type="text" id="category" name="category" class="form-input" value="{{ old('category', $activity->category) }}">
        </div>
        <div class="form-group">
            <label class="form-checkbox">
                <input type="hidden" name="is_recurring" value="0">
                <input type="checkbox" name="is_recurring" value="1" {{ old('is_recurring', $activity->is_recurring) ? 'checked' : '' }}>
                <span>Recurring daily activity</span>
            </label>
        </div>
        <div class="form-group">
            <label class="form-checkbox">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $activity->is_active) ? 'checked' : '' }}>
                <span>Active</span>
            </label>
        </div>
        <div class="form-actions">
            <a href="{{ route('activities.index') }}" class="btn btn--secondary">Cancel</a>
            <button type="submit" class="btn btn--primary">Save Changes</button>
        </div>
    </form>
</div>
@endsection
