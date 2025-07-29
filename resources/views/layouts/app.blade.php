<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('template-bootstrap/') }}/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>@yield('title', 'Dashboard') - LSP Apotek</title>
    <meta name="description" content="" />
    
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
    <link rel="stylesheet" href="{{ asset('template-bootstrap/vendor/libs/apex-charts/apex-charts.css') }}" />
    
    <!-- Page CSS -->
    @yield('styles')
    
    <!-- Custom Sidebar CSS -->
    <style>
        /* Enhanced sidebar selected/active state - Modern style like in the image */
        .menu-item.active > .menu-link {
            background: #696cff !important;
            color: #ffffff !important;
            border-radius: 0.5rem;
            font-weight: 600;
            margin: 0.125rem 0.75rem;
            padding: 0.75rem 1rem;
            box-shadow: 0 2px 6px 0 rgba(105, 108, 255, 0.4);
            position: relative;
            transition: all 0.2s ease-in-out;
            display: flex;
            align-items: center;
        }
        
        .menu-item.active > .menu-link .menu-icon {
            color: #ffffff !important;
            margin-right: 0.75rem;
            flex-shrink: 0;
        }
        
        .menu-item.active > .menu-link .text-truncate {
            color: #ffffff !important;
            flex: 1;
        }
        
        /* Sub-menu active state */
        .menu-sub .menu-item.active > .menu-link {
            background: rgba(105, 108, 255, 0.12) !important;
            color: #696cff !important;
            border-radius: 0.375rem;
            margin: 0.125rem 0.5rem;
            padding: 0.5rem 0.75rem;
            font-weight: 500;
            position: relative;
            box-shadow: none;
            display: flex;
            align-items: center;
        }
        
        .menu-sub .menu-item.active > .menu-link::before {
            content: '';
            position: absolute;
            left: -0.5rem;
            top: 50%;
            transform: translateY(-50%);
            width: 0.25rem;
            height: 1.25rem;
            background: #696cff;
            border-radius: 0 0.125rem 0.125rem 0;
        }
        
        .menu-sub .menu-item.active > .menu-link .text-truncate {
            color: #696cff !important;
            flex: 1;
        }
        
        /* Hover effects */
        .menu-item:not(.active) > .menu-link:hover {
            background: rgba(105, 108, 255, 0.08);
            color: #696cff;
            border-radius: 0.5rem;
            margin: 0.125rem 0.75rem;
            padding: 0.75rem 1rem;
            transition: all 0.2s ease-in-out;
        }
        
        .menu-sub .menu-item:not(.active) > .menu-link:hover {
            background: rgba(105, 108, 255, 0.06);
            color: #696cff;
            border-radius: 0.375rem;
            margin: 0.125rem 0.5rem;
            padding: 0.5rem 0.75rem;
        }
        
        .menu-item:not(.active) > .menu-link:hover .menu-icon {
            color: #696cff;
        }
        
        /* Default menu link styling */
        .menu-item > .menu-link {
            margin: 0.125rem 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease-in-out;
            display: flex;
            align-items: center;
            text-decoration: none;
        }
        
        .menu-sub .menu-item > .menu-link {
            margin: 0.125rem 0.5rem;
            padding: 0.5rem 0.75rem;
            border-radius: 0.375rem;
            display: flex;
            align-items: center;
        }
        
        /* Icon spacing fix */
        .menu-icon.icon-base {
            font-size: 1.125rem;
            width: 1.375rem;
            height: 1.375rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.75rem;
            flex-shrink: 0;
        }
        
        /* Text container */
        .menu-link .text-truncate {
            flex: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        /* Menu headers spacing */
        .menu-header.mt-7 {
            margin-top: 1.75rem !important;
        }
        
        /* Menu toggle arrow for active items */
        .menu-item.active.open > .menu-link .menu-toggle::after {
            color: #ffffff !important;
        }
        
        /* Ensure proper spacing for menu items */
        .menu-inner {
            padding: 0.5rem 0;
        }
        
        /* Menu header styling */
        .menu-header {
            padding: 0.75rem 1.5rem 0.5rem;
        }
        
        /* Responsive behavior for collapsed sidebar */
        @media (max-width: 1199.98px) {
            .layout-menu-collapsed .menu-link .text-truncate {
                display: none;
            }
            
            .layout-menu-collapsed .menu-icon.icon-base {
                margin-right: 0;
                justify-content: center;
            }
            
            .layout-menu-collapsed .menu-header {
                display: none;
            }
            
            .layout-menu-collapsed .menu-item > .menu-link {
                justify-content: center;
                padding: 0.75rem;
                margin: 0.125rem 0.5rem;
            }
            
            .layout-menu-collapsed .menu-sub {
                display: none;
            }
        }
        
        /* Mobile responsive */
        @media (max-width: 767.98px) {
            .layout-menu {
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
            }
            
            .layout-menu.show {
                transform: translateX(0);
            }
        }
        
        /* Ensure menu toggle works properly */
        .layout-menu-toggle {
            cursor: pointer;
        }
        
        /* Fix for menu toggle icon alignment */
        .layout-menu-toggle i {
            transition: transform 0.3s ease;
        }
        
        .layout-menu-collapsed .layout-menu-toggle i {
            transform: rotate(180deg);
        }
    </style>
    
    <!-- Helpers -->
    <script src="{{ asset('template-bootstrap/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('template-bootstrap/js/config.js') }}"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="{{ route('dashboard') }}" class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <svg width="25" viewBox="0 0 25 42" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                <defs>
                                    <path d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z">
                                    </path>
                                </defs>
                                <g>
                                    <use fill="#8c57ff" xlink:href="#path-1"></use>
                                    <use fill-opacity="0.2" fill="#8c57ff" xlink:href="#path-1"></use>
                                </g>
                            </svg>
                        </span>
                        <span class="app-brand-text demo menu-text fw-bold ms-2">LSP Apotek</span>
                    </a>
                    
                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm d-flex align-items-center justify-content-center"></i>
                    </a>
                </div>
                
                <div class="menu-inner-shadow"></div>
                
                <ul class="menu-inner py-1">
                    <!-- Dashboard -->
                    <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}" class="menu-link">
                            <i class="menu-icon icon-base ri ri-home-smile-line"></i>
                            <div class="text-truncate" data-i18n="Dashboard">Dashboard</div>
                        </a>
                    </li>
                    
                    <!-- Inventory Management -->
                    <li class="menu-header small text-uppercase mt-7">
                        <span class="menu-header-text">Inventory Management</span>
                    </li>
                    
                    <li class="menu-item {{ request()->routeIs('admin.drugs.*') ? 'active open' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon icon-base ri ri-capsule-line"></i>
                            <div class="text-truncate" data-i18n="Drug Management">Drug Management</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item {{ request()->routeIs('admin.drugs.index') ? 'active' : '' }}">
                                <a href="{{ route('admin.drugs.index') }}" class="menu-link">
                                    <div class="text-truncate" data-i18n="All Drugs">All Drugs</div>
                                </a>
                            </li>
                            <li class="menu-item {{ request()->routeIs('admin.drugs.create') ? 'active' : '' }}">
                                <a href="{{ route('admin.drugs.create') }}" class="menu-link">
                                    <div class="text-truncate" data-i18n="Create Drug">Create Drug</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <li class="menu-item {{ request()->routeIs('admin.supplier.*') ? 'active open' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon icon-base ri ri-building-2-line"></i>
                            <div class="text-truncate" data-i18n="Supplier Management">Supplier Management</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item {{ request()->routeIs('admin.supplier.index') ? 'active' : '' }}">
                                <a href="#" class="menu-link">
                                    <div class="text-truncate" data-i18n="All Suppliers">All Suppliers</div>
                                </a>
                            </li>
                            <li class="menu-item {{ request()->routeIs('admin.supplier.create') ? 'active' : '' }}">
                                <a href="#" class="menu-link">
                                    <div class="text-truncate" data-i18n="Add Supplier">Add Supplier</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <i class="menu-icon icon-base ri ri-alarm-warning-line"></i>
                            <div class="text-truncate" data-i18n="Expiry Alerts">Expiry Alerts</div>
                        </a>
                    </li>
                    
                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <i class="menu-icon icon-base ri ri-bar-chart-box-line"></i>
                            <div class="text-truncate" data-i18n="Stock Levels">Stock Levels</div>
                        </a>
                    </li>
                    
                    <!-- Transaction Management -->
                    <li class="menu-header small text-uppercase mt-7">
                        <span class="menu-header-text">Transaction Management</span>
                    </li>
                    
                    <li class="menu-item {{ request()->routeIs('admin.penjualan.*') ? 'active open' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon icon-base ri ri-shopping-cart-line"></i>
                            <div class="text-truncate" data-i18n="Sales Management">Sales Management</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item {{ request()->routeIs('admin.penjualan.index') ? 'active' : '' }}">
                                <a href="#" class="menu-link">
                                    <div class="text-truncate" data-i18n="All Sales">All Sales</div>
                                </a>
                            </li>
                            <li class="menu-item {{ request()->routeIs('admin.penjualan.create') ? 'active' : '' }}">
                                <a href="#" class="menu-link">
                                    <div class="text-truncate" data-i18n="New Sale">New Sale</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <li class="menu-item {{ request()->routeIs('admin.pembelian.*') ? 'active open' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon icon-base ri ri-shopping-bag-3-line"></i>
                            <div class="text-truncate" data-i18n="Purchase Management">Purchase Management</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item {{ request()->routeIs('admin.pembelian.index') ? 'active' : '' }}">
                                <a href="#" class="menu-link">
                                    <div class="text-truncate" data-i18n="All Purchases">All Purchases</div>
                                </a>
                            </li>
                            <li class="menu-item {{ request()->routeIs('admin.pembelian.create') ? 'active' : '' }}">
                                <a href="#" class="menu-link">
                                    <div class="text-truncate" data-i18n="New Purchase">New Purchase</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- User Management -->
                    <li class="menu-header small text-uppercase mt-7">
                        <span class="menu-header-text">User Management</span>
                    </li>
                    
                    <li class="menu-item {{ request()->routeIs('admin.users.*') ? 'active open' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon icon-base ri ri-group-line"></i>
                            <div class="text-truncate" data-i18n="Users">Users</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                                <a href="#" class="menu-link">
                                    <div class="text-truncate" data-i18n="All Users">All Users</div>
                                </a>
                            </li>
                            <li class="menu-item {{ request()->routeIs('admin.users.apoteker') ? 'active' : '' }}">
                                <a href="#" class="menu-link">
                                    <div class="text-truncate" data-i18n="Pharmacists">Pharmacists</div>
                                </a>
                            </li>
                            <li class="menu-item {{ request()->routeIs('admin.users.pelanggan') ? 'active' : '' }}">
                                <a href="#" class="menu-link">
                                    <div class="text-truncate" data-i18n="Customers">Customers</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Reports & Analytics -->
                    <li class="menu-header small text-uppercase mt-7">
                        <span class="menu-header-text">Reports & Analytics</span>
                    </li>
                    
                    <li class="menu-item {{ request()->routeIs('admin.reports.*') ? 'active open' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon icon-base ri ri-bar-chart-2-line"></i>
                            <div class="text-truncate" data-i18n="Reports">Reports</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item {{ request()->routeIs('admin.reports.sales') ? 'active' : '' }}">
                                <a href="#" class="menu-link">
                                    <div class="text-truncate" data-i18n="Sales Report">Sales Report</div>
                                </a>
                            </li>
                            <li class="menu-item {{ request()->routeIs('admin.reports.inventory') ? 'active' : '' }}">
                                <a href="#" class="menu-link">
                                    <div class="text-truncate" data-i18n="Inventory Report">Inventory Report</div>
                                </a>
                            </li>
                            <li class="menu-item {{ request()->routeIs('admin.reports.financial') ? 'active' : '' }}">
                                <a href="#" class="menu-link">
                                    <div class="text-truncate" data-i18n="Financial Report">Financial Report</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Account -->
                    <li class="menu-header small text-uppercase mt-7">
                        <span class="menu-header-text">Account</span>
                    </li>
                    
                    <li class="menu-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                        <a href="#" class="menu-link">
                            <i class="menu-icon icon-base ri ri-settings-3-line"></i>
                            <div class="text-truncate" data-i18n="Profile Settings">Profile Settings</div>
                        </a>
                    </li>
                    
                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <i class="menu-icon icon-base ri ri-customer-service-2-line"></i>
                            <div class="text-truncate" data-i18n="Help & Support">Help & Support</div>
                        </a>
                    </li>
                </ul>
            </aside>
            <!-- / Menu -->
            
            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                            <i class="bx bx-menu bx-md"></i>
                        </a>
                    </div>
                    
                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <!-- Search -->
                        <div class="navbar-nav align-items-center">
                            <div class="nav-item d-flex align-items-center">
                                <i class="bx bx-search bx-md"></i>
                                <input type="text" class="form-control border-0 shadow-none ps-1 ps-sm-2" placeholder="Search..." aria-label="Search..." />
                            </div>
                        </div>
                        <!-- /Search -->
                        
                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="{{ asset('template-bootstrap/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="{{ asset('template-bootstrap/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">Admin</h6>
                                                    <small class="text-muted">Administrator</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider my-1"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="bx bx-user bx-md me-3"></i><span>My Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="bx bx-cog bx-md me-3"></i><span>Settings</span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider my-1"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="bx bx-power-off bx-md me-3"></i><span>Log Out</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
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
                                <div class="text-body">
                                    © {{ date('Y') }}, made with ❤️ by <a href="#" target="_blank" class="footer-link">LSP Apotek</a>
                                </div>
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->
                    
                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>
        
        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->
    
    <!-- Core JS -->
    <script src="{{ asset('template-bootstrap/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('template-bootstrap/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('template-bootstrap/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('template-bootstrap/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('template-bootstrap/vendor/js/menu.js') }}"></script>
    
    <!-- Vendors JS -->
    <script src="{{ asset('template-bootstrap/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    
    <!-- Main JS -->
    <script src="{{ asset('template-bootstrap/js/main.js') }}"></script>
    
    <!-- Page JS -->
    @yield('scripts')
</body>
</html>