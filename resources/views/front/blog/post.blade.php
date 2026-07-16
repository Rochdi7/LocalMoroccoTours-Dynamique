 @extends('front.layouts.app2')
 @section('title', 'Blog')

 @section('content')

 @section('content')

     {{-- Shift the hero image focus downward so the foreground is visible instead of
          only the sky at the top. Desktop is short & wide, so ease the crop back up;
          mobile is tall, so anchor to the bottom. The theme applies object-fit:cover
          to the <figure> (direct child of .hero__bg), so target both figure & img. --}}
     <style>
         .hero.-page-hero .hero__bg figure,
         .hero.-page-hero .hero__bg figure img {
             width: 100%;
             height: 100%;
             object-fit: cover;
             object-position: center 78%;
         }

         @media (max-width: 991px) {

             .hero.-page-hero .hero__bg figure,
             .hero.-page-hero .hero__bg figure img {
                 object-position: center bottom;
             }
         }
     </style>

     {{-- HERO SECTION --}}
     <section data-anim="fade" class="hero -type-1 -min-2 -page-hero">
         <div class="hero__bg">
             <figure class="m-0">
                 <img src="{{ asset('assets/images/hero/jemaa-el-fnaa-square-cafe-view-marrakech-morocco.webp') }}"
                     alt="View from a shaded café over the bustling Jemaa el-Fnaa square and market stalls in Marrakech, Morocco"
                     title="Looking out over Marrakech's Jemaa el-Fnaa square and its market stalls from a shaded café."
                     loading="lazy" width="1600" height="1060">
                 <figcaption class="visually-hidden">
                     Travelers relax in a shaded café overlooking the lively Jemaa el-Fnaa square in Marrakech,
                     where market stalls, minarets and rooftops set the scene for Authentic Morocco Adventures'
                     travel stories and guides.
                 </figcaption>
             </figure>
             <img src="{{ asset('assets/images/hero/1/shape.svg') }}" alt="Decorative shape">
         </div>

         <div class="container">
             <div class="row justify-center">
                 <div class="col-xl-12">
                     <div class="hero__content">
                         <h1 class="hero__title">
                             Your guide to everywhere
                         </h1>
                         <p class="hero__text">
                             Find inspiration, guides and stories for wherever you're going. Select a destination.
                         </p>
                         <p class="hero__caption visually-hidden">
                             A stunning courtyard inside a traditional Moroccan riad, featuring intricate tilework, carved
                             arches, and a central star-shaped mosaic fountain — a perfect example of Morocco’s rich
                             architectural heritage.
                         </p>
                     </div>
                 </div>
             </div>
         </div>
     </section>
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

     {{-- BLOG LIST SECTION --}}
     <section class="layout-pt-md layout-pb-xl">
         <div class="container">
             <div class="row y-gap-30 justify-between">
                 <div class="col-lg-8">
                     <div class="row y-gap-30">

                         @forelse ($posts as $post)
                             <div class="col-12">
                                 <a href="{{ route('blog.show', $post->slug) }}" class="pl-blog-list">
                                     <div class="pl-blog-list__image">
                                         <img src="{{ $post->getFirstMediaUrl('featured_image') ?: asset('img/blogCards/1/placeholder.png') }}"
                                             alt="{{ $post->getFirstMedia('featured_image')?->getCustomProperty('alt') ?? $post->title }}">
                                     </div>

                                     <div class="pl-blog-list__content">
                                         <div class="d-flex x-gap-10 text-14">
                                             <div class="lh-13">
                                                 {{ $post->published_at?->format('M d Y') }}
                                             </div>
                                             <div class="lh-13">
                                                 By {{ $post->author?->name ?? 'Unknown' }}
                                             </div>
                                         </div>

                                         <h3 class="blogCard__title text-20 fw-500 lh-15 mt-10">
                                             {{ $post->title }}
                                         </h3>

                                         <p class="mt-10">
                                             {{ \Illuminate\Support\Str::limit(strip_tags($post->excerpt), 150) }}
                                         </p>

                                         <button class="fw-500 mt-10">
                                             <span class="mr-10">Read More</span>
                                             <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                 <g clip-path="url(#clip0_142_28418)">
                                                     <path
                                                         d="M15.5553 0H5.77756C5.53189 0 5.3331 0.198792 5.3331 0.444458C5.3331 0.690125 5.53189 0.888917 5.77756 0.888917H14.4824L0.129975 15.2413C-0.0436504 15.415 -0.0436504 15.6962 0.129975 15.8698C0.216766 15.9566 0.330516 16 0.444225 16C0.557933 16 0.671641 15.9566 0.758475 15.8698L15.1109 1.51738V10.2223C15.1109 10.4679 15.3097 10.6667 15.5553 10.6667C15.801 10.6667 15.9998 10.4679 15.9998 10.2223V0.444458C15.9998 0.198792 15.801 0 15.5553 0Z"
                                                         fill="#05073C" />
                                                 </g>
                                                 <defs>
                                                     <clipPath id="clip0_142_28418">
                                                         <rect width="16" height="16" fill="white" />
                                                     </clipPath>
                                                 </defs>
                                             </svg>
                                         </button>
                                     </div>
                                 </a>
                             </div>
                         @empty
                             <div class="col-12">
                                 <p>No blog posts available at the moment.</p>
                             </div>
                         @endforelse

                     </div>

                     <div class="d-flex justify-center flex-column mt-60">
                         @if ($posts->lastPage() > 1)
                             <div class="pagination justify-center">

                                 {{-- Previous --}}
                                 @if ($posts->onFirstPage())
                                     <button class="pagination__button button -accent-1 mr-15 -prev" disabled>
                                         <i class="icon-arrow-left text-15" style="font-size: 12px;"></i>
                                     </button>
                                 @else
                                     <a href="{{ $posts->previousPageUrl() }}"
                                         class="pagination__button button -accent-1 mr-15 -prev">
                                         <i class="icon-arrow-left text-15" style="font-size: 12px;"></i>
                                     </a>
                                 @endif

                                 {{-- Page numbers --}}
                                 <div class="pagination__count">
                                     @for ($i = 1; $i <= $posts->lastPage(); $i++)
                                         @if ($i == $posts->currentPage())
                                             <span class="is-active">{{ $i }}</span>
                                         @else
                                             <a href="{{ $posts->url($i) }}">{{ $i }}</a>
                                         @endif
                                     @endfor
                                 </div>

                                 {{-- Next --}}
                                 @if ($posts->hasMorePages())
                                     <a href="{{ $posts->nextPageUrl() }}"
                                         class="pagination__button button -accent-1 ml-15 -next">
                                         <i class="icon-arrow-right text-15" style="font-size: 12px;"></i>
                                     </a>
                                 @else
                                     <button class="pagination__button button -accent-1 ml-15 -next" disabled>
                                         <i class="icon-arrow-right text-15" style="font-size: 12px;"></i>
                                     </button>
                                 @endif

                             </div>

                             <div class="text-14 text-center mt-20">
                                 Showing
                                 {{ ($posts->currentPage() - 1) * $posts->perPage() + 1 }}
                                 -
                                 {{ min($posts->currentPage() * $posts->perPage(), $posts->total()) }}
                                 of
                                 {{ $posts->total() }}
                                 results
                             </div>
                         @endif
                     </div>

                 </div>

                 {{-- SIDEBAR --}}
                 <div class="col-lg-4">
                     <div class="sidebar -type-2">
                         {{-- Search box (static placeholder) --}}
                         <div class="sidebar__search">
                             <i>
                                 <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                     <path
                                         d="M8.20459 1.44849C4.48555 1.44849 1.45605 4.47798 1.45605 8.19703C1.45605 11.9161 4.48555 14.9515 8.20459 14.9515C9.7931 14.9515 11.254 14.3948 12.4087 13.4705L15.2197 16.28C15.3616 16.416 15.5511 16.491 15.7476 16.489C15.944 16.487 16.1319 16.4082 16.271 16.2693C16.41 16.1304 16.4892 15.9427 16.4915 15.7462C16.4937 15.5497 16.419 15.3601 16.2832 15.2181L13.4722 12.407C14.3972 11.2506 14.9546 9.78738 14.9546 8.19703C14.9546 4.47798 11.9236 1.44849 8.20459 1.44849ZM8.20459 2.94851C11.113 2.94851 13.4531 5.28866 13.4531 8.19703C13.4531 11.1054 11.113 13.4514 8.20459 13.4514C5.29621 13.4514 2.95605 11.1054 2.95605 8.19703C2.95605 5.28866 5.29621 2.94851 8.20459 2.94851Z"
                                         fill="#05073C" />
                                 </svg>
                             </i>

                             <form action="{{ route('blog.search') }}" method="GET" class="sidebar__search">
                                 <i>
                                     <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                         <path
                                             d="M8.20459 1.44849C4.48555 1.44849 1.45605 4.47798 1.45605 8.19703C1.45605 11.9161 4.48555 14.9515 8.20459 14.9515C9.7931 14.9515 11.254 14.3948 12.4087 13.4705L15.2197 16.28C15.3616 16.416 15.5511 16.491 15.7476 16.489C15.944 16.487 16.1319 16.4082 16.271 16.2693C16.41 16.1304 16.4892 15.9427 16.4915 15.7462C16.4937 15.5497 16.419 15.3601 16.2832 15.2181L13.4722 12.407C14.3972 11.2506 14.9546 9.78738 14.9546 8.19703C14.9546 4.47798 11.9236 1.44849 8.20459 1.44849ZM8.20459 2.94851C11.113 2.94851 13.4531 5.28866 13.4531 8.19703C13.4531 11.1054 11.113 13.4514 8.20459 13.4514C5.29621 13.4514 2.95605 11.1054 2.95605 8.19703C2.95605 5.28866 5.29621 2.94851 8.20459 2.94851Z"
                                             fill="#05073C" />
                                     </svg>
                                 </i>
                                 <input type="text" name="q" placeholder="Search..." value="{{ request('q') }}">
                             </form>
                         </div>

                         {{-- Categories --}}
                         <div class="sidebar__item">
                             <h4 class="text-18 fw-500 mb-20">Blog Categories</h4>

                             <div class="d-flex flex-column y-gap-5">
                                 @foreach ($categories as $category)
                                     <a href="{{ route('blog.category', $category->slug) }}">
                                         {{ $category->name }}
                                     </a>
                                 @endforeach

                             </div>
                         </div>

                         {{-- Recent Posts --}}
                         <div class="sidebar__item">
                             <h4 class="text-18 fw-500 mb-20">Recent Posts</h4>

                             <div class="d-flex y-gap-20 flex-column">
                                 @foreach ($recentPosts as $recent)
                                     <a href="{{ route('blog.show', $recent->slug) }}" class="d-flex align-center">
                                         <div class="size-70 overflow-hidden rounded-12">
                                             <img src="{{ $recent->getFirstMediaUrl('featured_image') ?: asset('img/blogCards/1/placeholder.png') }}"
                                                 alt="{{ $recent->getFirstMedia('featured_image')?->getCustomProperty('alt') ?? $recent->title }}" class="img-cover">
                                         </div>

                                         <div class="ml-20">
                                             <h5 class="text-15 lh-14 fw-500">{{ $recent->title }}</h5>
                                             <div class="text-14 lh-1 mt-10">
                                                 {{ $recent->published_at?->format('M d Y') }}
                                             </div>
                                         </div>
                                     </a>
                                 @endforeach
                             </div>
                         </div>

                         {{-- Tags --}}
                         <div class="sidebar__item">
                             <h4 class="text-18 fw-500 mb-20">Tags</h4>

                             <div class="sidebar__tags d-flex y-gap-10 x-gap-10">
                                 @foreach ($tags as $tag)
                                     <div>
                                         <a href="{{ route('blog.tag', $tag->slug) }}">
                                             {{ $tag->name }}
                                         </a>
                                     </div>
                                 @endforeach

                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </section>


 @endsection
