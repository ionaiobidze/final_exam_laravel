@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')
<div class="hig-page-header">
  <h1>Edit Task</h1>
</div>

<div class="hig-card">
  <form method="POST" action="{{ route('tasks.update', $task) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('tasks._form', ['task' => $task, 'categories' => $categories, 'selectedIds' => $selectedIds])
    <div class="hig-form-actions">
      <button type="submit" class="btn-hig btn-primary">Save Changes</button>
      <a href="{{ route('tasks.index') }}" class="btn-hig btn-secondary">Cancel</a>
    </div>
  </form>
</div>
@endsection
