<!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ route('admin.dashboard') }}" class="b-brand text-primary">
                <!-- ========   Change your logo from here   ============ -->
                <img src="{{ asset('assets/images/logo/' . (env('APP_DARK_LAYOUT') == 'true' ? 'ama_logo_white.png' : 'ama_logo_dark.png')) }}"
                    alt="logo image" class="logo-lg" style="height:36px;width:auto;max-width:180px;object-fit:contain;">
                <span class="badge bg-brand-color-2 rounded-pill ms-1 theme-version">v1.2.0</span>
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                @include('layouts.menu-list')
            </ul>
            <div class="card nav-action-card bg-brand-color-4">
                <div class="card-body" style="background-image: url('/build/images/layout/nav-card-bg.svg')">
                    <h5 class="text-dark">Help Center</h5>
                    <p class="text-dark text-opacity-75">Please contact us for more questions.</p>
                    <a href="https://codesommet.com/" class="btn btn-primary" target="_blank">Go to help
                        Center</a>
                </div>
            </div>
        </div>
        <div class="card pc-user-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    @php
                        $auth = auth()->user();
                        $profilePhoto =
                            $auth && $auth->photo && file_exists(public_path('storage/' . $auth->photo))
                                ? asset('storage/' . $auth->photo)
                                : 'data:image/svg+xml,' .
                                    rawurlencode(
                                        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><rect width="100" height="100" fill="#e9ecef"/><circle cx="50" cy="38" r="18" fill="#adb5bd"/><path d="M50 62c-22 0-34 12-34 26v6h68v-6c0-14-12-26-34-26z" fill="#adb5bd"/></svg>',
                                    );
                    @endphp

                    <div class="flex-shrink-0">
                        <img src="{{ $profilePhoto }}" alt="user-image" class="user-avtar wid-45 rounded-circle" />
                    </div>

                    <div class="flex-grow-1 ms-3">
                        <div class="dropdown">
                            <a href="#" class="arrow-none dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false" data-bs-offset="0,20">
                                <div class="d-flex align-items-center">
                                    @php
                                        $auth = auth()->user();
                                    @endphp

                                    <div class="flex-grow-1 me-2">
                                        <h6 class="mb-0">{{ $auth->name ?? 'Guest' }}</h6>
                                        <small>{{ ucfirst($auth->getRoleNames()->first() ?? 'User') }}</small>
                                    </div>

                                    <div class="flex-shrink-0">
                                        <div class="btn btn-icon btn-link-secondary avtar">
                                            <i class="ph-duotone ph-windows-logo"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu">
                                <ul>
                                    <li>
                                        <a href="{{ route('profile.index') }}" class="pc-user-links">
                                            <i class="ph-duotone ph-user"></i>
                                            <span>My Account</span>
                                        </a>
                                    </li>


                                    <li><a class="pc-user-links" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();">
                                            <i class="ph-duotone ph-power"></i>
                                            <span>Logout</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
<!-- [ Sidebar Menu ] end -->
