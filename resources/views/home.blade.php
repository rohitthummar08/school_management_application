@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
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

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 fw-bold text-dark">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
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