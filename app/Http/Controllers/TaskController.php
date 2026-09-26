<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::query();

        if ($request->has('filter') && in_array($request->filter, ['Pending', 'Completed'])) {
            $query->where('status', $request->filter);
        }

        $tasks = $query->latest()->get();

        $stats = [
            'total' => Task::count(),
            'completed' => Task::where('status', 'Completed')->count(),
            'pending' => Task::where('status', 'Pending')->count(),
        ];

        return view('tasks.index', compact('tasks', 'stats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string',
            'priority' => 'required|in:Low,Medium,High',
            'due_date' => 'nullable|date',
        ]);

        $validated['status'] = 'Pending';
        $validated['category'] = $validated['category'] ?? 'Personal';

        Task::create($validated);

        return redirect()->back();
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string',
            'priority' => 'required|in:Low,Medium,High',
            'due_date' => 'nullable|date',
        ]);

        $task->update($validated);

        return redirect()->back();
    }

    public function toggle(Task $task)
    {
        $task->update([
            'status' => $task->status === 'Completed' ? 'Pending' : 'Completed',
        ]);

        return redirect()->back();
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->back();
    }
}