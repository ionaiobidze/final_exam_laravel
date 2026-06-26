@extends('layouts.app')

@section('title', 'New Category')

@section('content')
<div class="hig-page-header">
  <p class="subhead" style="margin-bottom:8px;">
    <a href="{{ route('categories.index') }}" style="color:var(--label-3);text-decoration:none;">‹ Categories</a>
  </p>
  <h1>New Category</h1>
</div>

<div class="hig-card">
  <form method="POST" action="{{ route('categories.store') }}">
    @csrf
    @include('categories._form')
    <div class="hig-form-actions">
      <button type="submit" class="btn-hig btn-primary">Create Category</button>
      <a href="{{ route('categories.index') }}" class="btn-hig btn-secondary">Cancel</a>
    </div>
  </form>
</div>
@endsection
