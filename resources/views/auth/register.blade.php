@extends('layouts.auth')
@section('title', 'Create Account')
@section('content')
<form method="POST" action="{{ route('register') }}" class="auth-form">
    @csrf
    <div class="form-group">
        <label for="name" class="form-label">Full Name</label>
        <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}" required autofocus placeholder="John Doe">
    </div>
    <div class="form-group">
        <label for="email" class="form-label">Email Address</label>
        <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}" required placeholder="you@company.com">
    </div>
    <div class="form-row">
        <div class="form-group">
            <label for="employee_id" class="form-label">Employee ID</label>
            <input type="text" id="employee_id" name="employee_id" class="form-input" value="{{ old('employee_id') }}" placeholder="EMP001">
        </div>
        <div class="form-group">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" id="phone" name="phone" class="form-input" value="{{ old('phone') }}" placeholder="+234...">
        </div>
    </div>
    <div class="form-group">
        <label for="department" class="form-label">Department</label>
        <input type="text" id="department" name="department" class="form-input" value="{{ old('department') }}" placeholder="Applications Support">
    </div>
    <div class="form-group">
        <label for="password" class="form-label">Password</label>
        <input type="password" id="password" name="password" class="form-input" required placeholder="Min. 8 characters">
    </div>
    <div class="form-group">
        <label for="password_confirmation" class="form-label">Confirm Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required placeholder="••••••••">
    </div>
    <button type="submit" class="btn btn--primary btn--full">Create Account</button>
    <p class="auth-form__footer">Already have an account? <a href="{{ route('login') }}">Sign In</a></p>
</form>
@endsection
