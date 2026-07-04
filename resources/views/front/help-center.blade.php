@extends('front.layouts.app2')

@section('title', 'Help Center - Authentic Morocco Adventures')

@push('meta')
<meta name="description" content="Get help with booking, payments, refunds, and planning your Moroccan adventure with Authentic Morocco Adventures. Explore our Help Center for FAQs and support.">
@endpush

@section('content')

<section data-anim="fade" class="pageHeader -type-2">
  <div class="pageHeader__bg">
    <img src="{{ asset('assets/img/pageHeader/2.jpg') }}" alt="Beautiful Moroccan scenery - Authentic Morocco Adventures">
    <img src="{{ asset('assets/img/hero/1/shape.svg') }}" alt="Decorative shape - Authentic Morocco Adventures">
  </div>

  <div class="container">
    <div class="row justify-center">
      <div class="col-12">
        <div class="pageHeader__content">
          <h1 class="pageHeader__title">
            Welcome to the Help Center
          </h1>

          <p class="pageHeader__text">
            Find answers to your questions and make the most of your journey with Authentic Morocco Adventures.
          </p>

          <div class="visually-hidden">
            <h2>Authentic Morocco Adventures - Help and Support Center</h2>
            <p>
              Explore Morocco with confidence. Authentic Morocco Adventures offers tailored travel experiences,
              guided tours, and support for travelers. Find information on bookings, payments, cancellations,
              and preparing for your Moroccan adventure.
            </p>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>

<section class="layout-pt-md">
  <div data-anim-wrap class="container">
    <div class="row y-gap-30">

      <div data-anim-child="slide-up delay-1" class="col-lg-4 col-md-6">
        <div class="px-50 py-45 border-1 rounded-12">
          <img src="{{ asset('assets/img/icons/6/1.svg') }}" alt="Booking your activity" class="mb-20">
          <h3 class="text-18 fw-500">Booking Your Activity</h3>
          <div class="mt-10">
            Book your Moroccan adventures directly through our website, or contact us for custom itineraries tailored to your interests.
          </div>
        </div>
      </div>

      <div data-anim-child="slide-up delay-2" class="col-lg-4 col-md-6">
        <div class="px-50 py-45 border-1 rounded-12">
          <img src="{{ asset('assets/img/icons/6/2.svg') }}" alt="Payment and receipts" class="mb-20">
          <h3 class="text-18 fw-500">Payment & Receipts</h3>
          <div class="mt-10">
            We accept payments via secure online platforms, bank transfer, or cash. Receipts are provided for all bookings.
          </div>
        </div>
      </div>

      <div data-anim-child="slide-up delay-3" class="col-lg-4 col-md-6">
        <div class="px-50 py-45 border-1 rounded-12">
          <img src="{{ asset('assets/img/icons/6/3.svg') }}" alt="Booking changes and refunds" class="mb-20">
          <h3 class="text-18 fw-500">Booking Changes & Refunds</h3>
          <div class="mt-10">
            Need to adjust your plans? Contact us at least 15 days before your tour for changes or cancellations with minimal fees.
          </div>
        </div>
      </div>

      <div data-anim-child="slide-up delay-4" class="col-lg-4 col-md-6">
        <div class="px-50 py-45 border-1 rounded-12">
          <img src="{{ asset('assets/img/icons/6/4.svg') }}" alt="Promo codes and credits" class="mb-20">
          <h3 class="text-18 fw-500">Promo Codes & Credits</h3>
          <div class="mt-10">
            Watch for exclusive offers on our website and social media. Apply promo codes at checkout for special discounts.
          </div>
        </div>
      </div>

      <div data-anim-child="slide-up delay-5" class="col-lg-4 col-md-6">
        <div class="px-50 py-45 border-1 rounded-12">
          <img src="{{ asset('assets/img/icons/6/5.svg') }}" alt="On the participation day" class="mb-20">
          <h3 class="text-18 fw-500">On the Participation Day</h3>
          <div class="mt-10">
            Please arrive on time and bring any required documents or tickets. Our guides will ensure you have an unforgettable experience.
          </div>
        </div>
      </div>

      <div data-anim-child="slide-up delay-6" class="col-lg-4 col-md-6">
        <div class="px-50 py-45 border-1 rounded-12">
          <img src="{{ asset('assets/img/icons/6/6.svg') }}" alt="Value packs" class="mb-20">
          <h3 class="text-18 fw-500">Value Packs</h3>
          <div class="mt-10">
            Save more with multi-day tour packages that combine Morocco’s top destinations and activities for a richer experience.
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<section class="layout-pt-xl layout-pb-xl">
  <div class="container">
    <div class="row justify-center text-center">
      <div class="col-auto">
        <h2 class="text-30 md:text-24">Frequently Asked Questions</h2>
      </div>
    </div>

    <div class="row justify-center pt-40">
      <div class="col-xl-8 col-lg-10">
        <div class="accordion -simple row y-gap-20 js-accordion" id="faqAccordion">

          <div class="col-12 faq-item">
            <div class="accordion__item px-20 py-15 border-1 rounded-12">
              <div class="accordion__button d-flex items-center justify-between">
                <div class="button text-16 text-dark-1">Can I get a refund if I cancel?</div>
                <div class="accordion__icon size-30 flex-center bg-light-2 rounded-full">
                  <i class="icon-plus"></i>
                  <i class="icon-minus"></i>
                </div>
              </div>
              <div class="accordion__content">
                <div class="pt-20">
                  <p>
                    Yes. Cancellations made at least 15 days before your tour start date receive a full refund minus any bank fees. Closer cancellations may incur partial fees. Please see our <a href="{{ route('front.terms') }}">Terms and Conditions</a>.
                  </p>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 faq-item">
            <div class="accordion__item px-20 py-15 border-1 rounded-12">
              <div class="accordion__button d-flex items-center justify-between">
                <div class="button text-16 text-dark-1">Can I change my travel dates?</div>
                <div class="accordion__icon size-30 flex-center bg-light-2 rounded-full">
                  <i class="icon-plus"></i>
                  <i class="icon-minus"></i>
                </div>
              </div>
              <div class="accordion__content">
                <div class="pt-20">
                  <p>
                    Yes, we’re flexible. Let us know as early as possible if your dates change. Additional fees may apply depending on availability and notice period.
                  </p>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 faq-item">
            <div class="accordion__item px-20 py-15 border-1 rounded-12">
              <div class="accordion__button d-flex items-center justify-between">
                <div class="button text-16 text-dark-1">Where do your tours start and end?</div>
                <div class="accordion__icon size-30 flex-center bg-light-2 rounded-full">
                  <i class="icon-plus"></i>
                  <i class="icon-minus"></i>
                </div>
              </div>
              <div class="accordion__content">
                <div class="pt-20">
                  <p>
                    Most tours start and end in Marrakech or your chosen city. We can also arrange custom pick-up and drop-off points upon request.
                  </p>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 faq-item">
            <div class="accordion__item px-20 py-15 border-1 rounded-12">
              <div class="accordion__button d-flex items-center justify-between">
                <div class="button text-16 text-dark-1">Do you arrange airport transfers?</div>
                <div class="accordion__icon size-30 flex-center bg-light-2 rounded-full">
                  <i class="icon-plus"></i>
                  <i class="icon-minus"></i>
                </div>
              </div>
              <div class="accordion__content">
                <div class="pt-20">
                  <p>
                    Absolutely! We’re happy to arrange airport transfers to and from your accommodation for a smooth start to your Moroccan adventure.
                  </p>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>

<style>
  .visually-hidden {
    position: absolute !important;
    width: 1px !important;
    height: 1px !important;
    padding: 0 !important;
    margin: -1px !important;
    overflow: hidden !important;
    clip: rect(0, 0, 0, 0) !important;
    white-space: nowrap !important;
    border: 0 !important;
  }
</style>

@endsection
