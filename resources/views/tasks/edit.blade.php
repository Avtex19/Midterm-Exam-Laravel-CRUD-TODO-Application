@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')
<div class="col-lg-8 mx-auto">
<h1 class="h3 mb-3">Edit Task</h1>
<form method="POST" action="{{ route('tasks.update', $task) }}" class="card p-3">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="title" value="{{ old('title', $task->title) }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="4">{{ old('description', $task->description) }}</textarea>
    </div>
    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="pending" @selected(old('status', $task->status)==='pending')>Pending</option>
                <option value="done" @selected(old('status', $task->status)==='done')>Done</option>
            </select>
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Deadline</label>
            <input type="date" name="deadline" value="{{ old('deadline', optional($task->deadline)->format('Y-m-d')) }}" class="form-control">
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">Cancel</a>
        <button class="btn btn-primary"><i class="bi bi-save me-1"></i>Save Changes</button>
    </div>
    </form>
</div>
@endsection

