@extends('layouts.app')
@section('title', 'Add Team Member')
@section('page-title', 'Add Team Member')
@section('content')
<div class="card" style="max-width: 700px;">
    <form method="POST" action="{{ route('users.store') }}" class="card__body">
        @csrf
        <div class="form-row">
            <div class="form-group">
                <label for="name" class="form-label">Full Name <span class="required">*</span></label>
                <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <label for="email" class="form-label">Email <span class="required">*</span></label>
                <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="employee_id" class="form-label">Employee ID</label>
                <input type="text" id="employee_id" name="employee_id" class="form-input" value="{{ old('employee_id') }}">
            </div>
            <div class="form-group">
                <label for="role" class="form-label">Role <span class="required">*</span></label>
                <select id="role" name="role" class="form-input" required>
                    <option value="member" {{ old('role') === 'member' ? 'selected' : '' }}>Member</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="department" class="form-label">Department</label>
                <input type="text" id="department" name="department" class="form-input" value="{{ old('department') }}">
            </div>
            <div class="form-group">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" id="phone" name="phone" class="form-input" value="{{ old('phone') }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="password" class="form-label">Password <span class="required">*</span></label>
                <input type="password" id="password" name="password" class="form-input" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirm Password <span class="required">*</span></label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required>
            </div>
        </div>
        <div class="form-actions">
            <a href="{{ route('users.index') }}" class="btn btn--secondary">Cancel</a>
            <button type="submit" class="btn btn--primary">Create Member</button>
        </div>
    </form>
</div>
@endsection
