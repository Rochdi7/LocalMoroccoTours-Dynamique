@extends('layouts.main')

@section('title', 'Tours')
@section('breadcrumb-item', 'Tours')
@section('breadcrumb-item-active', 'Manage Tours')

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
                    <h5 class="mb-3 mb-sm-0">Tours List</h5>
                    <div>
                        <a href="{{ route('admin.tours.create') }}" class="btn btn-primary">Add Tour</a>
                    </div>
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
                                <th>Location</th>
                                <th>Price</th>
                                <th>Duration</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tours as $index => $tour)
                                @php
                                    $imageUrl = $tour->getFirstMediaUrl('cover', 'thumb') ?: asset('images/placeholder.png');
                                @endphp
                                <tr class="animate__animated animate__fadeIn" style="animation-delay: {{ $index * 0.1 }}s; animation-duration: 0.6s; animation-fill-mode: both;">
                                    <td>
                                        <img src="{{ $imageUrl }}" alt="Tour Image" width="60" class="rounded">
                                    </td>
                                    <td>{{ $tour->title }}</td>
                                    <td>{{ $tour->category->name ?? '-' }}</td>
                                    <td>{{ $tour->location->name ?? '-' }}</td>
                                    <td>{{ number_format($tour->base_price, 2) }} MAD</td>
                                    <td>{{ $tour->duration }}</td>
                                    <td>
                                        <a href="{{ route('admin.tours.edit', $tour) }}"
                                           class="avtar avtar-xs btn-link-secondary me-2" title="Edit">
                                            <i class="ti ti-edit f-20"></i>
                                        </a>
                                        <form action="{{ route('admin.tours.destroy', $tour) }}" method="POST" style="display:inline-block;">
                                            @csrf @method('DELETE')
                                            <button class="avtar avtar-xs btn-link-secondary border-0 bg-transparent p-0"
                                                    onclick="return confirm('Delete this tour?')" title="Delete">
                                                <i class="ti ti-trash f-20"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $tours->links() }}
                </div>
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
@endsection
