@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<div class="hig-page-header">
  <div class="hig-header-row">
    <div>
      <h1>Categories</h1>
      <p class="subhead">{{ $categories->count() }} {{ Str::plural('category', $categories->count()) }}</p>
    </div>
    <a href="{{ route('categories.create') }}" class="btn-hig btn-primary">
      <svg width="13" height="13" viewBox="0 0 16 16" fill="none" aria-hidden="true">
        <path d="M8 3V13M3 8H13" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
      </svg>
      New Category
    </a>
  </div>
</div>

@if($categories->isEmpty())
  <div class="hig-empty">
    <div class="empty-icon">🏷️</div>
    <h2>No categories yet</h2>
    <p>Create your first category to organise tasks.</p>
    <a href="{{ route('categories.create') }}" class="btn-hig btn-primary">New Category</a>
  </div>
@else
  <div class="task-list">
    @foreach($categories as $category)
      <div class="task-card" style="align-items:center;">
        <span class="cat-dot" style="background:{{ $category->color }};"></span>
        <div class="task-body">
          <p class="task-title" style="margin:0;">{{ $category->name }}</p>
          <p class="task-desc" style="margin:4px 0 0;">{{ $category->tasks_count }} {{ Str::plural('task', $category->tasks_count) }}</p>
        </div>
        <div class="task-actions">
          <a href="{{ route('categories.edit', $category) }}" class="btn-hig btn-icon" title="Edit" aria-label="Edit">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
              <path d="M11.5 1.5L14.5 4.5L5 14H2V11L11.5 1.5Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
            </svg>
          </a>
          <form method="POST" action="{{ route('categories.destroy', $category) }}" style="margin:0;">
            @csrf @method('DELETE')
            <button type="submit" class="btn-hig btn-icon danger" title="Delete"
              onclick="return confirm('Delete {{ $category->name }}?')">
              <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path d="M2 4H14M5 4V2H11V4M6 7V12M10 7V12M3 4L4 14H12L13 4H3Z"
                  stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </form>
        </div>
      </div>
    @endforeach
  </div>
@endif
@endsection
