@extends('front.layouts.app2')

@section('title', 'Contact Us | Authentic Morocco Adventures')

@push('styles')
<link
  rel="stylesheet"
  href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
/>
@endpush

@section('content')

<div data-anim="fade" class="map relative mt-header ml-60 mr-60 md:ml-0 md:mr-0">
  <div class="map__content rounded-12 md:rounded-0 js-map-single" style="overflow: hidden;">
    <iframe
      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d108703.09881241457!2d-8.007853099999998!3d31.634621449999997!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xdafee8d96179e51%3A0x5950b6534f87adb8!2sMarrakesh!5e0!3m2!1sen!2sma!4v1752535473627!5m2!1sen!2sma"
      width="100%"
      height="600"
      style="border:0; border-radius: 12px;"
      allowfullscreen=""
      loading="lazy"
      referrerpolicy="no-referrer-when-downgrade"
    ></iframe>
  </div>

  <div class="map__shape">
    <svg width="1800" height="40" viewBox="0 0 1800 40" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path
        d="M0 25.747C0 25.747 46.3491 19.4287 88.8889 18.9879C132.063 18.5471 168.889 18.9879 221.587 21.1919C293.333 24.1307 431.746 36.0327 505.397 29.5674C579.048 23.1021 582.222 22.8083 619.683 18.694C661.587 13.992 746.667 4.58795 852.063 5.02877C964.444 5.46958 1168.25 29.4205 1252.06 28.245C1260.95 28.098 1293.97 27.0695 1318.73 25.3062C1342.86 23.5429 1378.41 19.7226 1426.67 18.4001C1446.98 17.8124 1479.37 16.7838 1516.83 17.0777C1526.35 17.2246 1556.83 17.6654 1593.02 19.4287C1629.21 21.1919 1662.86 23.9838 1693.33 24.8654C1758.73 26.4817 1800 24.1307 1800 24.1307V40H0V25.747Z"
        fill="white" />
    </svg>
  </div>
</div>


<section class="layout-pt-lg">
    <div class="container">
        <div class="row y-gap-30 justify-center">

            <div class="col-lg-4 col-md-6">
                <div class="px-30 text-center">
                    <h3 class="text-30 md:text-24 fw-700">Contact Details</h3>

                    <div class="mt-20 md:mt-10 text-16">
                        <p class="mb-10">
                            <strong>Phone:</strong><br>
                            <a href="tel:+212666107312">+212 666 107 312</a>
                        </p>
                        <p class="mb-10">
                            <strong>WhatsApp:</strong><br>
                            <a href="https://wa.me/212666107312" target="_blank">+212 666 107 312</a>
                        </p>
                        <p class="mb-10">
                            <strong>Email:</strong><br>
                            <a href="mailto:authenticmoroccoadventures@gmail.com">authenticmoroccoadventures@gmail.com</a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="px-30 text-center">
                    <h3 class="text-30 md:text-24 fw-700">Business Info</h3>

                    <div class="mt-20 md:mt-10 text-16">
                        <p class="mb-10">
                            <strong>Website:</strong><br>
                            <a href="https://www.authenticmoroccoadventures.com" target="_blank">
                                www.authenticmoroccoadventures.com
                            </a>
                        </p>
                        <p class="mb-10">
                            <strong>Address:</strong><br>
                            40 000 Marrakech, Morocco
                        </p>
                        <p class="mb-10">
                            <strong>Travelling with Children:</strong><br>
                            I offer special discounts for families traveling with kids. Contact me for details!
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12">
                <div class="px-30 text-center">
                    <h3 class="text-30 md:text-24 fw-700">Reservations & Payment</h3>

                    <div class="mt-20 md:mt-10 text-16">
                        <p class="mb-10">
                            <strong>Reservations:</strong><br>
                            You can reserve via phone, WhatsApp, email, or the contact form.
                        </p>
                        <p class="mb-10">
                            <strong>Deposit Payment:</strong><br>
                            For multi-day tours in Morocco, a 20% deposit is required. I accept PayPal, bank transfers
                            in Morocco, and Western Union payments.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<section data-anim="fade" class="layout-pt-lg layout-pb-lg">
    <div class="container">
        <div class="row justify-center">
            <div class="col-lg-8">
                <h2 class="text-30 fw-700 text-center mb-30">Leave us your info</h2>

                <div class="contactForm">
                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf

                        <div class="row y-gap-30">
                            <div class="col-md-6">
                                <input type="text" name="name" placeholder="Name" value="{{ old('name') }}"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="phone" placeholder="Phone" value="{{ old('phone') }}">
                            </div>
                            <div class="col-12">
                                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}"
                                    required>
                            </div>
                            <div class="col-12">
                                <textarea name="message" placeholder="Message" rows="6" required>{{ old('message') }}</textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="button -md -dark-1 bg-accent-1 text-white col-12">
                                    Send Message
                                </button>
                            </div>

                            @if (session('success'))
                                <div class="col-12 mt-20">
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="col-12 mt-20">
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="col-12 mt-20">
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif

                            @push('scripts')
                                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                <script>
                                    @if (session('success'))
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Message Sent!',
                                            text: @json(session('success')),
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
                            @endpush
                        </div>
                    </form>
                </div>

                <div class="visually-hidden">
                    <p>
                        Contact Authentic Morocco Adventures for tailor-made travel experiences in Morocco including desert
                        tours, cultural adventures, and custom itineraries. Reach out with your questions or special
                        requests today.
                    </p>
                </div>

            </div>
        </div>
    </div>
</section>

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    var map = L.map('map-canvas').setView([31.6256934, -7.9368677], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution:
        '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker([31.6256934, -7.9368677])
      .addTo(map)
      .bindPopup('Marrakesh 40000')
      .openPopup();
  });
</script>
@endpush

@endsection
