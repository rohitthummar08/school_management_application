@extends('layouts.app')

@section('content')
<div class="container py-2">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            @if (isset($announcements) && $announcements->isNotEmpty())
            <div class="mb-4">
                @foreach ($announcements as $announcement)
                <div class="alert alert-info alert-dismissible fade show shadow-sm border-0 d-flex align-items-start p-3 mb-3 announcement-alert" role="alert">
                    <i class="bi bi-megaphone-fill fs-4 me-3 text-info-emphasis flex-shrink-0"></i>
                    <div class="flex-grow-1 pe-3">
                        <div class="d-flex justify-content-between align-items-center mb-1 me-3">
                            <h5 class="alert-heading fw-bold mb-0 text-dark">{{ $announcement->title }}</h5>
                            <small class="text-muted">{{ $announcement->created_at ? $announcement->created_at->diffForHumans() : '' }}</small>
                        </div>
                        <div class="text-secondary mb-0" style="white-space: pre-line;">
                            {{ $announcement->message }}
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-announcement" data-id="{{ $announcement->id }}" aria-label="Close"></button>
                </div>
                @endforeach
            </div>
            @endif

            <div class="card shadow-sm border-0 rounded-3 mb-4 bg-white">
                <div class="card-body p-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <h4 class="fw-bold text-dark mb-0">Welcome back, {{ Auth::user()->name }}!</h4>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        @if (Auth::user()->isAdmin())
                        <a href="{{ route('admin.teachers.create') }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-person-plus-fill me-1"></i> Add Teacher
                        </a>
                        @endif
                        <a href="{{ route('students.create') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-mortarboard-fill me-1"></i> Add Student
                        </a>
                        <a href="{{ route('parents.create') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-person-plus me-1"></i> Add Parent
                        </a>
                    </div>
                </div>
            </div>

            @if (Auth::user()->isAdmin() && isset($stats['teachers']))
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 rounded-3 h-100 bg-white">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <span class="text-muted text-uppercase fw-semibold small">Teachers</span>
                                <div class="rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                    <i class="bi bi-person-video3 fs-4"></i>
                                </div>
                            </div>
                            <h2 class="display-6 fw-bold text-dark mb-3">{{ number_format($stats['teachers']) }}</h2>
                            <a href="{{ route('admin.teachers.index') }}" class="text-decoration-none small fw-semibold text-primary d-inline-flex align-items-center">
                                Manage Teachers <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm border-0 rounded-3 h-100 bg-white">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <span class="text-muted text-uppercase fw-semibold small">Students</span>
                                <div class="rounded-3 bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                    <i class="bi bi-mortarboard fs-4"></i>
                                </div>
                            </div>
                            <h2 class="display-6 fw-bold text-dark mb-3">{{ number_format($stats['students']) }}</h2>
                            <a href="{{ route('students.index') }}" class="text-decoration-none small fw-semibold text-success d-inline-flex align-items-center">
                                Manage Students <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm border-0 rounded-3 h-100 bg-white">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <span class="text-muted text-uppercase fw-semibold small">Parents</span>
                                <div class="rounded-3 bg-info-subtle text-info-emphasis d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                    <i class="bi bi-people fs-4"></i>
                                </div>
                            </div>
                            <h2 class="display-6 fw-bold text-dark mb-3">{{ number_format($stats['parents']) }}</h2>
                            <a href="{{ route('parents.index') }}" class="text-decoration-none small fw-semibold text-info-emphasis d-inline-flex align-items-center">
                                Manage Parents <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @elseif (Auth::user()->isTeacher() && isset($stats['students']))
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 rounded-3 h-100 bg-white">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <span class="text-muted text-uppercase fw-semibold small">My Students</span>
                                <div class="rounded-3 bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                    <i class="bi bi-mortarboard fs-4"></i>
                                </div>
                            </div>
                            <h2 class="display-6 fw-bold text-dark mb-3">{{ number_format($stats['students']) }}</h2>
                            <a href="{{ route('students.index') }}" class="text-decoration-none small fw-semibold text-success d-inline-flex align-items-center">
                                Manage Students <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow-sm border-0 rounded-3 h-100 bg-white">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <span class="text-muted text-uppercase fw-semibold small">My Parents</span>
                                <div class="rounded-3 bg-info-subtle text-info-emphasis d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                    <i class="bi bi-people fs-4"></i>
                                </div>
                            </div>
                            <h2 class="display-6 fw-bold text-dark mb-3">{{ number_format($stats['parents']) }}</h2>
                            <a href="{{ route('parents.index') }}" class="text-decoration-none small fw-semibold text-info-emphasis d-inline-flex align-items-center">
                                Manage Parents <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.btn-close-announcement').on('click', function(e) {
            e.preventDefault();
            let announcementId = $(this).data('id');
            let $alert = $(this).closest('.announcement-alert');

            $.ajax({
                url: '/announcements/' + announcementId + '/dismiss',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function() {
                    $alert.fadeOut(300, function() {
                        $(this).remove();
                    });
                },
                error: function() {
                    $alert.fadeOut(300, function() {
                        $(this).remove();
                    });
                }
            });
        });
    });
</script>
@endpush