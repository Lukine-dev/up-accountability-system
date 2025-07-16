@extends('layouts.app')

@section('title', 'Welcome')

@push('styles')
    <style>
        html, body {
            height: 100%;
            margin: 0;
            overflow: hidden;
        }

        body {
            background: linear-gradient(
                        rgba(0, 0, 0, 0.6),
                        rgba(0, 0, 0, 0.6)
                    ),
                    url('{{ asset('storage/upitdc_images/main-bg.jpg') }}') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', sans-serif;
            color: white;
        }

        .welcome-container {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            flex-direction: column;
            padding: 0 20px;
            animation: fadeIn 1.2s ease-in-out;
        }

        .logo {
            max-height: 160px;
            margin-bottom: 15px;
            animation: popIn 1s ease;
            filter: drop-shadow(0 0 5px rgba(255, 255, 255, 0.7));
        }

        .welcome-heading {
            font-size: 3rem;
            font-weight: 700;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.7);
            margin-bottom: 0.5rem;
        }

        .welcome-subtext {
            font-size: 1.25rem;
            color: #e2e2e2;
            margin-bottom: 2rem;
        }

        .welcome-buttons a {
            min-width: 130px;
            padding: 0.6rem 1.2rem;
            font-weight: 500;
            transition: all 0.3s ease;
            border-radius: 30px;
        }

        .welcome-buttons a.btn-outline-light:hover {
            background-color: white;
            color: #90143c;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.7);
        }

        .welcome-buttons a.btn-light:hover {
            background-color: var(--theme-light, #fce6ec);
            color: var(--theme-color, #90143c);
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.6);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes popIn {
            0% { transform: scale(0.8); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
    </style>
@endpush

@section('content')
    <div class="welcome-container">
        <img src="{{ asset('storage/upitdc_images/logo-png.png') }}" alt="Logo" class="logo">
        <h3 class="welcome-heading">Welcome to <br>UP ITDC Accountability Form System</h3>
        <p class="welcome-subtext">Manage issued devices and staff accountability effortlessly.</p>

        <div class="welcome-buttons d-flex gap-3 justify-content-center">
            <a href="{{ route('login') }}" class="btn btn-outline-light">Login</a>
            <a href="{{ route('register') }}" class="btn btn-light text-dark">Register</a>
        </div>
    </div>
@endsection
