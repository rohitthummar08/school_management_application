@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0 fw-bold text-dark">Teachers</h4>
                    </div>
                    <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary">
                        <i class="bi bi-person-plus-fill me-1"></i> Add Teacher
                    </a>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" style="width: 70px;" class="ps-4">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Joined Date</th>
                                    <th scope="col" class="text-end pe-4" style="width: 220px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($teachers as $index => $teacher)
                                <tr>
                                    <td class="ps-4 fw-medium text-muted">
                                        {{ $teacher->id }}
                                    </td>
                                    <td>
                                        <span class="fw-semibold text-dark">{{ $teacher->name }}</span>
                                    </td>
                                    <td>
                                        <a href="mailto:{{ $teacher->email }}" class="text-decoration-none text-secondary">
                                            {{ $teacher->email }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle px-2 py-1">
                                            {{ $teacher->role->label() }}
                                        </span>
                                    </td>
                                    <td class="text-muted">
                                        {{ $teacher->created_at ? $teacher->created_at->format('M d, Y') : 'N/A' }}
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-inline-flex align-items-center gap-2">
                                            <a href="{{ route('admin.teachers.show', $teacher) }}" class="text-secondary text-decoration-none p-1" title="View details">
                                                <i class="bi bi-eye fs-5"></i>
                                            </a>
                                            <a href="{{ route('admin.teachers.edit', $teacher) }}" class="text-primary text-decoration-none p-1" title="Edit teacher">
                                                <i class="bi bi-pencil fs-5"></i>
                                            </a>
                                            <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete {{ addslashes($teacher->name) }}?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger p-1 border-0 shadow-none lh-1 align-baseline" title="Delete teacher">
                                                    <i class="bi bi-trash fs-5"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="bi bi-people display-6 d-block mb-2 text-secondary"></i>
                                            <p class="mb-2">No teachers found.</p>
                                            <a href="{{ route('admin.teachers.create') }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-person-plus-fill me-1"></i> Add the First Teacher
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($teachers->hasPages())
                <div class="card-footer bg-white py-3 d-flex justify-content-end align-items-center">
                    {{ $teachers->links() }}
                </div>
                @elseif ($teachers->count() > 0)
                <div class="card-footer bg-white py-3 text-muted small">
                    Showing {{ $teachers->count() }} of {{ $teachers->total() }} {{ \Illuminate\Support\Str::plural('teacher', $teachers->total()) }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection