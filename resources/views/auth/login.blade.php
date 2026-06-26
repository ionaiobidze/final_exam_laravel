@extends('layouts.app')

@section('title', 'Sign In')

@section('content')
<div class="hig-page-header">
  <h1>Sign In</h1>
  <p class="subhead">KIU Student Task Manager</p>
</div>

<div class="hig-card">
  <form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="hig-form-group">
      <label class="hig-label" for="email">Email Address</label>
      <input id="email" name="email" type="email"
        class="hig-input @error('email') is-invalid @enderror"
        value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
      @error('email')
        <p class="hig-error">{{ $message }}</p>
      @enderror
    </div>

    <div class="hig-form-group">
      <label class="hig-label" for="password">Password</label>
      <input id="password" name="password" type="password"
        class="hig-input @error('password') is-invalid @enderror"
        placeholder="Your password" required>
      @error('password')
        <p class="hig-error">{{ $message }}</p>
      @enderror
    </div>

    <div class="hig-form-group" style="margin-bottom:0;">
      <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
        <input type="checkbox" name="remember" style="accent-color:var(--accent);">
        <span style="font-size:13px;color:var(--text-2);">Remember me</span>
      </label>
    </div>

    <div class="hig-form-actions">
      <button type="submit" class="btn-hig btn-primary">Sign In</button>
      <a href="{{ route('register') }}" class="btn-hig btn-secondary">Create Account</a>
    </div>
  </form>
</div>
@endsection
