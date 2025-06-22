<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Panel</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <!-- Bootstrap Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
                <img src="{{ asset('logo.webp') }}" alt="Logo" height="40">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex align-items-center gap-2">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="blob-btn nav-link p-0">
                            Dashboard
                            <span class="blob-btn__inner">
                                <span class="blob-btn__blobs">
                                    <span class="blob-btn__blob"></span>
                                    <span class="blob-btn__blob"></span>
                                    <span class="blob-btn__blob"></span>
                                    <span class="blob-btn__blob"></span>
                                </span>
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('banners.index') }}" class="blob-btn nav-link p-0">
                            Banner
                            <span class="blob-btn__inner">
                                <span class="blob-btn__blobs">
                                    <span class="blob-btn__blob"></span>
                                    <span class="blob-btn__blob"></span>
                                    <span class="blob-btn__blob"></span>
                                    <span class="blob-btn__blob"></span>
                                </span>
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('tech-news.index') }}" class="blob-btn nav-link p-0">
                            News
                            <span class="blob-btn__inner">
                                <span class="blob-btn__blobs">
                                    <span class="blob-btn__blob"></span>
                                    <span class="blob-btn__blob"></span>
                                    <span class="blob-btn__blob"></span>
                                    <span class="blob-btn__blob"></span>
                                </span>
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pc-rakitans.index') }}" class="blob-btn nav-link p-0">
                            Paket Rakitan
                            <span class="blob-btn__inner">
                                <span class="blob-btn__blobs">
                                    <span class="blob-btn__blob"></span>
                                    <span class="blob-btn__blob"></span>
                                    <span class="blob-btn__blob"></span>
                                    <span class="blob-btn__blob"></span>
                                </span>
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('laptops.index') }}" class="blob-btn nav-link p-0">
                            Laptop
                            <span class="blob-btn__inner">
                                <span class="blob-btn__blobs">
                                    <span class="blob-btn__blob"></span>
                                    <span class="blob-btn__blob"></span>
                                    <span class="blob-btn__blob"></span>
                                    <span class="blob-btn__blob"></span>
                                </span>
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('console-and-handhelds.index') }}" class="blob-btn nav-link p-0">
                            C&H
                            <span class="blob-btn__inner">
                                <span class="blob-btn__blobs">
                                    <span class="blob-btn__blob"></span>
                                    <span class="blob-btn__blob"></span>
                                    <span class="blob-btn__blob"></span>
                                    <span class="blob-btn__blob"></span>
                                </span>
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pc-parts.index') }}" class="blob-btn nav-link p-0">
                            PC Parts
                            <span class="blob-btn__inner">
                                <span class="blob-btn__blobs">
                                    <span class="blob-btn__blob"></span>
                                    <span class="blob-btn__blob"></span>
                                    <span class="blob-btn__blob"></span>
                                    <span class="blob-btn__blob"></span>
                                </span>
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('customer-service.index') }}" class="blob-btn nav-link p-0">
                            CS
                            <span class="blob-btn__inner">
                                <span class="blob-btn__blobs">
                                    <span class="blob-btn__blob"></span>
                                    <span class="blob-btn__blob"></span>
                                    <span class="blob-btn__blob"></span>
                                    <span class="blob-btn__blob"></span>
                                </span>
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('checkouts.index') }}" class="blob-btn nav-link p-0">
                            Order
                            <span class="blob-btn__inner">
                                <span class="blob-btn__blobs">
                                    <span class="blob-btn__blob"></span>
                                    <span class="blob-btn__blob"></span>
                                    <span class="blob-btn__blob"></span>
                                    <span class="blob-btn__blob"></span>
                                </span>
                            </span>
                        </a>
                    </li>
                </ul>
                <form action="{{ route('logout') }}" method="POST" class="d-flex ms-lg-3 position-relative" style="z-index:2;">
                    @csrf
                    <button type="submit" class="blob-btn blob-btn-logout p-0" style="background:transparent;">
                        Logout
                        <span class="blob-btn__inner">
                            <span class="blob-btn__blobs">
                                <span class="blob-btn__blob"></span>
                                <span class="blob-btn__blob"></span>
                                <span class="blob-btn__blob"></span>
                                <span class="blob-btn__blob"></span>
                            </span>
                        </span>
                    </button>
                </form>
                <!-- SVG filter for blob effect -->
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" style="display:none;">
                    <defs>
                        <filter id="goo">
                            <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur" />
                            <feColorMatrix in="blur" mode="matrix"
                                values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -7"
                                result="goo" />
                            <feBlend in="SourceGraphic" in2="goo" />
                        </filter>
                    </defs>
                </svg>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        {{-- Main content section --}}
        <main>
            @yield('content')
        </main>
    </div>
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>