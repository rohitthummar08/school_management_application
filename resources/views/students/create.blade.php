@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold text-dark">Add New Student</h5>
                    </div>
                    <a href="{{ route('students.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back to Students
                    </a>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('students.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Student Name <span class="text-danger">*</span></label>
                            <input id="name" type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Full name"
                                required
                                autofocus>
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                            <input id="email" type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="Email address"
                                required>
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="parent_id" class="form-label fw-semibold">Select Parent</label>
                            <select id="parent_id" name="parent_id" class="form-select @error('parent_id') is-invalid @enderror">
                                <option value="">-- Select Parent (Optional) --</option>
                                @foreach ($parents as $parent)
                                <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->name }} ({{ $parent->email }})
                                </option>
                                @endforeach
                            </select>
                            @error('parent_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        @if (Auth::user()->isAdmin())
                        <div class="mb-3">
                            <label for="teacher_id" class="form-label fw-semibold">Assign Teacher</label>
                            <select id="teacher_id" name="teacher_id" class="form-select @error('teacher_id') is-invalid @enderror">
                                <option value="">-- Select Teacher (Optional) --</option>
                                @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->name }} ({{ $teacher->email }})
                                </option>
                                @endforeach
                            </select>
                            @error('teacher_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        @endif

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check2-circle me-1"></i> Save Student
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection