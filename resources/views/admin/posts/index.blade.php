@extends('layouts.main')

@section('title', 'Blog Posts')
@section('breadcrumb-item', 'Blog')
@section('breadcrumb-item-active', 'Manage Posts')

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
            <div class="card-header">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <h5 class="mb-3 mb-sm-0">Blog Posts</h5>
                    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">Add Post</a>
                </div>
            </div>

            <div class="card-body pt-3">
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Author</th>
                                <th>Status</th>
                                <th>Published</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $index => $post)
                                @php
                                    $imageUrl = $post->getFirstMediaUrl('featured_image', 'thumb') ?: asset('images/placeholder.png');
                                @endphp
                                <tr class="animate__animated animate__fadeIn" style="animation-delay: {{ $index * 0.1 }}s;">
                                    <td>
                                        <img src="{{ $imageUrl }}" alt="post image" width="60" class="rounded">
                                    </td>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->category->name ?? '-' }}</td>
                                    <td>{{ $post->author->name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $post->status === 'published' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($post->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $post->published_at ? \Carbon\Carbon::parse($post->published_at)->format('Y-m-d') : '-' }}</td>
                                    <td>
                                        <a href="{{ route('admin.posts.edit', $post) }}"
                                           class="avtar avtar-xs btn-link-secondary me-2" title="Edit">
                                            <i class="ti ti-edit f-20"></i>
                                        </a>
                                        <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" style="display:inline-block;">
                                            @csrf @method('DELETE')
                                            <button class="avtar avtar-xs btn-link-secondary border-0 bg-transparent p-0"
                                                    onclick="return confirm('Delete this post?')" title="Delete">
                                                <i class="ti ti-trash f-20"></i>
                                            </button>
                                        </form>
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
