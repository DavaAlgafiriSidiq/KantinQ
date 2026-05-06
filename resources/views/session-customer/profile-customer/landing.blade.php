<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Profil Customer | FoodwaGon</title>

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets-landing/img/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets-landing/img/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets-landing/img/favicons/favicon-16x16.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets-landing/img/favicons/favicon.ico') }}">

    <link href="{{ asset('assets-landing/css/theme.css') }}" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        /* Menyesuaikan padding agar konten profil tidak tertutup navbar fixed */
        .profile-container {
            padding-top: 100px;
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        .text-gradient {
            background: linear-gradient(90deg, #FFB30E 0%, #FF8A00 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>

<body>
    <main class="main" id="top">
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow-sm">
            <div class="container">
                <a class="navbar-brand d-inline-flex" href="/">
                    <img class="d-inline-block" src="{{ asset('assets-landing/img/gallery/logo.svg') }}" alt="logo" />
                    <span class="text-1000 fs-3 fw-bold ms-2 text-gradient">foodwaGon</span>
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <div class="ms-auto d-flex align-items-center mt-3 mt-lg-0">
                        {{-- Dropdown Profile --}}
                        <div class="dropdown">
                            <button class="btn btn-white shadow-warning text-warning dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-2"></i>
                                <span>{{ Auth::user()->name }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2 mt-2">
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('profil-customer.index') }}">
                                        <i class="fas fa-user-circle me-2 text-warning"></i>My Profile
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item py-2 text-danger">
                                            <i class="fas fa-power-off me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div class="profile-container">
            @yield('content')
        </div>
    </main>

    <script src="{{ asset('assets-landing/vendors/@popperjs/popper.min.js') }}"></script>
    <script src="{{ asset('assets-landing/vendors/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets-landing/vendors/is/is.min.js') }}"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="{{ asset('assets-landing/vendors/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('assets-landing/assets/js/theme.js') }}"></script>
</body>

</html>