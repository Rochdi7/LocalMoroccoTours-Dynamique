@extends('front.layouts.app2')

@section('title', 'Contact Us | Authentic Morocco Adventures')

@section('content')

<section data-anim="fade" class="pageHeader -type-1">
    <div class="pageHeader__bg">
        <figure style="margin: 0; width: 100%; height: 100%;">
            <img src="{{ asset('assets/images/hero/contact-authentic-morocco-adventures-marrakech.webp') }}"
                alt="Intricately carved stucco and zellige tilework on the walls of a historic Marrakech madrasa, Morocco"
                title="Ornate Moroccan craftsmanship inside a historic Marrakech madrasa." loading="eager"
                width="1280" height="966"
                style="object-fit: cover; object-position: center center; width: 100%; height: 100%; display: block;">
            <figcaption class="visually-hidden">
                Hand-carved stucco arches and detailed zellige mosaics line the walls of a centuries-old
                Marrakech madrasa — a glimpse of the authentic Moroccan heritage the Authentic Morocco
                Adventures team loves to share with travellers who reach out.
            </figcaption>
        </figure>
        <img src="{{ asset('assets/img/hero/1/shape.svg') }}" alt="Decorative shape">
    </div>

    <div class="container">
        <div class="row justify-center">
            <div class="col-12">
                <div class="pageHeader__content text-center">
                    <h1 class="pageHeader__title">
                        Contact Authentic Morocco Adventures
                    </h1>

                    <p class="pageHeader__text">
                        Have a question or ready to plan your Moroccan adventure? Reach out to our local
                        team — we'd love to help you craft the perfect trip.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>


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

                            @if (session('contact_success'))
                                <div class="col-12 mt-20">
                                    <div class="alert alert-success">
                                        {{ session('contact_success') }}
                                    </div>
                                </div>
                            @endif

                            @if (session('contact_error'))
                                <div class="col-12 mt-20">
                                    <div class="alert alert-danger">
                                        {{ session('contact_error') }}
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
                                    @if (session('contact_success'))
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Message Sent!',
                                            text: @json(session('contact_success')),
                                            confirmButtonColor: '#3085d6',
                                        });
                                    @endif

                                    @if (session('contact_error'))
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Something went wrong!',
                                            text: @json(session('contact_error')),
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

@endsection
