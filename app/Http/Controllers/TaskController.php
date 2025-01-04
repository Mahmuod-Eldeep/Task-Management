<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::query();

        if (Auth::user()->role === 'user') {
            $query->where('user_id', Auth::id());
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('due_date', [$request->start_date, $request->end_date]);
        }

        if ($request->has('user_id') && Auth::user()->role === 'manager') {
            $query->where('user_id', $request->user_id);
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $this->authorize('create', Task::class);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'user_id' => 'required|exists:users,id',
        ]);

        $task = Task::create($validatedData);

        return response()->json($task, 201);
    }

    public function show(Task $task)
    {
        $this->authorize('view', $task);

        return response()->json($task->load('dependencies'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $validatedData = $request->validate([
            'title' => 'string|max:255',
            'description' => 'string',
            'status' => 'in:pending,completed,canceled',
            'due_date' => 'date',
            'user_id' => 'exists:users,id',
        ]);
        if (isset($validatedData['status']) && $validatedData['status'] === 'completed') {
            if (!$this->checkDependencies($task)) {
                return response()->json([
                    'message' => 'Cannot complete task. Some dependencies are not completed yet.'
                ], 400);
            }
        }


        $task->update($validatedData);

        return response()->json($task);
    }

    public function addDependency(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $validatedData = $request->validate([
            'dependency_id' => 'required|exists:tasks,id',
        ]);

        $task->dependencies()->attach($validatedData['dependency_id']);

        return response()->json($task->load('dependencies'));
    }
    protected function checkDependencies(Task $task)
    {
        foreach ($task->dependencies as $dependency) {
            if ($dependency->status !== 'completed') {
                return false;
            }
        }
        return true;
    }
}
