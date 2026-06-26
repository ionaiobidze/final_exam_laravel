@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="hig-page-header">
  <h1>Create Account</h1>
  <p class="subhead">Join KIU Student Task Manager</p>
</div>

<div class="hig-card">
  <form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="hig-form-group">
      <label class="hig-label" for="name">Full Name</label>
      <input id="name" name="name" type="text"
        class="hig-input @error('name') is-invalid @enderror"
        value="{{ old('name') }}" placeholder="Your name" required autofocus>
      @error('name')
        <p class="hig-error">{{ $message }}</p>
      @enderror
    </div>

    <div class="hig-form-group">
      <label class="hig-label" for="email">Email Address</label>
      <input id="email" name="email" type="email"
        class="hig-input @error('email') is-invalid @enderror"
        value="{{ old('email') }}" placeholder="you@example.com" required>
      @error('email')
        <p class="hig-error">{{ $message }}</p>
      @enderror
    </div>

    <div class="hig-form-group">
      <label class="hig-label" for="password">Password</label>
      <input id="password" name="password" type="password"
        class="hig-input @error('password') is-invalid @enderror"
        placeholder="Minimum 8 characters" required>
      @error('password')
        <p class="hig-error">{{ $message }}</p>
      @enderror
    </div>

    <div class="hig-form-group">
      <label class="hig-label" for="password_confirmation">Confirm Password</label>
      <input id="password_confirmation" name="password_confirmation" type="password"
        class="hig-input"
        placeholder="Repeat password" required>
    </div>

    <div class="hig-form-actions">
      <button type="submit" class="btn-hig btn-primary">Create Account</button>
      <a href="{{ route('login') }}" class="btn-hig btn-secondary">Sign In Instead</a>
    </div>
  </form>
</div>
@endsection
