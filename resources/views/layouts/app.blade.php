<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Tasks') · KIU</title>
  <link rel="icon" type="image/svg+xml" href="/favicon.svg">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;550;600;700&display=swap">
  <link rel="stylesheet" href="/css/hig.css">
</head>
<body>

<a href="#main" class="skip-link">Skip to content</a>

<nav class="hig-navbar" aria-label="Primary">
  <div class="hig-navbar-inner">
    <div class="hig-navbar-left">
      <a href="{{ auth()->check() ? route('tasks.index') : route('login') }}" class="hig-navbar-brand">KIU Task Manager</a>

      @auth
        <div class="hig-nav-links">
          <a href="{{ route('tasks.index') }}"
             class="hig-nav-link {{ request()->routeIs('tasks.*') ? 'active' : '' }}"
             @if(request()->routeIs('tasks.*')) aria-current="page" @endif>Tasks</a>
          <a href="{{ route('categories.index') }}"
             class="hig-nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}"
             @if(request()->routeIs('categories.*')) aria-current="page" @endif>Categories</a>
        </div>
      @endauth
    </div>

    <div class="hig-navbar-right">
      @auth
        <span class="nav-user-name">{{ auth()->user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
          @csrf
          <button type="submit" class="btn-hig btn-secondary" style="font-size:13px;">Sign Out</button>
        </form>
      @else
        <a href="{{ route('login') }}" class="btn-hig btn-secondary" style="font-size:13px;">Sign In</a>
        <a href="{{ route('register') }}" class="btn-hig btn-primary" style="font-size:13px;">Register</a>
      @endauth
    </div>
  </div>
</nav>

<main id="main" class="hig-container" style="padding-bottom: 48px;">

  @if(session('success'))
  <div class="hig-flash hig-flash-success mt-4" role="alert">
    <span>{{ session('success') }}</span>
    <button class="hig-flash-close" onclick="this.parentElement.remove()" aria-label="Dismiss">&times;</button>
  </div>
  @endif

  @if(session('error'))
  <div class="hig-flash hig-flash-error mt-4" role="alert">
    <span>{{ session('error') }}</span>
    <button class="hig-flash-close" onclick="this.parentElement.remove()" aria-label="Dismiss">&times;</button>
  </div>
  @endif

  @yield('content')
</main>

<footer class="hig-footer">KIU · Student Task Manager</footer>

</body>
</html>
