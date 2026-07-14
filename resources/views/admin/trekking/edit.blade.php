@extends('layouts.main')

@section('title', 'Edit Trekking')
@section('breadcrumb-item', 'Trekking')
@section('breadcrumb-item-active', 'Edit Trekking')

@section('page-animation', 'animate__rollIn')

@section('css')
    <link rel="stylesheet" href="{{ asset('build/css/plugins/style.css') }}">
    <link rel="stylesheet" href="{{ asset('build/css/plugins/animate.min.css') }}">
@endsection

@section('content')
    @php
        // Helper function to convert JSON/array/string to comma-separated string
        if (!function_exists('toCommaSeparated')) {
            function toCommaSeparated($value)
            {
                if (is_array($value)) {
                    return implode(', ', $value);
                }
                if (is_string($value)) {
                    $decoded = json_decode($value, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        return implode(', ', $decoded);
                    }
                    return $value;
                }
                return '';
            }
        }

        // Helper function to convert JSON/array/string to newline-separated string
        if (!function_exists('toNewlineSeparated')) {
            function toNewlineSeparated($value)
            {
                if (is_array($value)) {
                    return implode("\n", $value);
                }
                if (is_string($value)) {
                    $decoded = json_decode($value, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        return implode("\n", $decoded);
                    }
                    return $value;
                }
                return '';
            }
        }

        $highlights = old('highlights', toCommaSeparated($trekking->highlights));
        $languages = old('languages', toCommaSeparated($trekking->languages));
        $included = old('included', toCommaSeparated($trekking->included));
        $excluded = old('excluded', toCommaSeparated($trekking->excluded));
        $itinerary = old('itinerary', toNewlineSeparated($trekking->itinerary));
    @endphp

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

            <form action="{{ route('admin.trekking.update', $trekking->id) }}" method="POST" enctype="multipart/form-data"
                class="needs-validation" novalidate>
                @csrf
                @method('PUT')

                <div id="trekking-form-card" class="card animate__animated animate__rollIn">
                    <div class="card-header">
                        <h5>Edit Trekking</h5>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            {{-- ✅ Cover Image Upload --}}
                            <div class="mb-3 col-md-12">
                                <label for="image" class="form-label">Trekking Cover Image</label>

                                @php
                                    $coverImage = $trekking->getFirstMedia('cover');
                                @endphp

                                @if ($coverImage)
                                    <div class="mb-3">
                                        <img src="{{ $coverImage->getUrl() }}" alt="Cover Image" class="img-thumbnail"
                                            style="max-width: 250px;">
                                    </div>
                                @endif

                                <input type="file" name="image" id="image"
                                    class="form-control @error('image') is-invalid @enderror">
                                @error('image')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Upload a new cover image to replace the existing one.</small>
                            </div>

                            {{-- ✅ Cover Image Metadata --}}
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Cover Image Metadata</label>

                                <div class="mb-2">
                                    <label class="form-label">Alt Text</label>
                                    <input type="text" name="cover_alt"
                                        class="form-control @error('cover_alt') is-invalid @enderror"
                                        value="{{ old('cover_alt', $coverImage?->getCustomProperty('alt')) }}"
                                        placeholder="E.g. Mountain sunrise trek">
                                    @error('cover_alt')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-2">
                                    <label class="form-label">Title (optional)</label>
                                    <input type="text" name="cover_title"
                                        class="form-control @error('cover_title') is-invalid @enderror"
                                        value="{{ old('cover_title', $coverImage?->getCustomProperty('title')) }}"
                                        placeholder="E.g. Sunrise Trek">
                                    @error('cover_title')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-2">
                                    <label class="form-label">Caption (optional)</label>
                                    <input type="text" name="cover_caption"
                                        class="form-control @error('cover_caption') is-invalid @enderror"
                                        value="{{ old('cover_caption', $coverImage?->getCustomProperty('caption')) }}"
                                        placeholder="E.g. Peak view at sunrise.">
                                    @error('cover_caption')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-2">
                                    <label class="form-label">Description (optional)</label>
                                    <textarea name="cover_description" rows="2" class="form-control @error('cover_description') is-invalid @enderror"
                                        placeholder="Detailed description of the cover image...">{{ old('cover_description', $coverImage?->getCustomProperty('description')) }}</textarea>
                                    @error('cover_description')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            {{-- Gallery Preview + Upload --}}
                            <div class="mb-3 col-md-12">
                                <label class="form-label d-block">Current Gallery</label>

                                @php
                                    $galleryImages = $trekking->getMedia('gallery');
                                @endphp

                                @if ($galleryImages->count())
                                    <div class="row g-2 mb-3">
                                        @foreach ($galleryImages as $image)
                                            @php
                                                $url = $image->hasGeneratedConversion('slider')
                                                    ? $image->getUrl('slider')
                                                    : $image->getUrl();
                                            @endphp

                                            <div class="col-12 col-md-6 col-lg-4 mb-4">
                                                <div class="card h-100">
                                                    <img src="{{ $url }}" class="card-img-top"
                                                        alt="Gallery Image">

                                                    <div class="card-body">
                                                        <h6 class="card-title mb-3">Edit Image Metadata</h6>

                                                        <input type="hidden" name="existing_gallery_ids[]"
                                                            value="{{ $image->id }}">

                                                        <div class="mb-2">
                                                            <label class="form-label">Alt Text</label>
                                                            <input type="text"
                                                                name="existing_gallery_alt[{{ $image->id }}]"
                                                                class="form-control"
                                                                value="{{ old('existing_gallery_alt.' . $image->id, $image->getCustomProperty('alt')) }}">
                                                        </div>

                                                        <div class="mb-2">
                                                            <label class="form-label">Title (optional)</label>
                                                            <input type="text"
                                                                name="existing_gallery_title[{{ $image->id }}]"
                                                                class="form-control"
                                                                value="{{ old('existing_gallery_title.' . $image->id, $image->getCustomProperty('title')) }}">
                                                        </div>

                                                        <div class="mb-2">
                                                            <label class="form-label">Caption (optional)</label>
                                                            <input type="text"
                                                                name="existing_gallery_caption[{{ $image->id }}]"
                                                                class="form-control"
                                                                value="{{ old('existing_gallery_caption.' . $image->id, $image->getCustomProperty('caption')) }}">
                                                        </div>

                                                        <div class="mb-2">
                                                            <label class="form-label">Description (optional)</label>
                                                            <textarea name="existing_gallery_description[{{ $image->id }}]" rows="2" class="form-control">{{ old('existing_gallery_description.' . $image->id, $image->getCustomProperty('description')) }}</textarea>
                                                        </div>

                                                        <div class="form-check mt-2">
                                                            <input type="checkbox" name="delete_gallery[]"
                                                                value="{{ $image->id }}" class="form-check-input"
                                                                id="delete_image_{{ $image->id }}">
                                                            <label class="form-check-label small text-danger"
                                                                for="delete_image_{{ $image->id }}">
                                                                Delete
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted">No gallery images uploaded yet.</p>
                                @endif

                                {{-- Upload new gallery images --}}
                                <label for="gallery" class="form-label mt-3">Upload New Gallery Images</label>
                                <input type="file" name="gallery[]" id="gallery" multiple
                                    class="form-control @error('gallery.*') is-invalid @enderror">
                                @error('gallery.*')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                                <small class="text-muted d-block mt-1">
                                    You may upload new images to add to the gallery. Recommended formats: JPG, PNG, WEBP.
                                </small>
                            </div>




                            {{-- Title --}}
                            <div class="mb-3 col-md-6">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" name="title" value="{{ old('title', $trekking->title) }}"
                                    class="form-control @error('title') is-invalid @enderror" required>
                                <div class="invalid-feedback">
                                    @error('title')
                                        {{ $message }}
                                    @else
                                        Please enter the trekking title.
                                    @enderror
                                </div>
                            </div>

                            {{-- Duration --}}
                            <div class="mb-3 col-md-6">
                                <label for="duration" class="form-label">Duration</label>
                                <input type="text" name="duration" value="{{ old('duration', $trekking->duration) }}"
                                    class="form-control @error('duration') is-invalid @enderror" required>
                                <div class="invalid-feedback">
                                    @error('duration')
                                        {{ $message }}
                                    @else
                                        Please specify duration.
                                    @enderror
                                </div>
                            </div>

                            {{-- Group Size --}}
                            <div class="mb-3 col-md-6">
                                <label for="group_size" class="form-label">Group Size</label>
                                <input type="number" name="group_size"
                                    value="{{ old('group_size', $trekking->group_size) }}"
                                    class="form-control @error('group_size') is-invalid @enderror" required>
                                <div class="invalid-feedback">
                                    @error('group_size')
                                        {{ $message }}
                                    @else
                                        Enter maximum group size.
                                    @enderror
                                </div>
                            </div>

                            {{-- Age Range --}}
                            <div class="mb-3 col-md-6">
                                <label for="age_range" class="form-label">Age Range</label>
                                <input type="text" name="age_range"
                                    value="{{ old('age_range', $trekking->age_range) }}"
                                    class="form-control @error('age_range') is-invalid @enderror" required>
                                <div class="invalid-feedback">
                                    @error('age_range')
                                        {{ $message }}
                                    @else
                                        Example: 10–65 yrs
                                    @enderror
                                </div>
                            </div>

                            {{-- Base Price --}}
                            <div class="mb-3 col-md-6">
                                <label for="base_price" class="form-label">Base Price</label>
                                <input type="number" step="0.01" name="base_price"
                                    value="{{ old('base_price', $trekking->base_price) }}"
                                    class="form-control @error('base_price') is-invalid @enderror" required>
                                <div class="invalid-feedback">
                                    @error('base_price')
                                        {{ $message }}
                                    @else
                                        Enter the base price.
                                    @enderror
                                </div>
                            </div>

                            {{-- Difficulty Level --}}
                            <div class="mb-3 col-md-6">
                                <label for="difficulty_level" class="form-label">Difficulty Level</label>
                                <select name="difficulty_level"
                                    class="form-select @error('difficulty_level') is-invalid @enderror" required>
                                    <option value="">Select difficulty...</option>
                                    @foreach (['Easy', 'Moderate', 'Hard', 'Expert'] as $level)
                                        <option value="{{ $level }}" @selected(old('difficulty_level', $trekking->difficulty_level) == $level)>
                                            {{ $level }}</option>
                                    @endforeach
                                </select>
                                @error('difficulty_level')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Max Altitude --}}
                            <div class="mb-3 col-md-6">
                                <label for="max_altitude" class="form-label">Max Altitude (m)</label>
                                <input type="number" name="max_altitude"
                                    value="{{ old('max_altitude', $trekking->max_altitude) }}"
                                    class="form-control @error('max_altitude') is-invalid @enderror">
                                @error('max_altitude')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Map Frame --}}
                            <div class="mb-3 col-md-12">
                                <label for="map_frame" class="form-label">Map Frame Embed Code (optional)</label>
                                <textarea name="map_frame" rows="5" class="form-control @error('map_frame') is-invalid @enderror">{{ old('map_frame', $trekking->map_frame) }}</textarea>
                                <small class="text-muted">
                                    Paste an embed iframe code, e.g.
                                    <code>&lt;iframe src="..." width="600" height="450" style="border:0;"
                                        allowfullscreen="" loading="lazy"&gt;&lt;/iframe&gt;</code>.
                                </small>
                                @error('map_frame')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Category --}}
                            <div class="mb-3 col-md-6">
                                <label for="category_id" class="form-label">Category</label>
                                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror"
                                    required>
                                    <option value="">Select category...</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @selected(old('category_id', $trekking->category_id) == $category->id)>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Location --}}
                            <div class="mb-3 col-md-6">
                                <label for="location_id" class="form-label">Location</label>
                                <select name="location_id" class="form-select @error('location_id') is-invalid @enderror"
                                    required>
                                    <option value="">Select location...</option>
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->id }}" @selected(old('location_id', $trekking->location_id) == $location->id)>
                                            {{ $location->name }}</option>
                                    @endforeach
                                </select>
                                @error('location_id')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Flags --}}
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Flags</label>
                                <div class="form-check form-switch">
                                    <input type="checkbox" name="bestseller_flag" value="1"
                                        class="form-check-input" @checked(old('bestseller_flag', $trekking->bestseller_flag))>
                                    <label class="form-check-label">Bestseller</label>
                                </div>
                                <div class="form-check form-switch mt-2">
                                    <input type="checkbox" name="free_cancellation_flag" value="1"
                                        class="form-check-input" @checked(old('free_cancellation_flag', $trekking->free_cancellation_flag))>
                                    <label class="form-check-label">Free Cancellation</label>
                                </div>
                            </div>

                            {{-- Overview --}}
                            <div class="mb-3 col-md-12">
                                <label for="overview" class="form-label">Overview</label>
                                <textarea name="overview" rows="4" class="form-control @error('overview') is-invalid @enderror" required>{{ old('overview', $trekking->overview) }}</textarea>
                                @error('overview')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Highlights --}}
                            <div class="mb-3 col-md-12">
                                <label for="highlights" class="form-label">Highlights (optional)</label>
                                <textarea name="highlights" rows="4" class="form-control @error('highlights') is-invalid @enderror">{{ $highlights }}</textarea>
                                @error('highlights')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Languages --}}
                            <div class="mb-3 col-md-12">
                                <label for="languages" class="form-label">Languages Spoken (optional)</label>
                                <textarea name="languages" rows="3" class="form-control @error('languages') is-invalid @enderror">{{ $languages }}</textarea>
                                <small class="text-muted">Separate languages with commas, e.g. English, French,
                                    Spanish.</small>
                                @error('languages')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Included --}}
                            <div class="mb-3 col-md-12">
                                <label for="included" class="form-label">Included Items</label>
                                <textarea name="included" rows="3" class="form-control @error('included') is-invalid @enderror">{{ $included }}</textarea>
                                <small class="text-muted">Separate items by comma, e.g. Transport, Guide, Meals.</small>
                                @error('included')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Excluded --}}
                            <div class="mb-3 col-md-12">
                                <label for="excluded" class="form-label">Excluded Items</label>
                                <textarea name="excluded" rows="3" class="form-control @error('excluded') is-invalid @enderror">{{ $excluded }}</textarea>
                                <small class="text-muted">Separate items by comma, e.g. Flights, Personal expenses.</small>
                                @error('excluded')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Itinerary --}}
                            <div class="mb-3 col-md-12">
                                <label for="itinerary" class="form-label">Itinerary</label>
                                <textarea name="itinerary" rows="5" class="form-control @error('itinerary') is-invalid @enderror">{{ $itinerary }}</textarea>
                                <small class="text-muted">Separate days by new lines, e.g. Day 1: Arrival\nDay 2:
                                    Sightseeing.</small>
                                @error('itinerary')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div class="card-footer text-end">
                        <a href="{{ route('admin.trekking.index') }}" class="btn btn-secondary"
                            onclick="rollOutCard(event, this, 'trekking-form-card')">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Trekking</button>
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

        function rollOutCard(event, link, cardId = 'trekking-form-card') {
            event.preventDefault();
            const card = document.getElementById(cardId);
            if (!card) return;
            card.classList.remove('animate__rollIn');
            card.classList.add('animate__animated', 'animate__rollOut');
            setTimeout(() => {
                window.location.href = link.href;
            }, 1000);
        }
    </script>
@section('scripts')
    @parent
    <script>
        document.getElementById('gallery')?.addEventListener('change', function(e) {
            const container = document.getElementById('gallery-meta-container');
            container.innerHTML = '';
            const files = e.target.files;

            Array.from(files).forEach((file, index) => {
                const div = document.createElement('div');
                div.classList.add('gallery-meta-item', 'mb-4', 'p-3', 'border', 'rounded', 'bg-light');

                div.innerHTML = `
                    <p class="fw-bold mb-2">Image: ${file.name}</p>

                    <div class="mb-2">
                        <label class="form-label">Alt Text</label>
                        <input type="text" name="gallery_alt[]" class="form-control" placeholder="E.g. Trekking trail view">
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Title (optional)</label>
                        <input type="text" name="gallery_title[]" class="form-control" placeholder="E.g. High Atlas Trek">
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Caption (optional)</label>
                        <input type="text" name="gallery_caption[]" class="form-control" placeholder="E.g. Stunning valley below.">
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Description (optional)</label>
                        <textarea name="gallery_description[]" class="form-control" rows="2" placeholder="Detailed description of the image..."></textarea>
                    </div>
                `;
                container.appendChild(div);
            });
        });
    </script>

@endsection
