@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')
<div class="hig-page-header">
  <p class="subhead" style="margin-bottom:8px;">
    <a href="{{ route('categories.index') }}" style="color:var(--label-3);text-decoration:none;">‹ Categories</a>
  </p>
  <h1>Edit Category</h1>
</div>

<div class="hig-card">
  <form method="POST" action="{{ route('categories.update', $category) }}">
    @csrf @method('PUT')
    @include('categories._form')
    <div class="hig-form-actions">
      <button type="submit" class="btn-hig btn-primary">Save Changes</button>
      <a href="{{ route('categories.index') }}" class="btn-hig btn-secondary">Cancel</a>
      <form method="POST" action="{{ route('categories.destroy', $category) }}" style="margin:0 0 0 auto;">
        @csrf @method('DELETE')
        <button type="submit" class="btn-hig btn-danger"
          onclick="return confirm('Delete this category?')">Delete</button>
      </form>
    </div>
  </form>
</div>
@endsection
