@extends('layouts.main')

@section('title', 'Special Offers')
@section('breadcrumb-item', 'Marketing')
@section('breadcrumb-item-active', 'Special Offers')

@section('css')
    <link rel="stylesheet" href="{{ asset('build/css/plugins/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection

@section('content')

    @if (session('success'))
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 99999">
            <div id="liveToast" class="toast show animate__animated animate__fadeInDown" role="alert" aria-live="assertive"
                aria-atomic="true">
                <div class="toast-header">
                    <img src="{{ asset('favicon.svg') }}" class="img-fluid me-2" alt="favicon" style="width: 17px">
                    <strong class="me-auto">MonAsso</strong>
                    <small>Just now</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {{ session('success') }}
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card table-card animate__animated animate__fadeIn">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Special Offers</h5>
                    <a href="{{ route('admin.special-offers.create') }}" class="btn btn-primary">Add Offer</a>
                </div>

                <div class="card-body pt-3">
                    <div class="table-responsive">
                        <table class="table table-hover" id="pc-dt-simple">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Subtitle</th>
                                    <th>Link</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($offers as $index => $offer)
                                    <tr class="animate__animated animate__fadeIn"
                                        style="animation-delay: {{ $index * 0.1 }}s;">
                                        <td>
                                            @php
                                                $imageUrl =
                                                    $offer->getFirstMediaUrl('special_offers') ?:
                                                    asset('images/placeholder.png');
                                            @endphp
                                            <img src="{{ $imageUrl }}" alt="offer image" width="60" class="rounded">
                                        </td>
                                        <td>{{ $offer->title }}</td>
                                        <td>{{ $offer->subtitle }}</td>
                                        <td>
                                            @if ($offer->link)
                                                <a href="{{ $offer->link }}" target="_blank"
                                                    class="text-primary text-decoration-underline">Link</a>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td>{{ $offer->order }}</td>
                                        <td>
                                            @if ($offer->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.special-offers.edit', $offer) }}"
                                                class="avtar avtar-xs btn-link-secondary me-2" title="Edit">
                                                <i class="ti ti-edit f-20"></i>
                                            </a>
                                            <form action="{{ route('admin.special-offers.destroy', $offer) }}"
                                                method="POST" style="display:inline-block;">
                                                @csrf @method('DELETE')
                                                <button
                                                    class="avtar avtar-xs btn-link-secondary border-0 bg-transparent p-0"
                                                    onclick="return confirm('Delete this offer?')" title="Delete">
                                                    <i class="ti ti-trash f-20"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    {{-- Optional pagination --}}
                    {{-- <div class="mt-3">{{ $offers->links() }}</div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const toastEl = document.getElementById('liveToast');
            if (toastEl) {
                const toast = new bootstrap.Toast(toastEl);
                toast.show();
            }
        });
    </script>
@endsection
