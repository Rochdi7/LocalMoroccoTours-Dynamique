@extends('layouts.main')

@section('title', 'Create Blog Post')
@section('breadcrumb-item', 'Blog')
@section('breadcrumb-item-active', 'New Post')
@section('page-animation', 'animate__rollIn')

@section('css')
    <link rel="stylesheet" href="{{ asset('build/css/plugins/style.css') }}">
    <link rel="stylesheet" href="{{ asset('build/css/plugins/animate.min.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/monokai-sublime.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('build/css/plugins/quill.core.css') }}">
    <link rel="stylesheet" href="{{ asset('build/css/plugins/quill.snow.css') }}">
    <link rel="stylesheet" href="{{ asset('build/css/plugins/quill.bubble.css') }}">
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

            <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data"
                class="needs-validation" novalidate>
                @csrf

                <div id="post-form-card" class="card animate__animated animate__rollIn">
                    <div class="card-header">
                        <h5>New Blog Post</h5>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            {{-- Title --}}
                            <div class="mb-3 col-md-6">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" name="title"
                                    class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}"
                                    required>
                                <div class="invalid-feedback">
                                    @error('title')
                                        {{ $message }}
                                    @else
                                        Please enter a title.
                                    @enderror
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="mb-3 col-md-6">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="draft" @selected(old('status') == 'draft')>Draft</option>
                                    <option value="published" @selected(old('status') == 'published')>Published</option>
                                </select>
                                @error('status')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Category --}}
                            <div class="mb-3 col-md-6">
                                <label for="category_id" class="form-label">Category</label>
                                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                    <option value="">Select category...</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tags --}}
                            <div class="mb-3 col-md-6">
                                <label for="tags" class="form-label">Tags</label>
                                <select name="tags[]" class="form-select" multiple>
                                    @foreach ($tags as $tag)
                                        <option value="{{ $tag->id }}" @selected(collect(old('tags'))->contains($tag->id))>
                                            {{ $tag->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Featured Image Upload --}}
                            <div class="mb-3 col-md-12">
                                <label for="featured_image" class="form-label">Featured Image</label>
                                <input type="file" name="featured_image"
                                    class="form-control @error('featured_image') is-invalid @enderror" accept="image/*">
                                @error('featured_image')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Featured Image SEO: Alt text --}}
                            <div class="mb-3 col-md-6">
                                <label for="image_alt" class="form-label">Image Alt Text <small class="text-muted">(SEO)</small></label>
                                <input type="text" name="image_alt" class="form-control" value="{{ old('image_alt') }}"
                                       placeholder="e.g. Camel trek across Sahara dunes at sunset">
                                <small class="text-muted">Describes the image for search engines & screen readers.</small>
                            </div>

                            {{-- Featured Image SEO: Title --}}
                            <div class="mb-3 col-md-6">
                                <label for="image_title" class="form-label">Image Title <small class="text-muted">(SEO)</small></label>
                                <input type="text" name="image_title" class="form-control" value="{{ old('image_title') }}"
                                       placeholder="Shown on hover; leave blank to reuse Alt text">
                            </div>

                            {{-- Featured Image SEO: Caption --}}
                            <div class="mb-3 col-md-12">
                                <label for="image_caption" class="form-label">Image Caption <small class="text-muted">(optional)</small></label>
                                <input type="text" name="image_caption" class="form-control" value="{{ old('image_caption') }}">
                            </div>

                            {{-- Excerpt --}}
                            <div class="mb-3 col-md-12">
                                <label for="excerpt" class="form-label">Excerpt</label>
                                <textarea name="excerpt" rows="3" class="form-control @error('excerpt') is-invalid @enderror">{{ old('excerpt') }}</textarea>
                                @error('excerpt')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-12">
                                <label for="quote" class="form-label">Quote</label>
                                <textarea name="quote" rows="3" class="form-control @error('quote') is-invalid @enderror">{{ old('quote') }}</textarea>
                                @error('quote')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- Content with Quill --}}
                            <div class="mb-3 col-md-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="form-label mb-0">Content</label>
                                    <button type="button" id="toggle-html-view" class="btn btn-sm btn-outline-secondary">View/Edit HTML</button>
                                </div>
                                <div id="quill-editor" style="height: 400px;">{!! old('content') !!}</div>
                                <textarea id="html-source" class="form-control d-none" style="height: 400px; font-family: monospace; font-size: 13px;"></textarea>
                                @error('content')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror

                                <input type="hidden" name="content" id="content-hidden">
                            </div>

                        </div>
                    </div>

                    <div class="card-footer text-end">
                        <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary"
                            onclick="rollOutCard(event, this, 'post-form-card')">Cancel</a>
                        <button type="submit" class="btn btn-primary">Publish Post</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('build/js/plugins/quill.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
    <script>
        (function() {
            var toolbarOptions = [
                ['bold', 'italic', 'underline', 'strike'],
                ['blockquote', 'code-block'],
                [{
                    'header': 1
                }, {
                    'header': 2
                }],
                [{
                    'list': 'ordered'
                }, {
                    'list': 'bullet'
                }],
                [{
                    'script': 'sub'
                }, {
                    'script': 'super'
                }],
                [{
                    'indent': '-1'
                }, {
                    'indent': '+1'
                }],
                [{
                    'direction': 'rtl'
                }],
                [{
                    'size': ['small', false, 'large', 'huge']
                }],
                [{
                    'header': [1, 2, 3, 4, 5, 6, false]
                }],
                [{
                    'color': []
                }, {
                    'background': []
                }],
                [{
                    'font': []
                }],
                [{
                    'align': []
                }],
                ['clean'],
                ['link', 'image', 'video']
            ];

            var quill = new Quill('#quill-editor', {
                theme: 'snow',
                modules: {
                    toolbar: {
                        container: toolbarOptions,
                        handlers: {
                            image: imageHandler
                        }
                    }
                }
            });

            function imageHandler() {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                input.click();

                input.onchange = function() {
                    var file = input.files[0];
                    if (!file) return;

                    var formData = new FormData();
                    formData.append('image', file);
                    formData.append('_token', '{{ csrf_token() }}');

                    fetch('{{ route('admin.posts.upload-image') }}', {
                            method: 'POST',
                            body: formData,
                        })
                        .then(response => response.json())
                        .then(result => {
                            if (result.success && result.url) {
                                var range = quill.getSelection(true);
                                quill.insertEmbed(range.index, 'image', result.url);
                            } else {
                                alert('Image upload failed');
                            }
                        })
                        .catch(error => {
                            console.error(error);
                            alert('Upload error.');
                        });
                };
            }

            // HTML source view toggle: lets you paste raw HTML (e.g. tables)
            // that Quill's normal paste handler would otherwise sanitize away.
            var htmlSource = document.getElementById('html-source');
            var toggleBtn = document.getElementById('toggle-html-view');
            var quillEditorEl = document.getElementById('quill-editor');
            var showingHtml = false;

            toggleBtn.addEventListener('click', function() {
                if (!showingHtml) {
                    htmlSource.value = quill.root.innerHTML;
                    quillEditorEl.parentElement.querySelector('.ql-toolbar').classList.add('d-none');
                    quillEditorEl.classList.add('d-none');
                    htmlSource.classList.remove('d-none');
                    toggleBtn.textContent = 'Apply HTML to Editor';
                } else {
                    quill.clipboard.dangerouslyPasteHTML(htmlSource.value);
                    quillEditorEl.parentElement.querySelector('.ql-toolbar').classList.remove('d-none');
                    quillEditorEl.classList.remove('d-none');
                    htmlSource.classList.add('d-none');
                    toggleBtn.textContent = 'View/Edit HTML';
                }
                showingHtml = !showingHtml;
            });

            document.querySelector('.needs-validation').addEventListener('submit', function(e) {
                var html = showingHtml ? htmlSource.value : quill.root.innerHTML;
                document.getElementById('content-hidden').value = html;
            });

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
            });

        })();

        function rollOutCard(event, link, cardId = 'post-form-card') {
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
@endsection
