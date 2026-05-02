@extends('layouts.app')

@section('title', 'New Task')

@section('content')
<div class="col-lg-8 mx-auto">
<h1 class="h3 mb-3">Create Task</h1>
<form method="POST" action="{{ route('tasks.store') }}" class="card p-3">
    @csrf
    <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="title" value="{{ old('title') }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
    </div>
    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="pending" @selected(old('status','pending')==='pending')>Pending</option>
                <option value="done" @selected(old('status')==='done')>Done</option>
            </select>
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Deadline</label>
            <input type="date" name="deadline" value="{{ old('deadline') }}" class="form-control" min="{{ now()->format('Y-m-d') }}">
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">Cancel</a>
        <button class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Create</button>
    </div>
    </form>
</div>
@endsection

