@extends('layouts.app')

@section('title', 'Tasks')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Tasks</h1>
    <a href="{{ route('tasks.create') }}" class="btn btn-success">
        <i class="bi bi-plus-lg me-1"></i> New Task
    </a>
</div>

<form method="GET" action="{{ route('tasks.index') }}" class="row g-2 align-items-end mb-3">
    <div class="col-md-4">
        <label class="form-label">Search</label>
        <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Title or description">
    </div>
    <div class="col-md-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="">All</option>
            <option value="pending" @selected($status==='pending')>Pending</option>
            <option value="done" @selected($status==='done')>Done</option>
        </select>
    </div>
    <div class="col-md-5">
        <button class="btn btn-primary me-2">Apply</button>
        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">Reset</a>
    </div>
    <div class="col-12">
        <small class="text-muted">Tip: You can combine search and filters.</small>
    </div>
    <div class="col-12">
        <hr>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>Title</th>
                <th>Status</th>
                <th>Deadline</th>
                <th>Created</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($tasks as $task)
            <tr class="{{ $task->status === 'done' ? 'table-success' : '' }}">
                <td>
                    <div class="fw-semibold">{{ $task->title }}</div>
                    @if($task->description)
                        <div class="text-muted small">{{ \Illuminate\Support\Str::limit($task->description, 120) }}</div>
                    @endif
                </td>
                <td>
                    @if ($task->status === 'done')
                        <span class="badge text-bg-success"><i class="bi bi-check2-circle me-1"></i>Done</span>
                    @else
                        <span class="badge text-bg-warning"><i class="bi bi-hourglass-split me-1"></i>Pending</span>
                    @endif
                </td>
                <td>{{ $task->deadline?->format('Y-m-d') ?? '—' }}</td>
                <td>{{ $task->created_at->diffForHumans() }}</td>
                <td class="text-end">
                    <div class="d-flex justify-content-end flex-wrap form-actions">
                        <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                            @csrf
                            @if ($task->status==='done')
                                <button class="btn btn-sm btn-outline-secondary" title="Mark as Pending">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i> Pending
                                </button>
                            @else
                                <button class="btn btn-sm btn-outline-success" title="Mark as Done">
                                    <i class="bi bi-check2-circle me-1"></i> Done
                                </button>
                            @endif
                        </form>
                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-primary" title="Edit task">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Delete this task?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" title="Delete task">
                                <i class="bi bi-trash me-1"></i> Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center text-muted py-4">No tasks found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

{{ $tasks->links() }}
@endsection

