@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold text-dark">Teacher Details</h5>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.teachers.edit', $teacher) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>
                        <a href="{{ route('admin.teachers.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Back to Teachers
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">
                    <ul class="list-group list-group-flush border rounded-3 mb-4">
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="fw-semibold text-muted">User ID</span>
                            <span class="text-dark">#{{ $teacher->id }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="fw-semibold text-muted">Full name</span>
                            <span class="text-dark">{{ $teacher->name }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="fw-semibold text-muted">Email</span>
                            <span class="text-dark">
                                <a href="mailto:{{ $teacher->email }}" class="text-decoration-none">
                                    {{ $teacher->email }}
                                </a>
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="fw-semibold text-muted">Account Created</span>
                            <span class="text-dark">{{ $teacher->created_at ? $teacher->created_at->format('F d, Y - h:i A') : 'N/A' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="fw-semibold text-muted">Last Updated</span>
                            <span class="text-dark">{{ $teacher->updated_at ? $teacher->updated_at->format('F d, Y - h:i A') : 'N/A' }}</span>
                        </li>
                    </ul>

                    <div class="d-flex justify-content-between align-items-center pt-2">
                        <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this teacher?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="bi bi-trash me-1"></i> Delete Teacher
                            </button>
                        </form>

                        <a href="{{ route('admin.teachers.index') }}" class="btn btn-secondary">
                            Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection