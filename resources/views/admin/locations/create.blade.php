@extends('layouts.main')

@section('title', 'Create Location')
@section('breadcrumb-item', 'Locations')
@section('breadcrumb-item-active', 'New Location')
@section('page-animation', 'animate__fadeInUp')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/style.css') }}">
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

            <form action="{{ route('admin.locations.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf

                <div id="location-form-card" class="card animate__animated animate__fadeInUp">
                    <div class="card-header">
                        <h5>New Location Form</h5>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            {{-- Name --}}
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label">Location Name</label>
                                <input type="text" name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}" required>
                                <div class="invalid-feedback">
                                    @error('name')
                                        {{ $message }}
                                    @else
                                        Please enter a location name.
                                    @enderror
                                </div>
                            </div>

                            {{-- Slug --}}
                            <div class="mb-3 col-md-6">
                                <label for="slug" class="form-label">Slug</label>
                                <input type="text" name="slug"
                                       class="form-control @error('slug') is-invalid @enderror"
                                       value="{{ old('slug') }}" required>
                                <div class="invalid-feedback">
                                    @error('slug')
                                        {{ $message }}
                                    @else
                                        Please enter a unique slug (e.g. marrakech).
                                    @enderror
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="mb-3 col-md-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" rows="4"
                                          class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Image Upload --}}
                            <div class="mb-3 col-md-6">
                                <label for="image" class="form-label">Location Image</label>
                                <input type="file" name="image"
                                       class="form-control @error('image') is-invalid @enderror">
                                <div class="invalid-feedback">
                                    @error('image')
                                        {{ $message }}
                                    @else
                                        Please upload a valid image.
                                    @enderror
                                </div>
                                <small class="text-muted">
                                    Upload an image representing this location. Recommended formats: JPG, PNG, WEBP.
                                </small>
                            </div>

                            {{-- ✅ SEO Fields --}}
                            <div class="mb-3 col-md-12">
                                <h6 class="fw-bold mt-3">SEO Metadata (optional)</h6>

                                <div class="mb-2">
                                    <label class="form-label">Alt Text</label>
                                    <input type="text" name="seo_alt"
                                           class="form-control @error('seo_alt') is-invalid @enderror"
                                           placeholder="E.g. View of Marrakech city walls"
                                           value="{{ old('seo_alt') }}">
                                    @error('seo_alt')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-2">
                                    <label class="form-label">Caption (optional)</label>
                                    <input type="text" name="seo_caption"
                                           class="form-control @error('seo_caption') is-invalid @enderror"
                                           placeholder="E.g. Historic ramparts around the medina."
                                           value="{{ old('seo_caption') }}">
                                    @error('seo_caption')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-2">
                                    <label class="form-label">Description (optional)</label>
                                    <textarea name="seo_description" rows="3"
                                              class="form-control @error('seo_description') is-invalid @enderror"
                                              placeholder="Detailed SEO description about the location...">{{ old('seo_description') }}</textarea>
                                    @error('seo_description')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="card-footer text-end">
                        <a href="{{ route('admin.locations.index') }}" class="btn btn-secondary"
                           onclick="fadeOutCard(event, this, 'location-form-card')">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Location</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                const forms = document.getElementsByClassName('needs-validation');
                Array.prototype.forEach.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        function fadeOutCard(event, link, cardId = 'location-form-card') {
            event.preventDefault();
            const card = document.getElementById(cardId);
            if (!card) return;

            card.classList.remove('animate__fadeInUp');
            card.classList.add('animate__animated', 'animate__fadeOutDown');

            setTimeout(() => {
                window.location.href = link.href;
            }, 800);
        }
    </script>
@endsection
