@extends('layouts.main')

@section('title', 'Add Special Offer')
@section('breadcrumb-item', 'Marketing')
@section('breadcrumb-item-active', 'New Special Offer')
@section('page-animation', 'animate__fadeIn')

@section('css')
    <link rel="stylesheet" href="{{ asset('build/css/plugins/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">

        @if ($errors->any())
            <div class="alert alert-danger animate__animated animate__shakeX">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.special-offers.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf

            <div id="offer-form-card" class="card animate__animated animate__fadeIn">
                <div class="card-header">
                    <h5>Create Special Offer</h5>
                </div>

                <div class="card-body">
                    <div class="row">
                        {{-- Title --}}
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title') }}" required>
                            <div class="invalid-feedback">
                                @error('title') {{ $message }} @else Please provide a title. @enderror
                            </div>
                        </div>

                        {{-- Subtitle --}}
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Subtitle</label>
                            <input type="text" name="subtitle" class="form-control @error('subtitle') is-invalid @enderror"
                                   value="{{ old('subtitle') }}" required>
                            <div class="invalid-feedback">
                                @error('subtitle') {{ $message }} @else Provide a subtitle. @enderror
                            </div>
                        </div>

                        {{-- Text --}}
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Text (optional)</label>
                            <input type="text" name="text" class="form-control" value="{{ old('text') }}">
                        </div>

                        {{-- Link --}}
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Redirect Link (optional)</label>
                            <input type="url" name="link" class="form-control" value="{{ old('link') }}">
                        </div>

                        {{-- Image --}}
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Image</label>
                            {{-- IMPORTANT: name must match controller logic --}}
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" required>
                            <div class="invalid-feedback">
                                @error('image') {{ $message }} @else Upload an image for the offer. @enderror
                            </div>
                        </div>

                        {{-- Image SEO: Alt text --}}
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Image Alt Text <small class="text-muted">(SEO)</small></label>
                            <input type="text" name="image_alt" class="form-control" value="{{ old('image_alt') }}"
                                   placeholder="e.g. Sahara desert camel trek at sunset">
                            <small class="text-muted">Describes the image for search engines & screen readers.</small>
                        </div>

                        {{-- Image SEO: Title --}}
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Image Title <small class="text-muted">(SEO)</small></label>
                            <input type="text" name="image_title" class="form-control" value="{{ old('image_title') }}"
                                   placeholder="Shown on hover; leave blank to reuse Alt text">
                        </div>

                        {{-- Image SEO: Caption --}}
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Image Caption <small class="text-muted">(optional)</small></label>
                            <input type="text" name="image_caption" class="form-control" value="{{ old('image_caption') }}">
                        </div>

                        {{-- Order --}}
                        <div class="mb-3 col-md-3">
                            <label class="form-label">Display Order</label>
                            <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}">
                        </div>

                        {{-- Status --}}
                        <div class="mb-3 col-md-3">
                            <label class="form-label d-block">Status</label>
                            <div class="form-check form-switch mt-2">
                                <input type="checkbox" name="is_active" class="form-check-input" value="1" id="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-end">
                    <a href="{{ route('admin.special-offers.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Offer</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    (function () {
        'use strict';
        window.addEventListener('load', function () {
            const forms = document.getElementsByClassName('needs-validation');
            Array.prototype.forEach.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
@endsection
