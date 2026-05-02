<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource with filters and pagination.
     */
    public function index(Request $request): View
    {
        $status = $request->query('status');
        $q = $request->query('q');

        $tasks = Task::query()
            ->status($status)
            ->search($q)
            ->orderByRaw('deadline IS NULL')
            ->orderBy('deadline', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('tasks.index', compact('tasks', 'status', 'q'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request): RedirectResponse
    {
        Task::create($request->validated());

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task): View
    {
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task): RedirectResponse
    {
        $task->update($request->validated());

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    /**
     * Toggle the task status between pending and done.
     */
    public function toggleStatus(Task $task): RedirectResponse
    {
        $task->status = $task->status === Task::STATUS_DONE ? Task::STATUS_PENDING : Task::STATUS_DONE;
        $task->save();

        return redirect()->back()->with('success', 'Task status updated.');
    }
}

