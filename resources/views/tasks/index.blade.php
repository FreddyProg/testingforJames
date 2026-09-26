@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-dark mb-0"><i class="bi bi-check2-square text-primary me-2"></i>TaskMaster</h2>
        <p class="text-muted small mb-0">Personal Task & Goal Dashboard</p>
    </div>
    <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addTaskModal">
        <i class="bi bi-plus-lg me-1"></i> New Task
    </button>
</div>

<!-- Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-4">
        <div class="card stat-card shadow-sm bg-white p-3 text-center">
            <span class="text-muted small">Total</span>
            <h3 class="fw-bold mb-0 text-dark">{{ $stats['total'] }}</h3>
        </div>
    </div>
    <div class="col-4">
        <div class="card stat-card shadow-sm bg-white p-3 text-center">
            <span class="text-muted small">Pending</span>
            <h3 class="fw-bold mb-0 text-warning">{{ $stats['pending'] }}</h3>
        </div>
    </div>
    <div class="col-4">
        <div class="card stat-card shadow-sm bg-white p-3 text-center">
            <span class="text-muted small">Completed</span>
            <h3 class="fw-bold mb-0 text-success">{{ $stats['completed'] }}</h3>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="btn-group btn-group-sm">
        <a href="/" class="btn btn-outline-secondary {{ !request('filter') ? 'active' : '' }}">All</a>
        <a href="/?filter=Pending" class="btn btn-outline-secondary {{ request('filter') == 'Pending' ? 'active' : '' }}">Pending</a>
        <a href="/?filter=Completed" class="btn btn-outline-secondary {{ request('filter') == 'Completed' ? 'active' : '' }}">Completed</a>
    </div>
</div>

<!-- Task List -->
<div class="d-flex flex-column gap-2">
    @forelse($tasks as $task)
        <div class="card task-card task-priority-{{ $task->priority }} shadow-sm bg-white">
            <div class="card-body d-flex align-items-center justify-content-between py-3">
                <div class="d-flex align-items-center gap-3">
                    <form action="{{ route('tasks.toggle', $task, false) }}" method="POST" class="m-0">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm rounded-circle p-0 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; border: 2px solid {{ $task->status === 'Completed' ? '#198754' : '#adb5bd' }}; background: {{ $task->status === 'Completed' ? '#198754' : 'transparent' }}; color: white;">
                            @if($task->status === 'Completed') <i class="bi bi-check"></i> @endif
                        </button>
                    </form>
                    <div>
                        <span class="fw-semibold {{ $task->status === 'Completed' ? 'text-decoration-line-through text-muted' : 'text-dark' }}">
                            {{ $task->title }}
                        </span>
                        <div class="d-flex align-items-center gap-2 mt-1">
                            <span class="badge badge-category rounded-pill">{{ $task->category }}</span>
                            <span class="badge bg-{{ $task->priority === 'High' ? 'danger' : ($task->priority === 'Medium' ? 'warning text-dark' : 'info') }} rounded-pill" style="font-size: 0.65rem;">
                                {{ $task->priority }}
                            </span>
                            @if($task->due_date)
                                <span class="small text-muted" style="font-size: 0.75rem;">
                                    <i class="bi bi-calendar3 me-1"></i>{{ $task->due_date }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-1">
                    <button class="btn btn-sm btn-light text-secondary" data-bs-toggle="modal" data-bs-target="#editTaskModal{{ $task->id }}">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <form action="{{ route('tasks.destroy', $task, false) }}" method="POST" class="m-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-light text-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editTaskModal{{ $task->id }}" tabindex="-1">
            <div class="modal-dialog">
                <form action="{{ route('tasks.update', $task, false) }}" method="POST" class="modal-content">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Edit Task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body d-flex flex-column gap-3">
                        <div>
                            <label class="form-label small fw-bold">Title</label>
                            <input type="text" name="title" value="{{ $task->title }}" class="form-control" required>
                        </div>
                        <div class="row g-2">
                            <div class="col-6">
                                <label class="form-label small fw-bold">Category</label>
                                <input type="text" name="category" value="{{ $task->category }}" class="form-control" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">Priority</label>
                                <select name="priority" class="form-select">
                                    <option value="Low" {{ $task->priority === 'Low' ? 'selected' : '' }}>Low</option>
                                    <option value="Medium" {{ $task->priority === 'Medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="High" {{ $task->priority === 'High' ? 'selected' : '' }}>High</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="form-label small fw-bold">Due Date</label>
                            <input type="date" name="due_date" value="{{ $task->due_date }}" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    @empty
        <div class="text-center py-5 bg-white rounded-3 shadow-sm text-muted">
            <i class="bi bi-inbox display-5 d-block mb-2"></i>
            <p class="mb-0">No tasks found. Click "New Task" to create one!</p>
        </div>
    @endforelse
</div>

<!-- Add Task Modal -->
<div class="modal fade" id="addTaskModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('tasks.store', [], false) }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Create New Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body d-flex flex-column gap-3">
                <div>
                    <label class="form-label small fw-bold">Title</label>
                    <input type="text" name="title" class="form-control" placeholder="What needs to be done?" required>
                </div>
                <div class="row g-2">
                    <div class="col-6">
                        <label class="form-label small fw-bold">Category</label>
                        <input type="text" name="category" class="form-control" placeholder="e.g. Work, School, Personal" value="Personal">
                    </div>
                    <div class="col-6">
                        <label class="form-label small fw-bold">Priority</label>
                        <select name="priority" class="form-select">
                            <option value="Low">Low</option>
                            <option value="Medium" selected>Medium</option>
                            <option value="High">High</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="form-label small fw-bold">Due Date</label>
                    <input type="date" name="due_date" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Add Task</button>
            </div>
        </form>
    </div>
</div>
@endsection