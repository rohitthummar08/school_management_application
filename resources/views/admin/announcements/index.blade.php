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
                        <h4 class="mb-0 fw-bold text-dark">Announcements</h4>
                    </div>
                    <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> Add Announcement
                    </a>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" style="width: 70px;" class="ps-4">ID</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Message</th>
                                    <th scope="col">Target Roles</th>
                                    <th scope="col">Created By</th>
                                    <th scope="col">Dismissals</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col" class="text-end pe-4" style="width: 90px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($announcements as $announcement)
                                <tr>
                                    <td class="ps-4 fw-medium text-muted">
                                        {{ $announcement->id }}
                                    </td>
                                    <td>
                                        <span class="fw-semibold text-dark">{{ $announcement->title }}</span>
                                    </td>
                                    <td class="text-muted">
                                        {{ \Illuminate\Support\Str::limit($announcement->message, 60) }}
                                    </td>
                                    <td>
                                        @foreach ($announcement->roles_list as $role)
                                        <span class="badge bg-secondary-subtle text-secondary-emphasis border px-2 py-1 me-1">
                                            {{ ucfirst($role) }}
                                        </span>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if ($announcement->user)
                                        <span class="fw-semibold text-dark">{{ $announcement->user->name }}</span>
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle px-2 py-1">
                                            {{ $announcement->dismissals_count }} closed
                                        </span>
                                    </td>
                                    <td class="text-muted">
                                        {{ $announcement->created_at ? $announcement->created_at->format('M d, Y') : 'N/A' }}
                                    </td>
                                    <td class="text-end pe-4">
                                        <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this announcement?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link text-danger p-1 border-0 shadow-none lh-1 align-baseline" title="Delete announcement">
                                                <i class="bi bi-trash fs-5"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="bi bi-megaphone display-6 d-block mb-2 text-secondary"></i>
                                            <p class="mb-2">No announcements posted yet.</p>
                                            <a href="{{ route('admin.announcements.create') }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-plus-circle me-1"></i> Post the First Announcement
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($announcements->hasPages())
                <div class="card-footer bg-white py-3 d-flex justify-content-end align-items-center">
                    {{ $announcements->links() }}
                </div>
                @elseif ($announcements->count() > 0)
                <div class="card-footer bg-white py-3 text-muted small">
                    Showing {{ $announcements->count() }} of {{ $announcements->total() }} {{ \Illuminate\Support\Str::plural('announcement', $announcements->total()) }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection