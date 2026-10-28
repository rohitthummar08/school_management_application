@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0 fw-bold text-dark">Post New Announcement</h4>
                    </div>
                    <a href="{{ route('teacher.announcements.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i> Back to Announcements
                    </a>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('teacher.announcements.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label fw-semibold">Title</label>
                            <input
                                type="text"
                                class="form-control @error('title') is-invalid @enderror"
                                id="title"
                                name="title"
                                value="{{ old('title') }}"
                                placeholder="Announcement Title"
                                required>
                            @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label fw-semibold">Message</label>
                            <textarea
                                class="form-control @error('message') is-invalid @enderror"
                                id="message"
                                name="message"
                                rows="5"
                                placeholder="Announcement Message"
                                required>{{ old('message') }}</textarea>
                            @error('message')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold d-block">Target Audience</label>
                            <div class="d-flex flex-wrap gap-4 pt-1">
                                <div class="form-check">
                                    <input
                                        class="form-check-input @error('roles') is-invalid @enderror"
                                        type="checkbox"
                                        name="roles[]"
                                        value="student"
                                        id="role_student"
                                        {{ is_array(old('roles')) && in_array('student', old('roles')) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="role_student">
                                        <i class="bi bi-mortarboard me-1 text-success"></i> Students
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        class="form-check-input @error('roles') is-invalid @enderror"
                                        type="checkbox"
                                        name="roles[]"
                                        value="parent"
                                        id="role_parent"
                                        {{ is_array(old('roles')) && in_array('parent', old('roles')) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="role_parent">
                                        <i class="bi bi-people me-1 text-info-emphasis"></i> Parents
                                    </label>
                                </div>
                            </div>
                            @error('roles')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                            @enderror
                            <div class="form-text mt-2 text-muted">
                                Select at least one audience. Email notifications will be sent.
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                            <a href="{{ route('teacher.announcements.index') }}" class="btn btn-light border px-4">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-send-fill me-1"></i> Post & Send Emails
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection