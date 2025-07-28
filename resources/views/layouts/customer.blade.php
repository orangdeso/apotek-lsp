<!DOCTYPE html>
<html lang="en" class="light-style layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('template-bootstrap/') }}/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>@yield('title', 'LSP Apotek')</title>
    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('template-bootstrap/img/favicon/favicon.ico') }}" />
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    
    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('template-bootstrap/vendor/fonts/iconify-icons.css') }}" />
    
    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('template-bootstrap/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('template-bootstrap/css/demo.css') }}" />
    
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('template-bootstrap/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    
    @yield('styles')
    
    <!-- Helpers -->
    <script src="{{ asset('template-bootstrap/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('template-bootstrap/js/config.js') }}"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar layout-without-menu">
        <div class="layout-container">
            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <nav class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme shadow-sm" id="layout-navbar">
                    <div class="container-fluid">
                        <!-- Brand -->
                        <a class="navbar-brand">
                            <span class="text-primary fw-bold fs-4">LSP Apotek</span>
                        </a>
                        
                        <!-- Right side buttons -->
                        <div class="navbar-nav flex-row align-items-center ms-auto">
                            @auth
                                <!-- Cart Icon -->
                                <a href="{{ route('customer.cart.view') }}" class="nav-link me-3 position-relative">
                                    <i class="ri ri-shopping-cart-line icon-lg"></i>
                                    <span class="badge bg-primary rounded-pill position-absolute top-0 start-100 translate-middle" id="cart-count">0</span>
                                </a>
                            @endauth
                            @guest
                                <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Sign In</a>
                                <a href="{{ route('register') }}" class="btn btn-primary">Sign Up</a>
                            @else
                                <!-- User dropdown -->
                                <div class="nav-item navbar-dropdown dropdown-user dropdown">
                                    <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                                        <div class="avatar avatar-online">
                                            <img src="{{ asset('template-bootstrap/img/avatars/1.png') }}" alt="User" class="rounded-circle" />
                                        </div>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar avatar-online">
                                                            <img src="{{ asset('template-bootstrap/img/avatars/1.png') }}" alt="User" class="w-px-40 h-auto rounded-circle" />
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                                                        <small class="text-body-secondary">Customer</small>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li><div class="dropdown-divider my-1"></div></li>
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="icon-base ri ri-user-line icon-md me-3"></i>
                                                <span>My Profile</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('customer.addresses.index') }}">
                                                <i class="icon-base ri ri-map-pin-line icon-md me-3"></i>
                                                <span>My Addresses</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="icon-base ri ri-shopping-cart-line icon-md me-3"></i>
                                                <span>My Orders</span>
                                            </a>
                                        </li>
                                        <li><div class="dropdown-divider my-1"></div></li>
                                        <li>
                                            <div class="d-grid px-4 pt-2 pb-1">
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger d-flex w-100">
                                                        <small class="align-middle">Logout</small>
                                                        <i class="ri ri-logout-box-r-line ms-2 ri-xs"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            @endguest
                        </div>
                    </div>
                </nav>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        @yield('content')
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl">
                            <div class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                                <div class="mb-2 mb-md-0">
                                    ©
                                    <script>document.write(new Date().getFullYear());</script>
                                    LSP Apotek - Online Pharmacy Platform
                                </div>
                                <div class="d-none d-lg-inline-block">
                                    <a href="#" class="footer-link me-4">Privacy Policy</a>
                                    <a href="#" class="footer-link me-4">Terms of Service</a>
                                    <a href="#" class="footer-link">Contact Us</a>
                                </div>
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->
                </div>
                <!-- / Content wrapper -->
            </div>
            <!-- / Layout container -->
        </div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <script src="{{ asset('template-bootstrap/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('template-bootstrap/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('template-bootstrap/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('template-bootstrap/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('template-bootstrap/js/main.js') }}"></script>
    
    @yield('scripts')
</body>
</html>