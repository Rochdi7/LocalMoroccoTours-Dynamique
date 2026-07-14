@extends('layouts.main')

@section('title', 'Post Comments')
@section('breadcrumb-item', 'Blog')
@section('breadcrumb-item-active', 'Manage Comments')

@section('css')
    <link rel="stylesheet" href="{{ asset('build/css/plugins/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection

@section('content')

@if(session('toast') || session('success') || session('error'))
<div class="position-fixed top-0 end-0 p-3" style="z-index: 99999">
    <div id="liveToast" class="toast show animate__animated animate__fadeInDown" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <img src="{{ asset('favicon.svg') }}" class="img-fluid me-2" alt="favicon" style="width: 17px">
            <strong class="me-auto">MonAsso</strong>
            <small>Just now</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            {{ session('toast') ?? session('success') ?? session('error') }}
        </div>
    </div>
</div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card table-card animate__animated animate__fadeIn">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Post Comments</h5>
            </div>

            <div class="card-body pt-3">
                <div class="table-responsive">
                    <table class="table table-hover" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th>Post</th>
                                <th>Author</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($comments as $index => $comment)
                            <tr class="animate__animated animate__fadeIn" style="animation-delay: {{ $index * 0.1 }}s;">
                                <td>{{ $comment->post->title ?? '—' }}</td>
                                <td>
                                    @if($comment->user)
                                        {{ $comment->user->name }}
                                    @else
                                        {{ $comment->guest_name ?? 'Guest' }}
                                    @endif
                                </td>
                                <td>{{ $comment->comment_title ?? '—' }}</td>
                                <td>
                                    <span class="badge bg-{{ $comment->is_approved ? 'success' : 'secondary' }}">
                                        {{ $comment->is_approved ? 'Approved' : 'Pending' }}
                                    </span>
                                </td>
                                <td>{{ $comment->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <form action="{{ $comment->is_approved
                                        ? route('admin.post-comments.unapprove', $comment)
                                        : route('admin.post-comments.approve', $comment) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-link">
                                            <i class="ti {{ $comment->is_approved ? 'ti-eye-off' : 'ti-eye' }} f-18"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.post-comments.destroy', $comment) }}"
                                          method="POST" class="d-inline" onsubmit="return confirm('Delete this comment?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-link text-danger">
                                            <i class="ti ti-trash f-18"></i>
                                        </button>
                                    </form>

                                    <a href="{{ route('admin.post-comments.show', $comment) }}" class="btn btn-sm btn-link text-primary">
                                        <i class="ti ti-message-circle f-18"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination handled client-side by the datatable (see @section('scripts')) --}}
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toastEl = document.getElementById('liveToast');
        if (toastEl) {
            const toast = new bootstrap.Toast(toastEl);
            toast.show();
        }
    });
</script>

@include('admin.partials.datatable')

@endsection
