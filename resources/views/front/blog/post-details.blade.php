@extends('front.layouts.app2')

@php
    $seoTitle = ($post->title ?? 'Blog') . ' | Authentic Morocco Adventures';
    $seoDesc = \Illuminate\Support\Str::limit(trim(strip_tags($post->excerpt ?? '')), 155);
    $seoDesc = $seoDesc !== '' ? $seoDesc : 'Read ' . ($post->title ?? 'this article') . ' on the Authentic Morocco Adventures blog — Morocco travel tips, guides and stories from local experts.';
    $seoImage = ($post->getFirstMediaUrl('featured_image') ?: null);
@endphp

@section('title', $seoTitle)
@section('meta_description', $seoDesc)
@section('og_type', 'article')
@section('og_title', $seoTitle)
@section('og_description', $seoDesc)
@if ($seoImage)
    @section('og_image', $seoImage)
@endif

@section('content')
    {{-- Shift the hero image focus downward so the foreground is visible instead of
         only the sky at the top. Desktop is short & wide, so ease the crop back up;
         mobile is tall, so anchor to the bottom. Here the <img> is a direct child of
         .hero__bg (no <figure>), so target the first image only (not the shape svg). --}}
    <style>
        .hero.-page-hero .hero__bg>img:first-of-type {
            object-position: center 78%;
        }

        @media (max-width: 991px) {
            .hero.-page-hero .hero__bg>img:first-of-type {
                object-position: center bottom;
            }
        }
    </style>

    {{-- HERO SECTION --}}
    <section data-anim="fade" class="hero -type-1 -min-2 -page-hero">
        <div class="hero__bg">
            <img src="{{ asset('assets/images/hero/fes-tannery-worker-red-dye-vat-morocco.webp') }}"
                alt="Moroccan tannery worker standing in red dye vat at Fes tannery, Morocco" loading="lazy" width="1152"
                height="768">
            <img src="{{ asset('assets/images/hero/1/shape.svg') }}" alt="Decorative shape">
        </div>

        <div class="container">
            <div class="row justify-center">
                <div class="col-xl-12">
                    <div class="hero__content">
                        <h1 class="hero__title">
                            {{ $post->title }}
                        </h1>
                        <p class="hero__text">
                            {{ $post->excerpt ?? "Find inspiration, guides and stories for wherever you're going. Select a destination." }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- BLOG DETAILS --}}
    <section class="layout-pt-md layout-pb-xl">
        <div class="container">
            <div class="row y-gap-30 justify-center">
                <div class="col-lg-8">

                    @if ($post->getFirstMediaUrl('featured_image'))
                        @php $featuredMedia = $post->getFirstMedia('featured_image'); @endphp
                        <figure class="m-0 mb-30">
                            <img src="{{ $post->getFirstMediaUrl('featured_image') }}"
                                alt="{{ $featuredMedia?->getCustomProperty('alt') ?? $post->title }}"
                                title="{{ $featuredMedia?->getCustomProperty('title') ?? $post->title }}"
                                class="rounded-8 w-100">
                            @if ($featuredMedia?->getCustomProperty('caption'))
                                <figcaption class="text-14 text-light-1 mt-10">{{ $featuredMedia->getCustomProperty('caption') }}</figcaption>
                            @endif
                        </figure>
                    @endif

                    <div class="d-flex x-gap-20 text-14 text-dark-1 mb-30">
                        <span>Published on {{ $post->published_at?->format('M d, Y') }}</span>
                        <span>By {{ $post->author?->name ?? 'Unknown' }}</span>
                    </div>

                    <div class="blog-post-content">
                        {!! $post->content !!}
                    </div>

                    {{-- Display quote block if post has a quote --}}
                    @if ($post->quote)
                        <div class="blockquote bg-accent-1-05 rounded-12 px-30 py-30 mt-20">
                            <div class="blockquote__icon">
                                <svg width="37" height="25" viewBox="0 0 37 25" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6.50417 24.1C4.50417 24.1 2.8375 23.3333 1.50417 21.8C0.237499 20.2 -0.229167 17.9667 0.104167 15.1C0.570834 10.7 2.17083 7.1 4.90417 4.3C7.70417 1.43333 11.1708 0 15.3042 0C16.6375 0 17.6042 0.099998 18.2042 0.299995L17.4042 4.3C16.6708 4.16667 15.6375 4.1 14.3042 4.1C13.0375 4.1 11.8375 4.4 10.7042 5C9.6375 5.6 8.80417 6.4 8.20417 7.4C6.9375 8.86667 6.1375 10.5333 5.80417 12.4C6.80417 11.4 8.1375 10.9 9.80417 10.9C11.4708 10.9 12.8042 11.4 13.8042 12.4C14.8042 13.4 15.2042 14.7667 15.0042 16.5C14.8042 18.6333 13.8708 20.4333 12.2042 21.9C10.6042 23.3667 8.70417 24.1 6.50417 24.1ZM24.9042 24.1C22.9042 24.1 21.2375 23.3333 19.9042 21.8C18.6375 20.2 18.1708 17.9667 18.5042 15.1C18.9708 10.7 20.5708 7.1 23.3042 4.3C26.1042 1.43333 29.5708 0 33.7042 0C35.0375 0 36.0042 0.099998 36.6042 0.299995L35.8042 4.3C35.0708 4.16667 34.0375 4.1 32.7042 4.1C31.4375 4.1 30.2375 4.4 29.1042 5C28.0375 5.6 27.2042 6.4 26.6042 7.4C25.3375 8.86667 24.5375 10.5333 24.2042 12.4C25.2042 11.4 26.5375 10.9 28.2042 10.9C29.8708 10.9 31.2042 11.4 32.2042 12.4C33.2042 13.4 33.6042 14.7667 33.4042 16.5C33.2042 18.6333 32.2708 20.4333 30.6042 21.9C29.0042 23.3667 27.1042 24.1 24.9042 24.1Z"
                                        fill="#EB662B"></path>
                                </svg>
                            </div>
                            <div class="blockquote__text">
                                “{{ $post->quote }}”
                            </div>
                        </div>
                    @endif

                    {{-- TAGS AND SOCIAL --}}
                    <div class="row y-gap-15 justify-between items-center pt-20">
                        <div class="col-auto">
                           
                            <div class="d-flex x-gap-10">
                                <div>
                                    <a href="https://web.facebook.com/authenticmoroccoadventures/" target="_blank"
                                        class="button -accent-1 size-40 flex-center bg-accent-1-05 rounded-full">
                                        <i class="icon-facebook text-14"></i>
                                    </a>
                                </div>

                                <div>
                                    <a href="https://x.com/AMADMCmor" target="_blank"
                                        class="button -accent-1 size-40 flex-center bg-accent-1-05 rounded-full">
                                        <i class="icon-twitter text-14"></i>
                                    </a>
                                </div>

                                <div>
                                    <a href="https://www.instagram.com/authenticmoroccoadventures/" target="_blank"
                                        class="button -accent-1 size-40 flex-center bg-accent-1-05 rounded-full">
                                        <i class="icon-instagram text-14"></i>
                                    </a>
                                </div>

                                <div>
                                    <a href="https://www.linkedin.com/in/authentic-moroccoadventures-99812a420/" target="_blank"
                                        class="button -accent-1 size-40 flex-center bg-accent-1-05 rounded-full">
                                        <i class="icon-linkedin text-14"></i>
                                    </a>
                                </div>

                                <div>
                                    <a href="https://fr.pinterest.com/amoroccoadventures/" target="_blank"
                                        class="button -accent-1 size-40 flex-center bg-accent-1-05 rounded-full social-btn">
                                        <i class="bi bi-pinterest"></i>
                                    </a>
                                </div>

                                <div>
                                    <a href="https://www.youtube.com/@AuthenticMoroccoAdventures"
                                        target="_blank"
                                        class="button -accent-1 size-40 flex-center bg-accent-1-05 rounded-full social-btn">
                                        <i class="bi bi-youtube"></i>
                                    </a>
                                </div>
                            </div>

                        </div>

                        <div class="col-auto">
                            <div class="d-flex x-gap-10">
                                @foreach ($post->tags as $tag)
                                    <div>
                                        <a href="{{ route('blog.tag', $tag->slug) }}"
                                            class="button -accent-1 border-1 text-14 px-15 py-10 rounded-200">
                                            {{ $tag->name }}
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- AUTHOR BOX --}}
                    <div class="line mt-60 mb-30"></div>

                    <div class="row y-gap-20">
                        <div class="col-auto">
                            <figure class="m-0">
                                <img src="{{ asset('assets/images/blog/morocco-tour-guide-atlas-mountains-scenic-view.webp') }}"
                                    alt="Authentic Morocco Adventures guide sitting and smiling on a mountain viewpoint overlooking winding roads and scenic Atlas Mountains landscape."
                                    title="Authentic Morocco Adventures Guide Enjoying Scenic Atlas Mountains View"
                                    class="rounded-12" style="width:80px; height:80px; object-fit:cover;">

                                <figcaption class="visually-hidden">
                                    Authentic Morocco Adventures guide taking a break at a stunning viewpoint in Morocco’s Atlas
                                    Mountains.
                                </figcaption>
                            </figure>
                        </div>

                        <div class="col">
                            <div class="text-18 fw-500">Mohammed</div>
                            <div class="lh-15">
                                Mohammed is an experienced local guide passionate about showcasing Morocco’s hidden gems.
                                With deep knowledge of the Atlas Mountains, Berber culture, and Morocco’s rich heritage,
                                he ensures unforgettable and authentic travel experiences for every visitor.
                            </div>
                        </div>
                    </div>
                    <style>
                        .visually-hidden {
                            position: absolute !important;
                            height: 1px;
                            width: 1px;
                            overflow: hidden;
                            clip: rect(1px, 1px, 1px, 1px);
                            white-space: nowrap;
                        }
                    </style>


                    <div class="line mt-30 mb-30"></div>
                    <div class="row y-gap-15 justify-between">

                        {{-- PREVIOUS POST --}}
                        <div class="col-md-auto">
                            @if ($previousPost)
                                <div class="d-flex">
                                    <div class="pt-5">
                                        <i class="icon-arrow-left text-16"></i>
                                    </div>
                                    <div class="ml-20">
                                        <div class="text-18 fw-500">Prev</div>
                                        <div class="mt-5">
                                            <a href="{{ route('blog.show', $previousPost->slug) }}">
                                                {{ $previousPost->title }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-light-2">No previous post</div>
                            @endif
                        </div>

                        <div class="col-auto md:d-none">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect width="4" height="4" fill="#05073C" />
                                <rect y="8" width="4" height="4" fill="#05073C" />
                                <rect y="16" width="4" height="4" fill="#05073C" />
                                <rect x="8" width="4" height="4" fill="#05073C" />
                                <rect x="8" y="8" width="4" height="4" fill="#05073C" />
                                <rect x="8" y="16" width="4" height="4" fill="#05073C" />
                                <rect x="16" width="4" height="4" fill="#05073C" />
                                <rect x="16" y="8" width="4" height="4" fill="#05073C" />
                                <rect x="16" y="16" width="4" height="4" fill="#05073C" />
                            </svg>
                        </div>

                        {{-- NEXT POST --}}
                        <div class="col-md-auto">
                            @if ($nextPost)
                                <div class="d-flex text-right md:text-left">
                                    <div class="mr-20">
                                        <div class="text-18 fw-500">Next</div>
                                        <div class="mt-5">
                                            <a href="{{ route('blog.show', $nextPost->slug) }}">
                                                {{ $nextPost->title }}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="pt-5">
                                        <i class="icon-arrow-right text-16"></i>
                                    </div>
                                </div>
                            @else
                                <div class="text-light-2">No next post</div>
                            @endif
                        </div>

                    </div>

                    {{-- Placeholder reviews section --}}
                    <div class="line mt-30 mb-30"></div>
                    <h2 class="text-30">Customer Reviews</h2>

                    @if ($reviews->count())
                        @foreach ($reviews as $review)
                            <div class="pt-30" data-review-id="{{ $review->id }}">
                                <div class="row justify-between">
                                    <div class="col-auto">
                                        <div class="d-flex items-center">
                                            <div class="size-40 rounded-full">
                                                <img src="{{ asset('assets/images/icon/avatar.webp') }}" alt="avatar"
                                                    class="img-cover">
                                            </div>
                                            <div class="text-16 fw-500 ml-20">{{ $review->name }}</div>
                                        </div>
                                    </div>

                                    <div class="col-auto">
                                        <div class="text-14 text-light-2">{{ $review->date }}</div>
                                    </div>
                                </div>

                                <div class="d-flex items-center mt-15">
                                    <div class="d-flex x-gap-5">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i
                                                class="icon-star text-yellow-2 text-10 {{ $i <= floor($review->rating) ? '' : 'opacity-30' }}"></i>
                                        @endfor
                                    </div>
                                    <div class="text-16 fw-500 ml-10">{{ $review->title }}</div>
                                </div>

                                <p class="mt-10">{{ $review->comment }}</p>

                                @if (!empty($review->images))
                                    <div class="row x-gap-20 y-gap-20 pt-20">
                                        @foreach ($review->images as $image)
                                            <div class="col-auto">
                                                <div class="size-130">
                                                    <img src="{{ $image }}" alt="review image"
                                                        class="img-cover rounded-12">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="d-flex x-gap-30 items-center mt-20">
                                    <div>
                                        <a href="#" class="d-flex items-center js-helpful-btn"
                                            data-review-id="{{ $review->id }}">
                                            <i class="icon-like text-16 mr-10"></i>
                                            Helpful (<span class="helpful_count">{{ $review->helpful_count ?? 0 }}</span>)
                                        </a>
                                    </div>
                                    <div>
                                        <a href="#" class="d-flex items-center js-not-helpful-btn"
                                            data-review-id="{{ $review->id }}">
                                            <i class="icon-dislike text-16 mr-10"></i>
                                            Not helpful (<span
                                                class="not_helpful_count">{{ $review->not_helpful_count ?? 0 }}</span>)
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @include('front.partials.review-scripts2')
                    @else
                        <p class="pt-30">No reviews yet. Be the first to share your thoughts!</p>
                    @endif

                    @if ($reviews->count() > 3)
                        <button class="button -md -outline-accent-1 text-accent-1 mt-30">
                            See more reviews
                            <i class="icon-arrow-top-right text-16 ml-10"></i>
                        </button>
                    @endif
                    {{-- Load SweetAlert2 --}}
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                    @php
                        // Always prepare success message once at the top
                        $message = null;
                        $context = null;
                        $title = 'Reservation Complete!';

                        if (session('success')) {
                            $success = session('success');
                            $message = is_array($success) ? $success['message'] : $success;
                            $context = is_array($success) && isset($success['context']) ? $success['context'] : null;

                            // Optional: customize title if context indicates review
                            $title = $context === 'review' ? 'Review Submitted!' : 'Reservation Complete!';
                        }
                    @endphp

                    @if (session('success'))
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: @json($title),
                                text: @json($message),
                                confirmButtonColor: '#3085d6',
                            });
                        </script>

                        {{-- Optional HTML alert if you want a visible alert as well --}}
                        <div class="alert alert-success mt-30 {{ $context === 'review' ? 'alert-review' : 'alert-reservation' }}"
                            style="background-color: #d1e7dd; color: #0f5132; padding: 15px; border-radius: 5px;">
                            {{ $message }}
                        </div>
                    @endif

                    @if (session('error'))
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops!',
                                text: @json(session('error')),
                                confirmButtonColor: '#d33',
                            });
                        </script>

                        <div class="alert alert-danger mt-30"
                            style="background-color: #f8d7da; color: #842029; padding: 15px; border-radius: 5px;">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger mt-30"
                            style="background-color: #f8d7da; color: #842029; padding: 15px; border-radius: 5px;">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <script>
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'warning',
                                title: 'Please fix the following:',
                                html: @json($errors->all())
                                    .map(msg => `&bull; ${msg}`)
                                    .join('<br>'),
                                showConfirmButton: false,
                                timer: 6000,
                                timerProgressBar: true,
                            });
                        </script>
                    @endif



                    <h2 class="text-30 pt-60">Leave a Reply</h2>
                    <p class="mt-30">Your email address will not be published. Required fields are marked *</p>

                    <div class="contactForm y-gap-30 pt-30">
                        <form method="POST" action="{{ route('blog.leaveReview', $post->slug) }}"
                            enctype="multipart/form-data" data-recaptcha-action="leave_review">
                            @csrf

                            <div class="row y-gap-30 mt-30">
                                <div class="col-md-6">
                                    <div class="form-input">
                                        <input type="text" name="name" value="{{ old('name') }}" required>
                                        <label class="lh-1 text-16 text-light-1">Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-input">
                                        <input type="email" name="email" value="{{ old('email') }}" required>
                                        <label class="lh-1 text-16 text-light-1">Email</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-30">
                                <div class="col-12">
                                    <div class="form-input">
                                        <input type="text" name="title" value="{{ old('title') }}" required>
                                        <label class="lh-1 text-16 text-light-1">Title</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-30">
                                <div class="col-12">
                                    <div class="form-input">
                                        <textarea name="comment" rows="5" required>{{ old('comment') }}</textarea>
                                        <label class="lh-1 text-16 text-light-1">Comment</label>
                                    </div>
                                </div>
                            </div>

                            {{-- Image Upload --}}
                            <div class="row mt-30">
                                <div class="col-12">
                                    <h4 class="text-18 fw-500 mb-20">Gallery</h4>
                                    <div class="row x-gap-20 y-gap-20">
                                        <div class="col-auto">
                                            <label
                                                class="size-130 rounded-12 border-dash-1 bg-accent-1-05 flex-center flex-column cursor-pointer">
                                                <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M11.6663 12.9167C10.5157 12.9167 9.58301 13.8494 9.58301 15C9.58301 16.1506 10.5157 17.0834 11.6663 17.0834C12.8169 17.0834 13.7497 16.1506 13.7497 15C13.7497 13.8494 12.8169 12.9167 11.6663 12.9167Z"
                                                        fill="#EB662B" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M16.9093 26.0079C14.8264 28.3404 12.654 31.5307 10.3572 35.613C10.0187 36.2147 9.25653 36.428 8.65487 36.0895C8.0532 35.7509 7.83988 34.9889 8.17838 34.3872C10.5233 30.2194 12.7967 26.8597 15.0446 24.3427C17.2867 21.8319 19.5642 20.0907 21.9317 19.2709C24.3447 18.4352 26.754 18.5917 29.1295 19.699C31.4633 20.7869 33.7245 22.7714 35.9702 25.5269C36.4062 26.062 36.326 26.8495 35.7908 27.2855C35.2557 27.7217 34.4683 27.6414 34.0322 27.1062C31.9112 24.5035 29.9327 22.8317 28.0733 21.9649Z"
                                                        fill="#EB662B" />
                                                </svg>
                                                <div class="text-16 fw-500 text-accent-1 mt-10">Upload Images</div>
                                                <input type="file" name="images[]" multiple
                                                    class="d-none js-image-upload">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row x-gap-20 y-gap-20 mt-20 js-image-preview"></div>
                                    <div class="text-14 mt-20">PNG or JPG, max 2MB per image.</div>
                                </div>
                            </div>

                            <div class="row mt-30">
                                <div class="col-12">
                                    @include('front.partials._recaptcha_notice')
                                </div>
                                <div class="col-12 mt-20">
                                    <button type="submit" class="button -md -dark-1 bg-accent-1 text-white">
                                        Post Comment
                                        <i class="icon-arrow-top-right text-16 ml-10"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            const fileInput = document.querySelector('.js-image-upload');
                            const previewContainer = document.querySelector('.js-image-preview');

                            const MAX_IMAGE_SIZE_MB = 2;

                            if (fileInput) {
                                fileInput.addEventListener('change', function(e) {
                                    previewContainer.innerHTML = '';

                                    const oversized = [];

                                    Array.from(e.target.files).forEach(file => {
                                        if (!file.type.startsWith('image/')) return;

                                        if (file.size > MAX_IMAGE_SIZE_MB * 1024 * 1024) {
                                            oversized.push(file.name);
                                            return;
                                        }

                                        const reader = new FileReader();
                                        reader.onload = function(e) {
                                            const imgHtml = `
                                <div class="col-auto">
                                    <div class="relative">
                                        <img src="${e.target.result}" class="size-130 rounded-12 object-cover" alt="">
                                        <button type="button" class="absoluteIcon1 button -dark-1 js-remove-image">
                                            <i class="icon-delete text-18"></i>
                                        </button>
                                    </div>
                                </div>
                            `;
                                            previewContainer.insertAdjacentHTML('beforeend', imgHtml);
                                        };
                                        reader.readAsDataURL(file);
                                    });

                                    if (oversized.length && typeof Swal !== 'undefined') {
                                        Swal.fire({
                                            toast: true,
                                            position: 'top-end',
                                            icon: 'warning',
                                            title: `Skipped ${oversized.length} image(s) over ${MAX_IMAGE_SIZE_MB}MB`,
                                            text: oversized.join(', '),
                                            showConfirmButton: false,
                                            timer: 6000,
                                            timerProgressBar: true,
                                        });
                                    }
                                });

                                previewContainer?.addEventListener('click', function(e) {
                                    if (e.target.closest('.js-remove-image')) {
                                        e.target.closest('.col-auto').remove();
                                    }
                                });
                            }
                        });
                    </script>

                </div>
            </div>
        </div>
    </section>
@endsection
