@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold text-dark">Edit Parent</h5>
                    </div>
                    <a href="{{ route('parents.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back to Parents
                    </a>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('parents.update', $parent) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Parent Name <span class="text-danger">*</span></label>
                            <input id="name" type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                name="name"
                                value="{{ old('name', $parent->name) }}"
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
                                value="{{ old('email', $parent->email) }}"
                                placeholder="Email address"
                                required>
                            @error('email')
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
                                <option value="{{ $teacher->id }}" {{ old('teacher_id', $parent->teacher_id) == $teacher->id ? 'selected' : '' }}>
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
                            <a href="{{ route('parents.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check2-circle me-1"></i> Update Parent
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection