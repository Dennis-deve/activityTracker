@extends('layouts.app')
@section('title', 'Edit Team Member')
@section('page-title', 'Edit Team Member')
@section('content')
<div class="card" style="max-width: 700px;">
    <form method="POST" action="{{ route('users.update', $user) }}" class="card__body">
        @csrf
        @method('PUT')
        <div class="form-row">
            <div class="form-group">
                <label for="name" class="form-label">Full Name <span class="required">*</span></label>
                <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="form-group">
                <label for="email" class="form-label">Email <span class="required">*</span></label>
                <input type="email" id="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="employee_id" class="form-label">Employee ID</label>
                <input type="text" id="employee_id" name="employee_id" class="form-input" value="{{ old('employee_id', $user->employee_id) }}">
            </div>
            <div class="form-group">
                <label for="role" class="form-label">Role <span class="required">*</span></label>
                <select id="role" name="role" class="form-input" required>
                    <option value="member" {{ old('role', $user->role) === 'member' ? 'selected' : '' }}>Member</option>
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="department" class="form-label">Department</label>
                <input type="text" id="department" name="department" class="form-input" value="{{ old('department', $user->department) }}">
            </div>
            <div class="form-group">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" id="phone" name="phone" class="form-input" value="{{ old('phone', $user->phone) }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="password" class="form-label">New Password <small class="text-muted">(leave blank to keep current)</small></label>
                <input type="password" id="password" name="password" class="form-input">
            </div>
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-input">
            </div>
        </div>
        <div class="form-actions">
            <a href="{{ route('users.index') }}" class="btn btn--secondary">Cancel</a>
            <button type="submit" class="btn btn--primary">Save Changes</button>
        </div>
    </form>
</div>
@endsection
