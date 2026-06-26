@php $category = $category ?? new \App\Models\Category(); @endphp

<div class="hig-form-group">
  <label class="hig-label" for="name">Category Name</label>
  <input id="name" name="name" type="text"
    class="hig-input @error('name') is-invalid @enderror"
    value="{{ old('name', $category->name) }}"
    placeholder="e.g. Assignments, Research…"
    maxlength="80" required>
  @error('name')
    <p class="hig-error">{{ $message }}</p>
  @enderror
</div>

<div class="hig-form-group">
  <label class="hig-label" for="color">Color</label>
  <div style="display:flex;align-items:center;gap:12px;">
    <input id="color" name="color" type="color"
      class="@error('color') is-invalid @enderror"
      value="{{ old('color', $category->color ?? '#9DB2BF') }}"
      style="width:44px;height:38px;border:1px solid var(--border);border-radius:var(--r-md);background:var(--surface-2);cursor:pointer;padding:2px;">
    <span style="font-size:13px;color:var(--text-3);">Pick a colour to identify this category</span>
  </div>
  @error('color')
    <p class="hig-error">{{ $message }}</p>
  @enderror
</div>
