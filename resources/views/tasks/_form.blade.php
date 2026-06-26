@php $task = $task ?? new \App\Models\Task(); @endphp

<div class="hig-form-group">
  <label class="hig-label" for="title">Title</label>
  <input
    id="title" name="title" type="text"
    class="hig-input @error('title') is-invalid @enderror"
    value="{{ old('title', $task->title) }}"
    placeholder="What do you need to do?"
    maxlength="150"
    required
  >
  @error('title')
    <p class="hig-error">{{ $message }}</p>
  @enderror
</div>

<div class="hig-form-group">
  <label class="hig-label" for="description">Description</label>
  <textarea
    id="description" name="description"
    class="hig-textarea @error('description') is-invalid @enderror"
    placeholder="Add more details (optional)"
  >{{ old('description', $task->description) }}</textarea>
  @error('description')
    <p class="hig-error">{{ $message }}</p>
  @enderror
</div>

<div class="hig-form-group">
  <label class="hig-label">Status</label>
  <div class="hig-status-toggle">
    <input type="radio" id="status_pending" name="status" value="pending"
      {{ old('status', $task->status ?? 'pending') === 'pending' ? 'checked' : '' }}>
    <label for="status_pending">Pending</label>

    <input type="radio" id="status_done" name="status" value="done"
      {{ old('status', $task->status) === 'done' ? 'checked' : '' }}>
    <label for="status_done">Done</label>
  </div>
  @error('status')
    <p class="hig-error">{{ $message }}</p>
  @enderror
</div>

<div class="hig-form-group">
  <label class="hig-label" for="deadline">Deadline</label>
  <input
    id="deadline" name="deadline" type="date"
    class="hig-input @error('deadline') is-invalid @enderror"
    value="{{ old('deadline', $task->deadline?->format('Y-m-d')) }}"
  >
  <p class="hig-help">Optional. We'll flag the task as overdue if today passes without completion.</p>
  @error('deadline')
    <p class="hig-error">{{ $message }}</p>
  @enderror
</div>

@if(isset($categories) && $categories->isNotEmpty())
<div class="hig-form-group">
  <label class="hig-label">Categories</label>
  <div class="cat-checkbox-list">
    @foreach($categories as $cat)
      <label class="cat-checkbox-item">
        <input type="checkbox" name="categories[]" value="{{ $cat->id }}"
          {{ in_array($cat->id, $selectedIds ?? []) || in_array($cat->id, old('categories', [])) ? 'checked' : '' }}>
        <span class="cat-dot" style="background:{{ $cat->color }};"></span>
        <span>{{ $cat->name }}</span>
      </label>
    @endforeach
  </div>
  @error('categories')
    <p class="hig-error">{{ $message }}</p>
  @enderror
</div>
@endif

<div class="hig-form-group">
  <label class="hig-label" for="attachment">Attachment</label>
  @if($task->attachment)
    <div class="attachment-preview">
      <span>Current: <a href="{{ Storage::url($task->attachment) }}" target="_blank" rel="noopener">{{ basename($task->attachment) }}</a></span>
    </div>
  @endif
  <input id="attachment" name="attachment" type="file"
    class="hig-input @error('attachment') is-invalid @enderror"
    style="height:auto;padding:8px 14px;"
    accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.txt">
  <p class="hig-help">Optional. Images, PDF, Word or text files up to 4 MB.</p>
  @error('attachment')
    <p class="hig-error">{{ $message }}</p>
  @enderror
</div>
