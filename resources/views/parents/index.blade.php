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
                        <h4 class="mb-0 fw-bold text-dark">Parents</h4>
                    </div>
                    <a href="{{ route('parents.create') }}" class="btn btn-primary">
                        <i class="bi bi-person-plus-fill me-1"></i> Add Parent
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
                                    <th scope="col">Students</th>
                                    @if (Auth::user()->isAdmin())
                                    <th scope="col">Teacher</th>
                                    @endif
                                    <th scope="col">Joined Date</th>
                                    <th scope="col" class="text-end pe-4" style="width: 110px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($parents as $parent)
                                <tr>
                                    <td class="ps-4 fw-medium text-muted">
                                        {{ $parent->id }}
                                    </td>
                                    <td>
                                        <span class="fw-semibold text-dark">{{ $parent->name }}</span>
                                    </td>
                                    <td>
                                        <a href="mailto:{{ $parent->email }}" class="text-decoration-none text-secondary">
                                            {{ $parent->email }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">
                                            {{ $parent->students_count }} {{ \Illuminate\Support\Str::plural('student', $parent->students_count) }}
                                        </span>
                                    </td>
                                    @if (Auth::user()->isAdmin())
                                    <td>
                                        @if ($parent->teacherUser)
                                        <span class="badge bg-secondary-subtle text-secondary-emphasis border px-2 py-1">
                                            {{ $parent->teacherUser->name }}
                                        </span>
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    @endif
                                    <td class="text-muted">
                                        {{ $parent->created_at ? $parent->created_at->format('M d, Y') : 'N/A' }}
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-inline-flex align-items-center gap-2">
                                            <a href="{{ route('parents.edit', $parent) }}" class="text-primary text-decoration-none p-1" title="Edit parent">
                                                <i class="bi bi-pencil fs-5"></i>
                                            </a>
                                            <form action="{{ route('parents.destroy', $parent) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this parent?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger p-1 border-0 shadow-none lh-1 align-baseline" title="Delete parent">
                                                    <i class="bi bi-trash fs-5"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="{{ Auth::user()->isAdmin() ? 7 : 6 }}" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="bi bi-people display-6 d-block mb-2 text-secondary"></i>
                                            <p class="mb-2">No parents found.</p>
                                            <a href="{{ route('parents.create') }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-person-plus-fill me-1"></i> Add the First Parent
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($parents->hasPages())
                <div class="card-footer bg-white py-3 d-flex justify-content-end align-items-center">
                    {{ $parents->links() }}
                </div>
                @elseif ($parents->count() > 0)
                <div class="card-footer bg-white py-3 text-muted small">
                    Showing {{ $parents->count() }} of {{ $parents->total() }} {{ \Illuminate\Support\Str::plural('parent', $parents->total()) }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
