@extends('front.layouts.app2')

@section('title', 'Terms and Conditions - Authentic Morocco Adventures')

@push('meta')
    <meta name="description" content="Review the terms and conditions for booking unforgettable Moroccan tours with Authentic Morocco Adventures. Discover our policies on payments, cancellations, privacy, and guest responsibilities.">
@endpush

@section('content')

<section data-anim="fade" class="mt-header pt-30">
  <div class="container">
    <div class="breadcrumbs mb-30 md:mb-15">
      <span class="breadcrumbs__item">
        <a href="{{ route('home') }}">Home</a>
      </span>
      <span>></span>
      <span class="breadcrumbs__item">
        <span>Terms and Conditions</span>
      </span>
    </div>

    <h1 class="text-30">Terms and Conditions</h1>

    {{-- Visually hidden SEO content --}}
    <div class="visually-hidden">
      <h2>Authentic Morocco Adventures - Morocco’s Authentic Guided Experiences</h2>
      <p>
        Authentic Morocco Adventures offers expertly guided experiences across Morocco, including desert excursions,
        cultural city tours in Marrakech and Fes, trekking adventures in the Atlas Mountains, and personalized
        itineraries. As your local guide, we’re committed to creating unforgettable journeys that showcase the
        beauty and heritage of Morocco. Contact us to plan your private tour, group travel, or special events.
      </p>
    </div>

  </div>
</section>

<section data-anim="slide-up delay-2" class="layout-pt-md layout-pb-lg">
  <div class="container">
    <div class="tabs -terms js-tabs">
      <div class="row y-gap-30">
        <div class="col-lg-3">
          <div class="tabs__controls row y-gap-10 js-tabs-controls">
            <div class="col-12">
              <button class="tabs__button relative pl-20 js-tabs-button is-tab-el-active" data-tab-target=".-tab-item-1">
                Booking & Payments
              </button>
            </div>
            <div class="col-12">
              <button class="tabs__button relative pl-20 js-tabs-button" data-tab-target=".-tab-item-2">
                Cancellations & Refunds
              </button>
            </div>
            <div class="col-12">
              <button class="tabs__button relative pl-20 js-tabs-button" data-tab-target=".-tab-item-3">
                Responsibilities & Risks
              </button>
            </div>
            <div class="col-12">
              <button class="tabs__button relative pl-20 js-tabs-button" data-tab-target=".-tab-item-4">
                Privacy Policy
              </button>
            </div>
            <div class="col-12">
              <button class="tabs__button relative pl-20 js-tabs-button" data-tab-target=".-tab-item-5">
                Other Terms
              </button>
            </div>
          </div>
        </div>

        <div class="col-lg-9">
          <div class="tabs__content js-tabs-content">

            {{-- Tab 1 --}}
            <div class="tabs__pane -tab-item-1 is-tab-el-active">
              <h2 class="text-20 fw-500">Booking & Payments</h2>
              <p class="mt-10">
                All bookings with Authentic Morocco Adventures are subject to availability. A deposit or full payment may be required at the time of booking, depending on the type of tour. Prices are quoted in Moroccan Dirhams (MAD) unless otherwise stated. Payment methods include cash, bank transfer, or secure online payment platforms. Your reservation is confirmed only after receipt of the required payment.
              </p>
            </div>

            {{-- Tab 2 --}}
            <div class="tabs__pane -tab-item-2">
              <h2 class="text-20 fw-500">Cancellations & Refunds</h2>
              <p class="mt-10">
                Cancellations made at least 15 days before the tour start date will receive a full refund minus any bank charges. Cancellations between 7 and 14 days prior are subject to a 50% cancellation fee. No refunds are provided for cancellations within 7 days of the tour start date or for no-shows. In case of force majeure, we will assess refunds on a case-by-case basis.
              </p>
            </div>

            {{-- Tab 3 --}}
            <div class="tabs__pane -tab-item-3">
              <h2 class="text-20 fw-500">Responsibilities & Risks</h2>
              <p class="mt-10">
                As a guest of Authentic Morocco Adventures, you acknowledge that travel involves certain risks, including but not limited to injury, illness, theft, or unforeseen changes due to weather, road conditions, or other factors. Authentic Morocco Adventures and its guides will do their utmost to ensure your safety and comfort, but cannot be held liable for circumstances beyond our control. Guests are responsible for personal travel insurance covering medical, accident, and trip interruption.
              </p>
            </div>

            {{-- Tab 4 --}}
            <div class="tabs__pane -tab-item-4">
              <h2 class="text-20 fw-500">Privacy Policy</h2>
              <p class="mt-10">
                Authentic Morocco Adventures values your privacy. We collect only the personal data necessary to process bookings and communicate with clients. Your information will never be sold or shared with third parties except where required by law. By using our services, you consent to our privacy practices as outlined here.
              </p>
            </div>

            {{-- Tab 5 --}}
            <div class="tabs__pane -tab-item-5">
              <h2 class="text-20 fw-500">Other Terms</h2>
              <p class="mt-10">
                All content on our website, including images, text, and branding, is the property of Authentic Morocco Adventures and protected by copyright laws. Any disputes arising from these terms shall be governed by Moroccan law. For questions or concerns, please contact us at <a href="mailto:info@authenticmoroccoadventures.com">info@authenticmoroccoadventures.com</a>.
              </p>
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
