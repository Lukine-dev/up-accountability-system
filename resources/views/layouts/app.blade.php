<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom Theme -->
    <style>
        :root {
            --theme-color: #90143c;
            --theme-light: #fce6ec;
        }

        .navbar {
            background-color: var(--theme-color) !important;
        }

        .navbar .navbar-brand,
        .navbar .nav-link,
        .navbar .dropdown-item {
            color: #fff !important;
        }

        .navbar .nav-link:hover,
        .navbar .dropdown-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .dropdown-menu {
            background-color: var(--theme-color);
        }

        .dropdown-menu .dropdown-item {
            color: #fff;
        }

        .dropdown-menu .dropdown-item:hover {
            background-color: rgba(255, 255, 255, 0.15);
        }
    </style>

    @stack('styles')
</head>
<body>
    <div id="app">
        @yield('before-content')

        {{-- Hide navbar on welcome page --}}
        @if (!Request::is('/'))
        <nav class="navbar navbar-expand-md shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-semibold d-flex align-items-center gap-2" href="{{ url('/home') }}">
                    <img src="{{ asset('storage/upitdc_images/logo-png.png') }}" alt="Logo" class="logo" style="height: 40px">
                    <span>{{ config('app.name', 'UP-ITDC Accountability Form Management System') }}</span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon text-white"></span>
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
                            <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Dashboard</a></li>

                            <!-- Admin Controls Dropdown -->
                            <li class="nav-item dropdown">
                                <a id="adminDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                   data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Administrator Controls
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                                    {{-- <a class="dropdown-item" href="{{ route('monitor.issued_equipment') }}">Equipment Issued</a> --}}       
                                    <a class="dropdown-item" href="{{ route('staff.index') }}">Staff Controls</a>
                                    <a class="dropdown-item" href="{{ route('applications.index') }}">Accountability Forms</a>
                                    <a class="dropdown-item" href="{{ route('equipment.index') }}">Equipment Issued</a>
                                </div>
                            </li>

                            <!-- User Dropdown -->
                            <li class="nav-item dropdown">
                                <a id="userDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                   data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
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

        <main class="@if (!Request::is('/')) py-4 @endif">
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
    
</body>
</html>
