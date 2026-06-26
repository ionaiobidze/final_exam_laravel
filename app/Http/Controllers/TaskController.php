<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'all');
        $q      = $request->query('q', '');

        $query = Auth::user()->tasks()->with('categories');

        match ($filter) {
            'pending' => $query->pending(),
            'done'    => $query->done(),
            'overdue' => $query->overdue(),
            default   => null,
        };

        if ($q !== '') {
            $query->where(function ($w) use ($q) {
                $w->where('title', 'like', "%{$q}%")
                  ->orWhere('description', 'like', "%{$q}%");
            });
        }

        $query->orderByRaw("CASE WHEN deadline IS NULL THEN 1 ELSE 0 END, deadline ASC")
              ->orderBy('created_at', 'desc');

        $tasks = $query->paginate(15)->withQueryString();

        return view('tasks.index', compact('tasks', 'filter', 'q'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('tasks.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'status'      => ['required', 'in:pending,done'],
            'deadline'    => ['nullable', 'date'],
            'attachment'  => ['nullable', 'file', 'max:4096', 'mimes:jpg,jpeg,png,gif,pdf,doc,docx,txt'],
            'categories'  => ['nullable', 'array'],
            'categories.*' => ['exists:categories,id'],
        ]);

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('attachments', 'public');
        }

        $data['user_id'] = Auth::id();
        unset($data['categories']);

        $task = Task::create($data);

        if ($request->filled('categories')) {
            $task->categories()->sync($request->input('categories'));
        }

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
    {
        $this->authorizeTask($task);
        $task->load('categories');
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $this->authorizeTask($task);
        $categories = Category::orderBy('name')->get();
        $selectedIds = $task->categories()->pluck('categories.id')->toArray();
        return view('tasks.edit', compact('task', 'categories', 'selectedIds'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorizeTask($task);

        $data = $request->validate([
            'title'       => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'status'      => ['required', 'in:pending,done'],
            'deadline'    => ['nullable', 'date'],
            'attachment'  => ['nullable', 'file', 'max:4096', 'mimes:jpg,jpeg,png,gif,pdf,doc,docx,txt'],
            'categories'  => ['nullable', 'array'],
            'categories.*' => ['exists:categories,id'],
        ]);

        if ($request->hasFile('attachment')) {
            if ($task->attachment) {
                Storage::disk('public')->delete($task->attachment);
            }
            $data['attachment'] = $request->file('attachment')->store('attachments', 'public');
        }

        unset($data['categories']);
        $task->update($data);

        $task->categories()->sync($request->input('categories', []));

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $this->authorizeTask($task);

        if ($task->attachment) {
            Storage::disk('public')->delete($task->attachment);
        }

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted.');
    }

    public function toggle(Task $task)
    {
        $this->authorizeTask($task);

        $task->status = $task->status === 'done' ? 'pending' : 'done';
        $task->save();

        return response()->json(['status' => $task->status]);
    }

    private function authorizeTask(Task $task): void
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }
    }
}
