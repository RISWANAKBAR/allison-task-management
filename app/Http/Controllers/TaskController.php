<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasksQuery = Task::query();

   
        if ($request->filled('priority')) {
            $tasksQuery->where('priority', $request->input('priority'));
        }

    
        if ($request->filled('due_date')) {
            $tasksQuery->where('due_date', $request->input('due_date'));
        }

   
        $sort = $request->input('sort');
        if ($sort) {
            $tasksQuery->orderBy($sort);
        }

        $tasks = $tasksQuery->get();

        return view('index', compact('tasks'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:High,Medium,Low',
        ]);

        Task::create($request->all());

        return redirect()->route('tasks.index')->with('message', 'Task created successfully!');
    }

    public function edit(Task $task)
    {
        return view('edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:High,Medium,Low',
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index')->with('message', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('message', 'Task deleted successfully!');
    }

    public function markCompleted(Task $task)
    {
        $task->completed = true;
        $task->save();
    
        return redirect()->route('tasks.index')->with('message', 'Task marked as completed successfully!');
    }
}
