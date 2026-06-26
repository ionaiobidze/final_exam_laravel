<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('categories')->latest()->paginate(20);
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'status'      => ['required', 'in:pending,done'],
            'deadline'    => ['nullable', 'date'],
        ]);

        $task = Task::create($data);

        return response()->json($task, 201);
    }

    public function show(Task $task)
    {
        return response()->json($task->load('categories'));
    }

    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'title'       => ['sometimes', 'required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'status'      => ['sometimes', 'required', 'in:pending,done'],
            'deadline'    => ['nullable', 'date'],
        ]);

        $task->update($data);

        return response()->json($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(['message' => 'Task deleted.']);
    }
}
