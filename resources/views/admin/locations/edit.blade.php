@extends('layouts.main')

@section('title', 'Edit Location')
@section('breadcrumb-item', 'Locations')
@section('breadcrumb-item-active', 'Edit Location')
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

            <form action="{{ route('admin.locations.update', $location->id) }}"
                  method="POST" enctype="multipart/form-data"
                  class="needs-validation" novalidate>
                @csrf
                @method('PUT')

                <div id="location-form-card" class="card animate__animated animate__fadeInUp">
                    <div class="card-header">
                        <h5>Edit Location</h5>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            {{-- Name --}}
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label">Location Name</label>
                                <input type="text" name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $location->name) }}" required>
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
                                       value="{{ old('slug', $location->slug) }}" required>
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
                                          class="form-control @error('description') is-invalid @enderror">{{ old('description', $location->description) }}</textarea>
                                @error('description')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- ✅ Current Image --}}
                            <div class="mb-3 col-md-12">
                                <label class="form-label d-block">Current Image</label>
                                @php
                                    $media = $location->getFirstMedia('locations');
                                @endphp
                                @if ($media)
                                    <img src="{{ $media->getUrl('thumb') }}"
                                         alt="{{ $media->getCustomProperty('alt') }}"
                                         class="img-thumbnail rounded-3 mb-3"
                                         style="max-width: 300px;">
                                @else
                                    <p class="text-muted">No image uploaded yet.</p>
                                @endif
                            </div>

                            {{-- ✅ Upload New Image --}}
                            <div class="mb-3 col-md-6">
                                <label for="image" class="form-label">Upload New Image</label>
                                <input type="file" name="image"
                                       class="form-control @error('image') is-invalid @enderror">
                                <div class="invalid-feedback">
                                    @error('image')
                                        {{ $message }}
                                    @else
                                        Upload a new image to replace the current one.
                                    @enderror
                                </div>
                                <small class="text-muted">
                                    Recommended formats: JPG, PNG, WEBP. Max size: 2MB.
                                </small>
                            </div>

                            {{-- ✅ Image Metadata --}}
                            <div class="mb-3 col-md-12">
                                <h6 class="fw-bold mt-3">Image Metadata (optional)</h6>

                                <div class="mb-2">
                                    <label class="form-label">Alt Text</label>
                                    <input type="text" name="seo_alt"
                                           class="form-control @error('seo_alt') is-invalid @enderror"
                                           placeholder="E.g. View of Marrakech city walls"
                                           value="{{ old('seo_alt', $media?->getCustomProperty('alt') ?? '') }}">
                                    @error('seo_alt')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-2">
                                    <label class="form-label">Caption (optional)</label>
                                    <input type="text" name="seo_caption"
                                           class="form-control @error('seo_caption') is-invalid @enderror"
                                           placeholder="E.g. Historic ramparts around the medina."
                                           value="{{ old('seo_caption', $media?->getCustomProperty('caption') ?? '') }}">
                                    @error('seo_caption')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-2">
                                    <label class="form-label">Description (optional)</label>
                                    <textarea name="seo_description" rows="3"
                                              class="form-control @error('seo_description') is-invalid @enderror"
                                              placeholder="Detailed SEO description about the location...">{{ old('seo_description', $media?->getCustomProperty('description') ?? '') }}</textarea>
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
                        <button type="submit" class="btn btn-primary">Update Location</button>
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
