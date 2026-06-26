@extends('layouts.app')

@section('title', $task->title)

@section('content')
@php $overdue = $task->status === 'pending' && $task->deadline && $task->deadline->isPast(); @endphp

<div class="hig-page-header">
  <p class="subhead" style="margin-bottom:8px;">
    <a href="{{ route('tasks.index') }}" style="color: var(--label-3); text-decoration: none;">
      ‹ Tasks
    </a>
  </p>
  <h1>{{ $task->title }}</h1>
</div>

<div class="hig-card">
  <div class="task-show-meta">
    <span class="status-badge {{ $task->status }}">{{ ucfirst($task->status) }}</span>
    @if($task->deadline)
      <span class="deadline-pill {{ $overdue ? 'overdue' : '' }}">
        Due {{ $task->deadline->format('M j, Y') }}{{ $overdue ? ' · Overdue' : '' }}
      </span>
    @endif
    @foreach($task->categories as $cat)
      <span class="deadline-pill" style="background:{{ $cat->color }}22;color:{{ $cat->color }};border:1px solid {{ $cat->color }}44;">
        {{ $cat->name }}
      </span>
    @endforeach
  </div>

  @if($task->description)
    <p class="show-desc">{{ $task->description }}</p>
  @else
    <p style="color: var(--label-3); font-style: italic; margin: 0;">No description.</p>
  @endif

  @if($task->attachment)
    <div style="margin-top:var(--s4);padding-top:var(--s4);border-top:1px solid var(--border);">
      <p class="hig-label" style="margin-bottom:var(--s2);">Attachment</p>
      @php
        $ext = pathinfo($task->attachment, PATHINFO_EXTENSION);
        $isImage = in_array(strtolower($ext), ['jpg','jpeg','png','gif']);
      @endphp
      @if($isImage)
        <img src="{{ Storage::url($task->attachment) }}" alt="Attachment"
          style="max-width:100%;border-radius:var(--r-md);border:1px solid var(--border);">
      @else
        <a href="{{ Storage::url($task->attachment) }}" target="_blank" rel="noopener"
          class="btn-hig btn-secondary" style="display:inline-flex;">
          Download {{ basename($task->attachment) }}
        </a>
      @endif
    </div>
  @endif

  <div class="hig-form-actions">
    <a href="{{ route('tasks.edit', $task) }}" class="btn-hig btn-primary">
      <svg width="14" height="14" viewBox="0 0 16 16" fill="none">
        <path d="M11.5 1.5L14.5 4.5L5 14H2V11L11.5 1.5Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
      </svg>
      Edit
    </a>
    <a href="{{ route('tasks.index') }}" class="btn-hig btn-secondary">Back</a>
    <form method="POST" action="{{ route('tasks.destroy', $task) }}" style="margin:0 0 0 auto;">
      @csrf @method('DELETE')
      <button type="submit" class="btn-hig btn-danger"
        onclick="return confirm('Delete this task?')">Delete</button>
    </form>
  </div>
</div>
@endsection
