@extends('layouts.auth')
@section('title', 'Sign In')
@section('content')
<form method="POST" action="{{ route('login') }}" class="auth-form">
    @csrf
    <div class="form-group">
        <label for="email" class="form-label">Email Address</label>
        <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}" required autofocus placeholder="you@company.com">
    </div>
    <div class="form-group">
        <label for="password" class="form-label">Password</label>
        <input type="password" id="password" name="password" class="form-input" required placeholder="••••••••">
    </div>
    <div class="form-group form-group--inline">
        <label class="form-checkbox">
            <input type="checkbox" name="remember">
            <span>Remember me</span>
        </label>
    </div>
    <button type="submit" class="btn btn--primary btn--full">Sign In</button>
    <p class="auth-form__footer">Don't have an account? <a href="{{ route('register') }}">Register</a></p>
</form>
@endsection
