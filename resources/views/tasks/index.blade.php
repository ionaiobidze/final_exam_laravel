@extends('layouts.app')

@section('title', 'Tasks')

@section('content')
<div class="hig-page-header">
  <div class="hig-header-row">
    <div>
      <h1>Tasks</h1>
      <p class="subhead">{{ $tasks->total() }} {{ Str::plural('task', $tasks->total()) }}</p>
    </div>
    <a href="{{ route('tasks.create') }}" class="btn-hig btn-primary">
      <svg width="13" height="13" viewBox="0 0 16 16" fill="none" aria-hidden="true">
        <path d="M8 3V13M3 8H13" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
      </svg>
      New Task
    </a>
  </div>
</div>

{{-- Filter pills --}}
<div class="hig-segment" role="navigation" aria-label="Filter tasks">
  @foreach(['all' => 'All', 'pending' => 'Pending', 'done' => 'Done', 'overdue' => 'Overdue'] as $key => $label)
    @php $isActive = $filter === $key || ($key === 'all' && $filter === 'all'); @endphp
    <a href="{{ route('tasks.index', array_filter(['filter' => $key === 'all' ? null : $key, 'q' => $q ?: null])) }}"
       class="{{ $isActive ? 'active' : '' }}"
       @if($isActive) aria-current="page" @endif>
      {{ $label }}
    </a>
  @endforeach
</div>

{{-- Search --}}
<form method="GET" action="{{ route('tasks.index') }}" class="hig-search-form" role="search">
  @if($filter !== 'all')
    <input type="hidden" name="filter" value="{{ $filter }}">
  @endif
  <input
    type="search" name="q" value="{{ $q }}"
    placeholder="Search tasks…"
    class="hig-search-input"
    aria-label="Search tasks"
  >
  <button type="submit" class="btn-hig btn-secondary">Search</button>
  @if($q)
    <a href="{{ route('tasks.index', $filter !== 'all' ? ['filter' => $filter] : []) }}"
       class="btn-hig btn-secondary">Clear</a>
  @endif
</form>

{{-- Task list --}}
@if($tasks->isEmpty())
  <div class="hig-empty">
    <div class="empty-icon">📭</div>
    <h2>No tasks here</h2>
    <p>{{ $q ? 'No results for "' . e($q) . '".' : 'Nothing in this filter yet.' }}</p>
    <a href="{{ route('tasks.index') }}" class="btn-hig btn-secondary">View All Tasks</a>
  </div>
@else
  <div class="task-list" id="task-list">
    @foreach($tasks as $task)
      @php
        $overdue = $task->status === 'pending' && $task->deadline && $task->deadline->isPast();
      @endphp
      <div class="task-card {{ $task->status === 'done' ? 'is-done' : '' }}"
           id="task-card-{{ $task->id }}"
           data-status="{{ $task->status }}"
           data-overdue="{{ $overdue ? '1' : '0' }}">

        {{-- AJAX toggle checkbox --}}
        <div class="task-toggle-wrap">
          <input
            type="checkbox"
            class="task-toggle"
            data-id="{{ $task->id }}"
            {{ $task->status === 'done' ? 'checked' : '' }}
            aria-label="Mark {{ $task->status === 'done' ? 'pending' : 'done' }}"
          >
        </div>

        <div class="task-body">
          <p class="task-title">
            <a href="{{ route('tasks.show', $task) }}">
              <span class="title-text">{{ $task->title }}</span>
            </a>
          </p>
          @if($task->description)
            <p class="task-desc">{{ $task->description }}</p>
          @endif
          <div class="task-meta">
            <span class="status-badge {{ $task->status }}">{{ ucfirst($task->status) }}</span>
            @if($task->deadline)
              <span class="deadline-pill {{ $overdue ? 'overdue' : '' }}">
                {{ $task->deadline->format('M j, Y') }}{{ $overdue ? ' · Overdue' : '' }}
              </span>
            @endif
          </div>
        </div>

        <div class="task-actions">
          <a href="{{ route('tasks.edit', $task) }}" class="btn-hig btn-icon" title="Edit task" aria-label="Edit">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M11.5 1.5L14.5 4.5L5 14H2V11L11.5 1.5Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
            </svg>
          </a>
          <form method="POST" action="{{ route('tasks.destroy', $task) }}" style="margin:0;">
            @csrf @method('DELETE')
            <button
              type="submit"
              class="btn-hig btn-icon danger"
              title="Delete task"
              aria-label="Delete"
              onclick="return confirm('Delete this task? This cannot be undone.')"
            >
              <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M2 4H14M5 4V2H11V4M6 7V12M10 7V12M3 4L4 14H12L13 4H3Z"
                  stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </form>
          <span class="task-chevron" aria-hidden="true">
            <svg width="14" height="14" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M6 3L11 8L6 13" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
        </div>

      </div>
    @endforeach
  </div>

  {{-- Pagination --}}
  @if($tasks->hasPages())
    <div class="hig-pagination">
      {!! $tasks->withQueryString()->links('pagination::bootstrap-5') !!}
    </div>
  @endif
@endif

<script>
document.querySelectorAll('.task-toggle').forEach(el => {
  el.addEventListener('change', async (e) => {
    const id = e.target.dataset.id;
    const card = document.getElementById('task-card-' + id);
    try {
      const res = await fetch(`/tasks/${id}/toggle`, {
        method: 'PATCH',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'Accept': 'application/json'
        }
      });
      const data = await res.json();
      card.classList.toggle('is-done', data.status === 'done');
      card.setAttribute('data-status', data.status);
      if (data.status === 'done') card.setAttribute('data-overdue', '0');
      const badge = card.querySelector('.status-badge');
      if (badge) {
        badge.className = 'status-badge ' + data.status;
        badge.textContent = data.status.charAt(0).toUpperCase() + data.status.slice(1);
      }
      e.target.setAttribute('aria-label',
        data.status === 'done' ? 'Mark pending' : 'Mark done');
    } catch {
      e.target.checked = !e.target.checked;
    }
  });
});
</script>
@endsection
