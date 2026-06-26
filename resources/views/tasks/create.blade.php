@extends('layouts.app')

@section('title', 'New Task')

@section('content')
<div class="hig-page-header">
  <h1>New Task</h1>
</div>

<div class="hig-card">
  <form method="POST" action="{{ route('tasks.store') }}" enctype="multipart/form-data">
    @csrf
    @include('tasks._form')
    <div class="hig-form-actions">
      <button type="submit" class="btn-hig btn-primary">Create Task</button>
      <a href="{{ route('tasks.index') }}" class="btn-hig btn-secondary">Cancel</a>
    </div>
  </form>
</div>
@endsection
