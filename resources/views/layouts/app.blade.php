<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/upitdc_images/logo-png.png') }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom Minimalist Theme -->
    <style>
        :root {
            --theme-color: #90143c;
            --theme-light: #f9f1f3;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
        }

        .navbar {
            background-color: var(--theme-color);
            padding: 0.75rem 1rem;
            border: none;
        }

        .navbar .navbar-brand,
        .navbar .nav-link,
        .navbar .dropdown-item {
            color: #fff !important;
            font-weight: 500;
        }

        .navbar .nav-link.active,
        .navbar .dropdown-item.active {
            background-color: rgba(255, 255, 255, 0.15) !important;
        }

        .navbar .nav-link:hover,
        .navbar .dropdown-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .dropdown-menu {
            background-color: var(--theme-color);
            border: none;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.05);
        }

        .dropdown-menu .dropdown-item {
            padding: 0.5rem 1rem;
            transition: background-color 0.2s ease-in-out;
        }

        .dropdown-menu .dropdown-item i {
            margin-right: 6px;
        }

        .navbar-toggler {
            border: none;
        }

        .navbar-toggler-icon {
            filter: invert(1);
        }

        main {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        /* Optional: logo image styling */
        .navbar-brand img {
            height: 36px;
        }

        /* Toast tweaks */
        .swal2-toast {
            font-size: 0.9rem !important;
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            .navbar .navbar-brand span {
                font-size: 1rem;
            }
        }
        footer {
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>

    @stack('styles')
</head>
<body>
    <div id="app">
        @yield('before-content')

        @if (!Request::is('/'))
        <nav class="navbar navbar-expand-md">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/home') }}">
                    <img src="{{ asset('storage/upitdc_images/logo-png.png') }}" alt="Logo">
                    <span>{{ config('app.name', 'UP-ITDC Accountability Form Management System') }}</span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side -->
                    <ul class="navbar-nav me-auto"></ul>

                    <!-- Right Side -->
                    <ul class="navbar-nav ms-auto align-items-center">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                    Dashboard
                                </a>
                            </li>

                            <!-- Admin Controls Dropdown -->
                            <li class="nav-item dropdown">
                                <a id="adminDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                   data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Admin Controls
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                                    <a class="dropdown-item {{ request()->routeIs('staff.index') ? 'active' : '' }}" href="{{ route('staff.index') }}">
                                        <i class="bi bi-people-fill"></i> Staff
                                    </a>
                                    <a class="dropdown-item {{ request()->routeIs('applications.index') ? 'active' : '' }}" href="{{ route('applications.index') }}">
                                        <i class="bi bi-file-earmark-text"></i> Forms
                                    </a>
                                    <a class="dropdown-item {{ request()->routeIs('equipment.index') ? 'active' : '' }}" href="{{ route('equipment.index') }}">
                                        <i class="bi bi-box-seam"></i> Equipment
                                    </a>
                                    <a class="dropdown-item {{ request()->routeIs('history') ? 'active' : '' }}" href="{{ route('history') }}">
                                        <i class="bi bi-clock-history"></i> Logs
                                    </a>
                                </div>
                            </li>

                            <!-- User Dropdown -->
                            <li class="nav-item dropdown">
                                <a id="userDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                   data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <a class="dropdown-item {{ request()->routeIs('users.index') ? 'active' : '' }}" href="{{ route('users.index') }}">
                                        <i class="bi bi-person-gear"></i> Manage Users
                                    </a>

                                    <a class="dropdown-item {{ request()->routeIs('account.settings') ? 'active' : '' }}" href="{{ route('account.settings') }}">
                                        <i class="bi bi-gear"></i> Account Settings
                                    </a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        @endif

        <main class="@if (!Request::is('/'))  @endif">
            @yield('content')
        </main>
    </div>

    @stack('scripts')

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000,
                    toast: true,
                    position: 'top-end'
                });
            });
        </script>
    @endif


    {{-- <footer>
        <div class="container text-center " >
            <p class=" text-muted">&copy; {{ date('Y') }} UP ITDC Accountability Form Management System. All rights reserved.</p>
        </div>
    </footer> --}}
</body>
</html>
