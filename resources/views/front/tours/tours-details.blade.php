 @extends('front.layouts.app2')

 @php
     $seoTitle = ($tour->title ?? 'Morocco Tour') . ' | Authentic Morocco Adventures';
     $seoDesc = \Illuminate\Support\Str::limit(trim(strip_tags($tour->overview ?? '')), 155);
     $seoDesc = $seoDesc !== '' ? $seoDesc : 'Book ' . ($tour->title ?? 'this Morocco tour') . ' with Authentic Morocco Adventures — a local expert guide for an authentic Morocco experience.';
     $seoImage = ($tour->getFirstMediaUrl('cover') ?: null);
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
     @if (!empty($tour))
         <div data-anim="fade" class="container">
             <div class="row justify-between py-30 mt-80">
                 <div class="col-auto">
                     <div class="text-14">
                         <a href="{{ url('/') }}">Home</a> >
                         <a href="{{ route('front.tours.index') }}">Tours</a> >
                         <span>{{ $tour->title }}</span>
                     </div>
                 </div>
             </div>
         </div>
     @endif

     <section class="pt-30 js-pin-container">
         <div class="container">
             <div class="row y-gap-30 justify-between">
                 <div data-anim="slide-up delay-1" class="col-lg-8">
                     <div class="">
                         <div class="row x-gap-10 y-gap-10 items-center">
                             @if ($tour->bestseller_flag)
                                 <div class="col-auto">
                                     <button
                                         class="button -accent-1 text-14 py-5 px-15 bg-accent-1-05 text-accent-1 rounded-200">
                                         Bestseller
                                     </button>
                                 </div>
                             @endif

                             @if ($tour->free_cancellation_flag)
                                 <div class="col-auto">
                                     <button class="button -accent-1 text-14 py-5 px-15 bg-light-1 rounded-200">
                                         Free cancellation
                                     </button>
                                 </div>
                             @endif
                         </div>

                         <h2 class="text-40 sm:text-30 lh-14 mt-20">
                             {{ $tour->title }}
                         </h2>

                         <div class="row y-gap-20 justify-between pt-20">
                             <div class="col-auto">
                                 <div class="row x-gap-20 y-gap-20 items-center">
                                     <div class="col-auto">
                                         <div class="d-flex items-center">
                                             @php
                                                 $rating = $tour->avg_rating ?? 0;

                                                 $fullStars = floor($rating);
                                                 $halfStar = $rating - $fullStars >= 0.5;
                                                 $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                             @endphp

                                             <div class="d-flex x-gap-5 pr-10">
                                                 @for ($i = 0; $i < $fullStars; $i++)
                                                     <i class="flex-center icon-star text-12 text-yellow-2"></i>
                                                 @endfor

                                                 @if ($halfStar)
                                                     <i class="flex-center icon-star-half text-12 text-yellow-2"></i>
                                                 @endif

                                                 @for ($i = 0; $i < $emptyStars; $i++)
                                                     <i class="flex-center icon-star text-12 text-light-2"></i>
                                                 @endfor
                                             </div>


                                             <span>
                                                 @if ($tour->reviews_count > 0)
                                                     {{ number_format($rating, 1) }}
                                                     ({{ number_format($tour->reviews_count) }} reviews)
                                                 @else
                                                     New tour
                                                 @endif
                                             </span>
                                         </div>
                                     </div>


                                     <div class="col-auto">
                                         <div class="d-flex items-center">
                                             <i class="icon-pin text-16 mr-5"></i>
                                             {{ $tour->location->name ?? 'Unknown Location' }}
                                         </div>
                                     </div>

                                     <div class="col-auto">
                                         <div class="d-flex items-center">
                                             <i class="icon-reservation text-16 mr-5"></i>
                                             {{ number_format($tour->booked_count) }} booked
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <div class="col-auto">
                                 <div class="d-flex x-gap-30 y-gap-10">
                                     <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                                         target="_blank" rel="noopener noreferrer" class="d-flex items-center">
                                         <i class="icon-share flex-center text-16 mr-10"></i>
                                         Share
                                     </a>


                                     <a href="#" class="d-flex items-center js-favorite-btn"
                                         data-id="{{ $tour->id }}" data-type="tour">
                                         <i class="icon-heart flex-center text-16 mr-10"></i>
                                         Wishlist
                                     </a>

                                 </div>
                             </div>
                         </div>
                     </div>

                     {{-- === TOUR GALLERY SLIDER === --}}
                     <div class="row justify-center pt-30">
                         <div class="col-12">
                             <div class="relative overflow-hidden js-section-slider" data-gap="10"
                                 data-slider-cols="xl-1 lg-1 md-1 sm-1 base-1" data-nav-prev="js-sliderMain-prev"
                                 data-nav-next="js-sliderMain-next" data-loop>

                                 <div class="swiper-wrapper">
                                     @forelse ($gallery as $media)
                                         @php
                                             $alt = $media->getCustomProperty('alt') ?? $tour->title;
                                             $title = $media->getCustomProperty('title') ?? $tour->title;
                                             $caption = $media->getCustomProperty('caption') ?? '';
                                             $desc = $media->getCustomProperty('description') ?? '';
                                         @endphp
                                         <div class="swiper-slide">
                                             <img src="{{ $media->getUrl('slider') }}" alt="{{ $alt }}"
                                                 title="{{ $title }}" data-caption="{{ $caption }}"
                                                 data-description="{{ $desc }}" class="img-cover rounded-12">
                                         </div>
                                     @empty
                                         <div class="swiper-slide">
                                             <img src="{{ asset('assets/images/default-image.png') }}" alt="No Image"
                                                 class="img-cover rounded-12">
                                         </div>
                                     @endforelse

                                 </div>

                                 <div class="navAbsolute -type-2">
                                     <button class="navAbsolute__button bg-white js-sliderMain-prev">
                                         <i class="icon-arrow-left text-14"></i>
                                     </button>
                                     <button class="navAbsolute__button bg-white js-sliderMain-next">
                                         <i class="icon-arrow-right text-14"></i>
                                     </button>
                                 </div>
                             </div>
                         </div>
                     </div>

                     {{-- === TOUR DETAILS BOXES === --}}
                     <div class="row y-gap-20 justify-between items-center layout-pb-md pt-60 md:pt-30">
                         <div class="col-lg-3 col-6">
                             <div class="d-flex items-center">
                                 <div class="flex-center size-50 rounded-12 border-1">
                                     <i class="text-20 icon-clock"></i>
                                 </div>
                                 <div class="ml-10">
                                     <div class="lh-16">Duration</div>
                                     <div class="text-14 text-light-2 lh-16">{{ $tour->duration }}</div>
                                 </div>
                             </div>
                         </div>

                         <div class="col-lg-3 col-6">
                             <div class="d-flex items-center">
                                 <div class="flex-center size-50 rounded-12 border-1">
                                     <i class="text-20 icon-teamwork"></i>
                                 </div>
                                 <div class="ml-10">
                                     <div class="lh-16">Group Size</div>
                                     <div class="text-14 text-light-2 lh-16">{{ $tour->group_size }} people</div>
                                 </div>
                             </div>
                         </div>

                         <div class="col-lg-3 col-6">
                             <div class="d-flex items-center">
                                 <div class="flex-center size-50 rounded-12 border-1">
                                     <i class="text-20 icon-birthday-cake"></i>
                                 </div>
                                 <div class="ml-10">
                                     <div class="lh-16">Ages</div>
                                     <div class="text-14 text-light-2 lh-16">{{ $tour->age_range }}</div>
                                 </div>
                             </div>
                         </div>

                         <div class="col-lg-3 col-6">
                             <div class="d-flex items-center">
                                 <div class="flex-center size-50 rounded-12 border-1">
                                     <i class="text-20 icon-translate"></i>
                                 </div>
                                 <div class="ml-10">
                                     <div class="lh-16">Languages</div>
                                     <div class="text-14 text-light-2 lh-16">
                                         {{ $tour->languages_formatted }}
                                     </div>

                                 </div>
                             </div>
                         </div>
                     </div>


                     {{-- === OVERVIEW === --}}
                     <h2 class="text-30">Tour Overview</h2>
                     <p class="mt-20">{{ $tour->overview }}</p>


                     {{-- === HIGHLIGHTS === --}}
                     @if (!empty($tour->highlights))
                         @php
                             $highlights = is_string($tour->highlights)
                                 ? json_decode($tour->highlights, true)
                                 : $tour->highlights;

                             if (!is_array($highlights)) {
                                 $highlights = array_map('trim', explode(',', $tour->highlights));
                             }
                         @endphp

                         @if (!empty($highlights))
                             <h3 class="text-20 fw-500 mt-20">Tour Highlights</h3>
                             <ul class="ulList mt-20">
                                 @foreach ($highlights as $highlight)
                                     <li>{{ $highlight }}</li>
                                 @endforeach
                             </ul>
                         @endif
                     @endif



                     <div class="line mt-60 mb-60"></div>


                     {{-- === WHAT'S INCLUDED === --}}
                     <h2 class="text-30">What's included</h2>

                     <div class="row x-gap-130 y-gap-20 pt-20">
                         {{-- INCLUDED --}}
                         <div class="col-lg-6">
                             <div class="y-gap-15">
                                 @php
                                     $included = $tour->included;

                                     if (is_string($included)) {
                                         $decoded = json_decode($included, true);
                                         $included = is_array($decoded) ? $decoded : [];
                                     } elseif (!is_array($included)) {
                                         $included = [];
                                     }
                                 @endphp

                                 @forelse ($included as $item)
                                     <div class="d-flex">
                                         <i
                                             class="icon-check flex-center text-10 size-24 rounded-full text-green-2 bg-green-1 mr-15"></i>
                                         {{ $item }}
                                     </div>
                                 @empty
                                     <div class="text-light-2">No included items specified.</div>
                                 @endforelse
                             </div>
                         </div>

                         {{-- EXCLUDED --}}
                         <div class="col-lg-6">
                             <div class="y-gap-15">
                                 @php
                                     $excluded = $tour->excluded;

                                     if (is_string($excluded)) {
                                         $decoded = json_decode($excluded, true);
                                         $excluded = is_array($decoded) ? $decoded : [];
                                     } elseif (!is_array($excluded)) {
                                         $excluded = [];
                                     }
                                 @endphp

                                 @forelse ($excluded as $item)
                                     <div class="d-flex">
                                         <i
                                             class="icon-cross flex-center text-10 size-24 rounded-full text-red-3 bg-red-4 mr-15"></i>
                                         {{ $item }}
                                     </div>
                                 @empty
                                     <div class="text-light-2">No excluded items specified.</div>
                                 @endforelse
                             </div>
                         </div>
                     </div>

                     <div class="line mt-60 mb-60"></div>

                     {{-- === ITINERARY === --}}
                     @if (!empty($tour->itinerary))
                         @php
                             $itinerary = $tour->itinerary;

                             if (is_string($itinerary)) {
                                 $decoded = json_decode($itinerary, true);
                                 $itinerary = is_array($decoded) ? $decoded : [];
                             } elseif (!is_array($itinerary)) {
                                 $itinerary = [];
                             }
                         @endphp

                         @if (count($itinerary))
                             <h2 class="text-30">Itinerary</h2>
                             <div class="mt-30">
                                 <div class="roadmap">
                                     @foreach ($itinerary as $day)
                                         <div class="roadmap__item">
                                             @if ($loop->first)
                                                 <div class="roadmap__iconBig">
                                                     <i class="icon-pin"></i>
                                                 </div>
                                             @elseif($loop->last)
                                                 <div class="roadmap__iconBig">
                                                     <i class="icon-flag"></i>
                                                 </div>
                                             @else
                                                 <div class="roadmap__icon"></div>
                                             @endif

                                             <div class="roadmap__wrap">
                                                 @if (is_array($day))
                                                     <div class="roadmap__title">
                                                         {{ $day['title'] ?? '' }}
                                                     </div>
                                                     @if (!empty($day['content']))
                                                         <div class="roadmap__content">
                                                             {{ $day['content'] }}
                                                         </div>
                                                     @endif
                                                 @else
                                                     <div class="roadmap__title">
                                                         {{ $day }}
                                                     </div>
                                                 @endif
                                             </div>
                                         </div>
                                     @endforeach
                                 </div>
                             </div>
                         @endif
                     @endif

                     @if (!empty($tour->map_frame))
                         <h2 class="text-30 mt-60 mb-30">Tour Map</h2>
                         <div class="mapTourSingle">
                             <x-map-embed :frame="$tour->map_frame" />
                         </div>
                     @endif



                     <div class="line mt-60 mb-60"></div>

                     <h2 class="text-30">FAQ</h2>

                     <div class="accordion -simple row y-gap-20 mt-30 js-accordion">

                         <div class="col-12">
                             <div class="accordion__item px-20 py-15 border-1 rounded-12">
                                 <div class="accordion__button d-flex items-center justify-between">
                                     <div class="button text-16 text-dark-1">Can I get a refund if I cancel my tour?</div>

                                     <div class="accordion__icon size-30 flex-center bg-light-2 rounded-full">
                                         <i class="icon-plus"></i>
                                         <i class="icon-minus"></i>
                                     </div>
                                 </div>

                                 <div class="accordion__content">
                                     <div class="pt-20">
                                         <p>Yes! For most tours, you can receive a full refund if you cancel at least 48
                                             hours before the scheduled start time. Please check the specific cancellation
                                             policy for your tour when booking.</p>
                                     </div>
                                 </div>
                             </div>
                         </div>

                         <div class="col-12">
                             <div class="accordion__item px-20 py-15 border-1 rounded-12">
                                 <div class="accordion__button d-flex items-center justify-between">
                                     <div class="button text-16 text-dark-1">Can I change my travel dates after booking?
                                     </div>

                                     <div class="accordion__icon size-30 flex-center bg-light-2 rounded-full">
                                         <i class="icon-plus"></i>
                                         <i class="icon-minus"></i>
                                     </div>
                                 </div>

                                 <div class="accordion__content">
                                     <div class="pt-20">
                                         <p>Absolutely! I understand travel plans may change. You can reschedule your tour
                                             free of charge, depending on availability. Please contact me as early as
                                             possible to adjust your dates.</p>
                                     </div>
                                 </div>
                             </div>
                         </div>

                         <div class="col-12">
                             <div class="accordion__item px-20 py-15 border-1 rounded-12">
                                 <div class="accordion__button d-flex items-center justify-between">
                                     <div class="button text-16 text-dark-1">When and where does the tour end?</div>

                                     <div class="accordion__icon size-30 flex-center bg-light-2 rounded-full">
                                         <i class="icon-plus"></i>
                                         <i class="icon-minus"></i>
                                     </div>
                                 </div>

                                 <div class="accordion__content">
                                     <div class="pt-20">
                                         <p>Each tour has its own itinerary, but most tours end in the same city where they
                                             started, either in Marrakech, Casablanca, or Fes. I’ll provide all details
                                             about drop-off points and timing during booking and before your tour starts.
                                         </p>
                                     </div>
                                 </div>
                             </div>
                         </div>

                         <div class="col-12">
                             <div class="accordion__item px-20 py-15 border-1 rounded-12">
                                 <div class="accordion__button d-flex items-center justify-between">
                                     <div class="button text-16 text-dark-1">Do you arrange airport transfers in Morocco?
                                     </div>

                                     <div class="accordion__icon size-30 flex-center bg-light-2 rounded-full">
                                         <i class="icon-plus"></i>
                                         <i class="icon-minus"></i>
                                     </div>
                                 </div>

                                 <div class="accordion__content">
                                     <div class="pt-20">
                                         <p>Yes, airport transfers can be arranged for you in any major Moroccan city. Let
                                             me know your arrival or departure details, and I’ll ensure a safe and
                                             comfortable transfer.</p>
                                     </div>
                                 </div>
                             </div>
                         </div>

                         <div class="col-12">
                             <div class="accordion__item px-20 py-15 border-1 rounded-12">
                                 <div class="accordion__button d-flex items-center justify-between">
                                     <div class="button text-16 text-dark-1">What should I pack for a Morocco tour?</div>

                                     <div class="accordion__icon size-30 flex-center bg-light-2 rounded-full">
                                         <i class="icon-plus"></i>
                                         <i class="icon-minus"></i>
                                     </div>
                                 </div>

                                 <div class="accordion__content">
                                     <div class="pt-20">
                                         <p>Pack comfortable clothing for warm days and cooler evenings, especially if
                                             traveling to the desert. Bring sunscreen, a hat, sunglasses, good walking
                                             shoes, and modest attire for visiting religious sites. Don’t forget your
                                             camera!</p>
                                     </div>
                                 </div>
                             </div>
                         </div>

                         <div class="col-12">
                             <div class="accordion__item px-20 py-15 border-1 rounded-12">
                                 <div class="accordion__button d-flex items-center justify-between">
                                     <div class="button text-16 text-dark-1">Is Morocco safe for solo travelers?</div>

                                     <div class="accordion__icon size-30 flex-center bg-light-2 rounded-full">
                                         <i class="icon-plus"></i>
                                         <i class="icon-minus"></i>
                                     </div>
                                 </div>

                                 <div class="accordion__content">
                                     <div class="pt-20">
                                         <p>Yes, Morocco is generally safe for solo travelers, including women. However,
                                             like in any country, it’s best to stay aware of your surroundings and avoid
                                             isolated areas at night. Traveling with a local guide provides extra security
                                             and insider knowledge.</p>
                                     </div>
                                 </div>
                             </div>
                         </div>

                         <div class="col-12">
                             <div class="accordion__item px-20 py-15 border-1 rounded-12">
                                 <div class="accordion__button d-flex items-center justify-between">
                                     <div class="button text-16 text-dark-1">Do your tours include meals?</div>

                                     <div class="accordion__icon size-30 flex-center bg-light-2 rounded-full">
                                         <i class="icon-plus"></i>
                                         <i class="icon-minus"></i>
                                     </div>
                                 </div>

                                 <div class="accordion__content">
                                     <div class="pt-20">
                                         <p>Most tours include breakfast, and many also include lunch or dinner depending on
                                             the itinerary. I’ll always confirm which meals are covered before you book so
                                             you know exactly what to expect.</p>
                                     </div>
                                 </div>
                             </div>
                         </div>

                         <div class="col-12">
                             <div class="accordion__item px-20 py-15 border-1 rounded-12">
                                 <div class="accordion__button d-flex items-center justify-between">
                                     <div class="button text-16 text-dark-1">Can you customize private tours?</div>

                                     <div class="accordion__icon size-30 flex-center bg-light-2 rounded-full">
                                         <i class="icon-plus"></i>
                                         <i class="icon-minus"></i>
                                     </div>
                                 </div>

                                 <div class="accordion__content">
                                     <div class="pt-20">
                                         <p>Absolutely! I specialize in tailor-made private tours. Let me know your
                                             interests, travel dates, and preferred destinations, and I’ll create a unique
                                             itinerary just for you.</p>
                                     </div>
                                 </div>
                             </div>
                         </div>

                     </div>


                     <div class="line mt-60 mb-60"></div>

                     <div class="bg-white rounded-12 shadow-2 py-30 px-30 md:py-20 md:px-20 mt-30">
                         <h2 class="text-30 md:text-24 fw-700 mb-10">Let us know who you are</h2>

                         {{-- Tour Name and Short CTA --}}
                         <div class="mb-20">
                             <h3 class="text-24 text-accent-1 fw-700">{{ $tour->title }}</h3>
                             <div class="text-16 text-dark-1 mt-5">
                                 Let’s reserve your spot now and start your adventure!
                             </div>
                             <div class="text-16 text-primary mt-10">
                                 Only 20% deposit required today!
                             </div>
                         </div>

                         {{-- Include SweetAlert2 via CDN --}}
                         <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                         <script>
                             @if (session('success'))
                                 @php
                                     $success = session('success');
                                     $message = is_array($success) ? $success['message'] : $success;
                                     $context = is_array($success) ? $success['context'] : 'general';

                                     switch ($context) {
                                         case 'review':
                                             $title = 'Review Complete!';
                                             $icon = 'success';
                                             break;
                                         case 'reservation':
                                             $title = 'Reservation Complete!';
                                             $icon = 'success';
                                             break;
                                         default:
                                             $title = 'Success!';
                                             $icon = 'success';
                                             break;
                                     }
                                 @endphp

                                 Swal.fire({
                                     icon: @json($icon),
                                     title: @json($title),
                                     text: @json($message),
                                     confirmButtonColor: '#3085d6',
                                 });
                             @endif

                             @if (session('error'))
                                 Swal.fire({
                                     icon: 'error',
                                     title: 'Something went wrong!',
                                     text: @json(session('error')),
                                     confirmButtonColor: '#d33',
                                 });
                             @endif

                             @if ($errors->any())
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
                             @endif
                         </script>

                         {{-- Validation Errors (stay inline for accessibility) --}}
                         @if ($errors->any())
                             <div class="alert alert-danger mt-20">
                                 <ul class="mb-0">
                                     @foreach ($errors->all() as $error)
                                         <li>{{ $error }}</li>
                                     @endforeach
                                 </ul>
                             </div>
                         @endif

                         <form id="reservationForm" action="{{ route('front.tours.reserve', $tour->slug) }}"
                             method="POST">
                             <div class="row y-gap-30 contactForm pt-30">
                                 @csrf

                                 {{-- Hidden Tour ID --}}
                                 <input type="hidden" name="tour_id" value="{{ $tour->id }}">

                                 <div class="col-12">
                                     <div class="form-input">
                                         <input type="text" name="full_name" required value="{{ old('full_name') }}">
                                         <label class="lh-1 text-16 text-light-1">Your Name *</label>
                                     </div>
                                 </div>

                                 <div class="col-md-6">
                                     <div class="form-input">
                                         <input type="email" name="email" required value="{{ old('email') }}">
                                         <label class="lh-1 text-16 text-light-1">Your Email *</label>
                                     </div>
                                 </div>

                                 <div class="col-md-6">
                                     <div class="form-input">
                                         <input type="text" name="nationality" required
                                             value="{{ old('nationality') }}">
                                         <label class="lh-1 text-16 text-light-1">Nationality *</label>
                                     </div>
                                 </div>

                                 <div class="col-md-6">
                                     <div class="form-input">
                                         <input type="text" name="phone" required value="{{ old('phone') }}">
                                         <label class="lh-1 text-16 text-light-1">Contact Number *</label>
                                     </div>
                                 </div>

                                 <div class="col-md-6">
                                     <div class="form-input">
                                         <input type="date" name="arrival_date" required
                                             min="{{ now()->format('Y-m-d') }}"
                                             value="{{ old('arrival_date') }}">
                                         <label class="lh-1 text-16 text-light-1">Preferred Arrival Date *</label>
                                     </div>
                                 </div>

                                 <div class="col-md-6">
                                     <div class="form-input">
                                         <input type="date" name="departure_date" required
                                             min="{{ now()->format('Y-m-d') }}"
                                             value="{{ old('departure_date') }}">
                                         <label class="lh-1 text-16 text-light-1">Departure Date *</label>
                                     </div>
                                 </div>

                                 <div class="col-md-6">
                                     <div class="form-input">
                                         <input type="number" name="duration_days" required min="1"
                                             value="{{ old('duration_days', 5) }}">
                                         <label class="lh-1 text-16 text-light-1">Preferred Duration (Days) *</label>
                                     </div>
                                 </div>

                                 <div class="col-md-6">
                                     <div class="form-input">
                                         <input type="number" name="adults" required min="1"
                                             value="{{ old('adults', 1) }}">
                                         <label class="lh-1 text-16 text-light-1">No. of Adults *</label>
                                     </div>
                                 </div>

                                 <div class="col-md-6">
                                     <div class="form-input">
                                         <input type="number" name="children" min="0"
                                             value="{{ old('children', 0) }}">
                                         <label class="lh-1 text-16 text-light-1">No. of Children</label>
                                     </div>
                                 </div>

                                 <div class="col-12">
                                     <div class="form-input">
                                         <textarea name="message" required rows="6">{{ old('message') }}</textarea>
                                         <label class="lh-1 text-16 text-light-1">Your Message / Specific Requests
                                             *</label>
                                     </div>
                                 </div>

                                 <div class="col-12">
                                     <div class="row y-gap-20 items-center justify-between">
                                         <div class="col-auto">
                                             <div class="text-14">
                                                 By proceeding with this booking, I agree to the Terms of Use and Privacy
                                                 Policy.
                                             </div>
                                         </div>
                                         <div class="col-md-auto col-12">
                                             <button type="submit"
                                                 class="button -md -dark-1 bg-accent-1 text-white col-12">
                                                 Reserve Now
                                                 <i class="icon-arrow-top-right text-16 ml-10"></i>
                                             </button>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </form>

                     </div>


                     <div class="line mt-60 mb-60"></div>


                     <h2 class="text-30">Customer Reviews</h2>

                     {{-- Overall Ratings --}}
                     @php
                         // Map rating labels to real IcoMoon icon classes
                         $iconMap = [
                             'Location' => 'icon-pin-2',
                             'Amenities' => 'icon-application',
                             'Food' => 'icon-utensils',
                             'Room' => 'icon-bed-2',
                             'Price' => 'icon-price-tag',
                             'Tour Operator' => 'icon-online-support-2',
                         ];
                     @endphp

                     <div class="overallRating mt-30">
                         <div class="overallRating__list">
                             @foreach ($overallRatings as $rating)
                                 @php
                                     // Look up the IcoMoon class or default to icon-star-2
                                     $iconClass = $iconMap[$rating['label']] ?? 'icon-star-2';
                                 @endphp

                                 <div class="overallRating__item">
                                     <div class="overallRating__content">
                                         <div class="overallRating__icon">
                                             <i class="{{ $iconClass }} text-30 text-accent-1"></i>
                                         </div>

                                         <div class="overallRating__info">
                                             <h5 class="text-16 fw-500">{{ $rating['label'] }}</h5>
                                             <div class="lh-15">{{ $rating['text'] }}</div>
                                         </div>
                                     </div>

                                     <div class="overallRating__rating d-flex items-center">
                                         <i class="icon-star text-yellow-2 text-16"></i>
                                         <div class="text-16 fw-500 ml-10">{{ number_format($rating['score'], 1) }}</div>
                                     </div>
                                 </div>
                             @endforeach
                         </div>
                     </div>


                     {{-- Individual Reviews --}}
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
                                             Helpful (<span
                                                 class="helpful_count">{{ $review->helpful_count ?? 0 }}</span>)
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

                         @include('front.partials.review-scripts')
                     @else
                         <p class="pt-30">No reviews yet. Be the first to share your experience!</p>
                     @endif

                     {{-- See More Button --}}
                     @if ($reviews->count() > 3)
                         <button class="button -md -outline-accent-1 text-accent-1 mt-30">
                             See more reviews
                             <i class="icon-arrow-top-right text-16 ml-10"></i>
                         </button>
                     @endif


                     @if (session('success'))
                         @php
                             $success = session('success');
                             $message = is_array($success) ? $success['message'] : $success;
                         @endphp
                         <div class="alert alert-success mt-30"
                             style="
            background-color: #d1e7dd;
            color: #0f5132;
            padding: 15px;
            border-radius: 5px;">
                             {{ $message }}
                         </div>
                     @endif

                     @if ($errors->any())
                         <div class="alert alert-danger mt-30"
                             style="
            background-color: #f8d7da;
            color: #842029;
            padding: 15px;
            border-radius: 5px;">
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

                     {{-- Leave Review Form --}}
                     <div class="contactForm y-gap-30 pt-30">
                         <form method="POST" action="{{ route('front.tours.leaveReview', $tour->slug) }}"
                             enctype="multipart/form-data">
                             @csrf

                             {{-- ✅ REVIEWS GRID MOVED INSIDE THE FORM --}}
                             <div class="ratingForm pt-30">
                                 @foreach ($overallRatings as $rating)
                                     <div class="ratingForm__row">
                                         <label class="ratingForm__label"
                                             for="cat_{{ Str::slug($rating['label']) }}">
                                             {{-- Category Checkbox --}}
                                             <div class="form-checkbox">
                                                 <input type="checkbox" name="categories[]"
                                                     value="{{ $rating['label'] }}"
                                                     id="cat_{{ Str::slug($rating['label']) }}"
                                                     {{ in_array($rating['label'], old('categories', [])) ? 'checked' : '' }}>
                                                 <div class="form-checkbox__mark">
                                                     <div class="form-checkbox__icon">
                                                         <svg width="10" height="8" viewBox="0 0 10 8"
                                                             fill="none">
                                                             <path
                                                                 d="M9.29 0.97c-0.28-0.28-0.73-0.28-1.01 0L3.74 5.51 1.72 3.5c-0.28-0.28-0.73-0.28-1.01 0-0.28 0.28-0.28 0.73 0 1.01L3.23 7.03c0.14 0.14 0.33 0.21 0.52 0.21 0.19 0 0.38-0.07 0.52-0.21L9.29 1.98c0.28-0.28 0.28-0.73 0-1.01z"
                                                                 fill="white" />
                                                         </svg>
                                                     </div>
                                                 </div>
                                             </div>

                                             <span class="text-16 fw-500 ml-10">{{ $rating['label'] }}</span>
                                         </label>

                                         {{-- Interactive Stars for this category --}}
                                         <div class="ratingForm__stars">
                                             @for ($i = 5; $i >= 1; $i--)
                                                 <input type="radio"
                                                     id="star_{{ Str::slug($rating['label']) }}_{{ $i }}"
                                                     name="ratings[{{ $rating['label'] }}]" value="{{ $i }}"
                                                     class="d-none"
                                                     {{ old('ratings.' . $rating['label']) == $i ? 'checked' : '' }}>
                                                 <label for="star_{{ Str::slug($rating['label']) }}_{{ $i }}"
                                                     class="cursor-pointer">
                                                     <i class="icon-star text-yellow-2 text-14"></i>
                                                 </label>
                                             @endfor
                                         </div>
                                     </div>
                                 @endforeach
                             </div>

                             <style>
                                 .ratingForm__row {
                                     display: flex;
                                     align-items: center;
                                     justify-content: space-between;
                                     flex-wrap: wrap;
                                     gap: 10px 20px;
                                     padding: 16px 0;
                                     border-bottom: 1px solid var(--color-border, #E7E6E6);
                                 }

                                 .ratingForm__row:first-child {
                                     padding-top: 0;
                                 }

                                 .ratingForm__row:last-child {
                                     border-bottom: none;
                                 }

                                 .ratingForm__label {
                                     display: flex;
                                     align-items: center;
                                     cursor: pointer;
                                     user-select: none;
                                     margin: 0;
                                 }

                                 .ratingForm__stars {
                                     display: flex;
                                     align-items: center;
                                     gap: 5px;
                                 }

                                 @media (max-width: 575px) {
                                     .ratingForm__row {
                                         justify-content: flex-start;
                                     }

                                     .ratingForm__stars {
                                         width: 100%;
                                         padding-left: 30px;
                                     }
                                 }

                                 label[for^="star_"] i {
                                     color: #ccc;
                                     transition: color 0.3s;
                                 }

                                 label[for^="star_"]:hover i,
                                 label[for^="star_"]:hover~label i {
                                     color: #ffb400;
                                 }

                                 input[type="radio"]:checked+label i {
                                     color: #eb662b;
                                 }

                                 input[type="radio"]:checked+label~label i {
                                     color: #eb662b;
                                 }
                             </style>

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

                             <div class="row y-gap-30 mt-30">
                                 <div class="col-12">
                                     <div class="form-input">
                                         <input type="text" name="title" value="{{ old('title') }}" required>
                                         <label class="lh-1 text-16 text-light-1">Title</label>
                                     </div>
                                 </div>
                             </div>

                             <div class="row y-gap-30 mt-30">
                                 <div class="col-12">
                                     <div class="form-input">
                                         <textarea name="comment" required rows="5">{{ old('comment') }}</textarea>
                                         <label class="lh-1 text-16 text-light-1">Comment</label>
                                     </div>
                                 </div>
                             </div>

                             <div class="row y-gap-30 mt-30">
                                 <div class="col-12">
                                     <h4 class="text-18 fw-500 mb-20">Gallery</h4>

                                     <div class="row x-gap-20 y-gap-20">
                                         <div class="col-auto">
                                             <label
                                                 class="size-130 rounded-12 border-dash-1 bg-accent-1-05 flex-center flex-column cursor-pointer">
                                                 <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                                                     <path fill-rule="evenodd" clip-rule="evenodd"
                                                         d="M11.6663 12.9167C10.5157 12.9167 9.58301 13.8494 9.58301 15C9.58301 16.1506 10.5157 17.0834 11.6663 17.0834C12.8169 17.0834 13.7497 16.1506 13.7497 15C13.7497 13.8494 12.8169 12.9167 11.6663 12.9167ZM7.08301 15C7.08301 12.4687 9.13504 10.4167 11.6663 10.4167C14.1976 10.4167 16.2497 12.4687 16.2497 15C16.2497 17.5314 14.1976 19.5834 11.6663 19.5834C9.13504 19.5834 7.08301 17.5314 7.08301 15Z"
                                                         fill="#EB662B" />
                                                     <path fill-rule="evenodd" clip-rule="evenodd"
                                                         d="M16.9093 26.0079C14.8264 28.3404 12.654 31.5307 10.3572 35.613C10.0187 36.2147 9.25653 36.428 8.65487 36.0895C8.0532 35.7509 7.83988 34.9889 8.17838 34.3872C10.5233 30.2194 12.7967 26.8597 15.0446 24.3427C17.2867 21.8319 19.5642 20.0907 21.9317 19.2709C24.3447 18.4352 26.754 18.5917 29.1295 19.699C31.4633 20.7869 33.7245 22.7714 35.9702 25.5269C36.4062 26.062 36.326 26.8495 35.7908 27.2855C35.2557 27.7217 34.4683 27.6414 34.0322 27.1062C31.9112 24.5035 29.9327 22.8317 28.0733 21.9649C26.2557 21.1177 24.518 21.0209 22.7498 21.6332C20.936 22.2614 18.9978 23.6692 16.9093 26.0079Z"
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
                                     <button type="submit" class="button -md -dark-1 bg-accent-1 text-white">
                                         Post Comment
                                         <i class="icon-arrow-top-right text-16 ml-10"></i>
                                     </button>
                                 </div>
                             </div>
                         </form>
                     </div>

                 </div>

                 <script>
                     document.addEventListener('DOMContentLoaded', () => {
                         const fileInput = document.querySelector('.js-image-upload');
                         const previewContainer = document.querySelector('.js-image-preview');

                         const MAX_IMAGE_SIZE_MB = 2;

                         if (fileInput) {
                             fileInput.addEventListener('change', function(e) {
                                 previewContainer.innerHTML = ''; // Clear old previews

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

                             // Optional: remove image from preview
                             previewContainer?.addEventListener('click', function(e) {
                                 if (e.target.closest('.js-remove-image')) {
                                     e.target.closest('.col-auto').remove();
                                 }
                             });
                         }
                     });
                 </script>

                 <div class="col-lg-4">
                     <div class="d-flex justify-end js-pin-content">
                         <div class="tourSingleSidebar">

                             {{-- PRICE --}}
                             @if ($tour->base_price > 0)
                                 <div class="d-flex items-center">
                                     <div>From</div>
                                     <div class="text-20 fw-500 ml-10">${{ number_format($tour->base_price, 2) }}</div>
                                 </div>
                             @else
                                 <div class="text-18 fw-500">Contact us for price</div>
                             @endif

                             {{-- WHY BOOK WITH US --}}
                             <ul class="ulList mt-15">
                                 <li>No hidden costs</li>
                                 <li>Instant confirmation</li>
                                 <li>Expert local guides</li>
                             </ul>

                             {{-- CANCELLATION POLICY --}}
                             @if ($tour->free_cancellation_flag)
                                 <div class="text-success text-14 mt-10">
                                     Free cancellation up to 24h before start
                                 </div>
                             @endif

                             {{-- DEPOSIT MESSAGE --}}
                             <div class="text-14 text-primary mt-10">
                                 Only 20% deposit required today!
                             </div>

                             {{-- TOTAL --}}
                             @if ($tour->base_price > 0)
                                 <div class="line mt-20 mb-20"></div>
                                 <div class="d-flex items-center justify-between">
                                     <div class="text-18 fw-500">Total:</div>
                                     <div class="text-18 fw-500">${{ number_format($tour->base_price, 2) }}</div>
                                 </div>
                             @endif

                             {{-- BOOK BUTTON --}}
                             <button class="button -md -dark-1 col-12 bg-accent-1 text-white mt-20"
                                 onclick="scrollToReservationForm()">
                                 Book Now
                                 <i class="icon-arrow-top-right ml-10"></i>
                             </button>
                         </div>
                     </div>
                 </div>

             </div>
         </div>
     </section>

     <div class="line mt-60 mb-60"></div>


     @if ($similarTours->count())
         <section class="layout-pt-xl layout-pb-xl">
             <div class="container">
                 <div class="row">
                     <div class="col-auto">
                         <h2 class="text-30">You might also like...</h2>
                     </div>
                 </div>

                 <div class="relative pt-40 sm:pt-20">
                     <div class="overflow-hidden pb-5 js-section-slider" data-gap="30"
                         data-slider-cols="xl-4 lg-3 md-2 sm-1 base-1" data-nav-prev="js-slider1-prev"
                         data-nav-next="js-slider1-next">

                         <div class="swiper-wrapper">
                             @foreach ($similarTours as $similarTour)
                                 @php
                                     $rating = $similarTour->avg_rating ?? 0;
                                     $fullStars = floor($rating);
                                     $halfStar = $rating - $fullStars >= 0.5;
                                     $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                 @endphp

                                 <div class="swiper-slide">
                                     <a href="{{ route('front.tours.show', $similarTour->slug) }}"
                                         class="tourCard -type-1 py-10 px-10 border-1 rounded-12 bg-white -hover-shadow">
                                         <div class="tourCard__header">
                                             <div class="tourCard__image ratio ratio-28:20">
                                                 <img src="{{ $similarTour->getFirstMediaUrl('cover') ?: ($similarTour->getFirstMediaUrl('gallery') ?: asset('assets/images/default-image.png')) }}"
                                                     alt="{{ $similarTour->title }}" class="img-ratio rounded-12" loading="lazy">
                                             </div>

                                                                                      </div>

                                         <div class="tourCard__content px-10 pt-10">
                                             <div class="tourCard__location d-flex items-center text-13 text-light-2">
                                                 <i class="icon-pin d-flex text-16 text-light-2 mr-5"></i>
                                                 {{ $similarTour->location->name ?? 'Unknown Location' }}
                                             </div>

                                             <h3 class="tourCard__title text-16 fw-500 mt-5">
                                                 <span>{{ Str::limit($similarTour->title, 50) }}</span>
                                             </h3>

                                             <div class="tourCard__rating d-flex items-center text-13 mt-5">
                                                 <div class="d-flex x-gap-5">
                                                     @for ($i = 0; $i < $fullStars; $i++)
                                                         <div><i class="icon-star text-10 text-yellow-2"></i></div>
                                                     @endfor

                                                     @if ($halfStar)
                                                         <div><i class="icon-star-half text-10 text-yellow-2"></i></div>
                                                     @endif

                                                     @for ($i = 0; $i < $emptyStars; $i++)
                                                         <div><i class="icon-star text-10 text-light-2"></i></div>
                                                     @endfor
                                                 </div>
                                                 <span class="text-dark-1 ml-10">
                                                     {{ number_format($rating, 1) }}
                                                     ({{ $similarTour->booked_count }})
                                                 </span>
                                             </div>

                                             <div
                                                 class="d-flex justify-between items-center border-1-top text-13 text-dark-1 pt-10 mt-10">
                                                 <div class="d-flex items-center">
                                                     <i class="icon-clock text-16 mr-5"></i>
                                                     {{ $similarTour->duration }}
                                                 </div>

                                                 <div>
                                                     @if ($similarTour->base_price > 0)
                                                         From <span class="text-16 fw-500">
                                                             ${{ number_format($similarTour->base_price, 2) }}
                                                         </span>
                                                     @else
                                                         <span class="text-14 fw-500">Contact for price</span>
                                                     @endif
                                                 </div>
                                             </div>
                                         </div>
                                     </a>
                                 </div>
                             @endforeach
                         </div>
                     </div>

                     <div class="navAbsolute">
                         <button class="navAbsolute__button bg-white js-slider1-prev">
                             <i class="icon-arrow-left text-14"></i>
                         </button>

                         <button class="navAbsolute__button bg-white js-slider1-next">
                             <i class="icon-arrow-right text-14"></i>
                         </button>
                     </div>
                 </div>
             </div>
         </section>
     @endif

     <script>
         function scrollToReservationForm() {
             const form = document.getElementById('reservationForm');
             if (form) {
                 form.scrollIntoView({
                     behavior: 'smooth'
                 });
             }
         }
     </script>

 @endsection
