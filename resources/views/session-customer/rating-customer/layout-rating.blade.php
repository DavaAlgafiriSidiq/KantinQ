<!DOCTYPE html>
<html
    lang="en"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="{{ asset('assets/') }}/"
    data-template="vertical-menu-template-free"
>
<head>
    <meta charset="utf-8" />

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no,
        minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>KantinQ Dashboard</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link
        rel="icon"
        type="image/x-icon"
        href="{{ asset('assets/img/favicon/favicon.ico') }}"
    />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link
        rel="stylesheet"
        href="{{ asset('assets/vendor/css/core.css') }}"
        class="template-customizer-core-css"
    />

    <link
        rel="stylesheet"
        href="{{ asset('assets/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css"
    />

    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link
        rel="stylesheet"
        href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}"
    />

    <link
        rel="stylesheet"
        href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}"
    />

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>

    <!-- Config -->
    <script src="{{ asset('assets/js/config.js') }}"></script>
</head>

<body>

    <!-- Layout Wrapper -->
    <div class="layout-wrapper layout-content-navbar">

        <div class="layout-container">

            <!-- Sidebar -->
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

                <!-- Logo -->
                <div class="app-brand demo">

                    <a href="{{ route('master') }}" class="app-brand-link">

                        <span class="app-brand-logo demo">
                            <svg
                                width="25"
                                viewBox="0 0 25 42"
                                version="1.1"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    fill="#696cff"
                                    d="M13.79 0.35L3.39 7.44C0.56 9.69 -0.37 12.47 0.55 15.79C0.68 16.23 1.09 17.78 3.12 19.22C3.81 19.72 5.32 20.38 7.65 21.21L2.63 24.54C0.44 26.30 0.08 28.50 1.56 31.17C2.83 32.81 5.20 33.26 7.09 32.53C8.34 32.05 11.45 30.00 16.41 26.37C18.03 24.49 18.69 22.45 18.40 20.23C17.96 17.53 16.17 15.57 13.04 14.37L10.91 13.47L18.61 7.98L13.79 0.35Z"
                                />
                            </svg>
                        </span>

                        <span class="app-brand-text demo menu-text fw-bolder ms-2">
                            KantinQ
                        </span>

                    </a>

                    <a
                        href="javascript:void(0);"
                        class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none"
                    >
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>

                </div>

                <div class="menu-inner-shadow"></div>

                <!-- Menu -->
                <ul class="menu-inner py-1">

                    <!-- Dashboard -->
                    <li class="menu-item {{ Request::routeIs('master') ? 'active' : '' }}">
                        <a href="{{ route('master') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div>Dashboard</div>
                        </a>
                    </li>


                    <!-- Produk -->
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Data</span>
                    </li>

                    <li class="menu-item {{ Request::is('seller-produk*') ? 'active' : '' }}">
                        <a href="/seller-produk" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-collection"></i>
                            <div>Data Produk</div>
                        </a>
                    </li>

                </ul>
                <!-- End Menu -->

            </aside>
            <!-- End Sidebar -->

            <!-- Layout Page -->
            <div class="layout-page">

                <!-- Navbar -->
                <nav
                    class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar"
                >

                    <!-- Toggle -->
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">

                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>

                    </div>

                    <!-- Navbar Right -->
                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

                        <ul class="navbar-nav flex-row align-items-center ms-auto">

                            <!-- User Dropdown -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">

                                <a
                                    class="nav-link dropdown-toggle hide-arrow"
                                    href="javascript:void(0);"
                                    data-bs-toggle="dropdown"
                                >
                                    <div class="avatar avatar-online">
                                        <img
                                            src="{{ asset('assets/img/avatars/1.png') }}"
                                            alt="Avatar"
                                            class="w-px-40 h-auto rounded-circle"
                                        />
                                    </div>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end">

                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img
                                                            src="{{ asset('assets/img/avatars/1.png') }}"
                                                            alt="Avatar"
                                                            class="w-px-40 h-auto rounded-circle"
                                                        />
                                                    </div>
                                                </div>

                                                <div class="flex-grow-1">
                                                    <span class="fw-semibold d-block">
                                                        Seller
                                                    </span>

                                                    <small class="text-muted">
                                                        Admin
                                                    </small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>

                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="bx bx-user me-2"></i>
                                            <span class="align-middle">My Profile</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="bx bx-cog me-2"></i>
                                            <span class="align-middle">Settings</span>
                                        </a>
                                    </li>

                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="bx bx-power-off me-2"></i>
                                            <span class="align-middle">Logout</span>
                                        </a>
                                    </li>

                                </ul>

                            </li>
                            <!-- End User Dropdown -->

                        </ul>

                    </div>
                    <!-- End Navbar Right -->

                </nav>
                <!-- End Navbar -->

                <!-- Content Wrapper -->
                <div class="content-wrapper">

                    <!-- Content -->
                    @yield('content')
                    <!-- End Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">

                        <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">

                            <div class="mb-2 mb-md-0">
                                © KantinQ -
                                <script>
                                    document.write(new Date().getFullYear());
                                </script>
                            </div>

                        </div>

                    </footer>
                    <!-- End Footer -->

                    <div class="content-backdrop fade"></div>

                </div>
                <!-- End Content Wrapper -->

            </div>
            <!-- End Layout Page -->

        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

    </div>
    <!-- End Layout Wrapper -->

    <!-- Core JS -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>

    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>

</body>
</html>