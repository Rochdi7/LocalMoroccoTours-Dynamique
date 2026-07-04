@extends('layouts.main')

@section('title', 'Locations')
@section('breadcrumb-item', 'Tours')
@section('breadcrumb-item-active', 'Manage Locations')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection

@section('content')

@if(session('toast') || session('success') || session('error'))
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 99999">
        <div id="liveToast" class="toast hide animate__animated animate__fadeInDown" role="alert" aria-live="assertive" aria-atomic="true">
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
        <div class="card table-card">
            <div class="card-header">
                <div class="d-sm-flex justify-content-between align-items-center">
                    <h5 class="mb-3 mb-sm-0">Location List</h5>
                    <a href="{{ route('admin.locations.create') }}" class="btn btn-primary">Add Location</a>
                </div>
            </div>

            <div class="card-body pt-3">
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($locations as $location)
                                @php
                                    $media = $location->getFirstMedia('locations');
                                    $imageUrl = $media
                                        ? $media->getUrl('thumb')
                                        : asset('images/placeholder.png');
                                @endphp
                                <tr>
                                    <td>
                                        <img src="{{ $imageUrl }}"
                                             alt="{{ $media?->getCustomProperty('alt') ?? 'Location Image' }}"
                                             width="60"
                                             class="rounded shadow-sm">
                                    </td>
                                    <td>{{ $location->name }}</td>
                                    <td>{{ Str::limit($location->description, 60) }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.locations.edit', $location) }}"
                                           class="avtar avtar-xs btn-link-secondary me-2" title="Edit">
                                            <i class="ti ti-edit f-20"></i>
                                        </a>
                                        <form action="{{ route('admin.locations.destroy', $location) }}"
                                              method="POST" style="display:inline-block;"
                                              onsubmit="return confirm('Delete this location?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="avtar avtar-xs btn-link-secondary border-0 bg-transparent p-0"
                                                    title="Delete">
                                                <i class="ti ti-trash f-20"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No locations found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $locations->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script type="module">
        import { DataTable } from "/build/js/plugins/module.js";
        window.dt = new DataTable("#pc-dt-simple");
    </script>

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
