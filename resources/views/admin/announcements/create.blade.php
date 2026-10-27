@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold text-dark">New Announcement</h5>
                    </div>
                    <a href="{{ route('admin.announcements.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back to Announcements
                    </a>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.announcements.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                            <input id="title" type="text"
                                class="form-control @error('title') is-invalid @enderror"
                                name="title"
                                value="{{ old('title') }}"
                                placeholder="Announcement title"
                                required
                                autofocus>
                            @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label fw-semibold">Message <span class="text-danger">*</span></label>
                            <textarea id="message"
                                class="form-control @error('message') is-invalid @enderror"
                                name="message"
                                rows="5"
                                placeholder="Write the announcement message for teachers..."
                                required>{{ old('message') }}</textarea>
                            @error('message')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Target Roles <span class="text-danger">*</span></label>
                            <div class="form-check">
                                <input class="form-check-input @error('roles') is-invalid @enderror"
                                    type="checkbox"
                                    name="roles[]"
                                    value="teacher"
                                    id="role_teacher"
                                    {{ is_array(old('roles')) && !in_array('teacher', old('roles')) ? '' : 'checked' }}>
                                <label class="form-check-label" for="role_teacher">
                                    Teacher
                                </label>
                                @error('roles')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.announcements.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send me-1"></i> Post Announcement
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
