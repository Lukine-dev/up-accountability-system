@extends('layouts.app')

@section('content')
<style>
    :root {
        --theme-color: #90143c;
        --theme-light: #fce6ec;
    }

        html, body {
        height: 100%;
        overflow: hidden;
    }
    
    .bg-theme {
        background-color: var(--theme-color);
        color: white;
    }

    .text-theme {
        color: var(--theme-color);
    }

    .form-control:focus {
        border-color: var(--theme-color);
        box-shadow: 0 0 0 0.2rem rgba(144, 20, 60, 0.25);
    }

    .btn-theme {
        background-color: var(--theme-color);
        color: white;
        border: none;
    }

    .btn-theme:hover {
        background-color: #7b0f32;
    }

    .toast-error {
        background-color: #ffcdd2;
        color: #b71c1c;
        padding: 10px 15px;
        border-radius: 8px;
        margin-bottom: 15px;
        border-left: 6px solid #b71c1c;
    }
</style>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 90vh;">
    <div class="col-md-6">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-theme text-center rounded-top-4">
                <h4 class="mb-0">{{ __('Login to Your Account') }}</h4>
            </div>

            <div class="card-body px-5 py-4">

                {{-- Real-Time Clock and Location --}}
                <div id="timeLocation" class="text-center mb-3 text-muted" style="font-size: 0.95rem;">
                    Loading time and location...
                </div>

                {{-- Global Error Toast --}}
                @if (session('error'))
                    <div class="toast-error">
                        <strong>Error:</strong> {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label text-theme">{{ __('Email Address') }}</label>
                        <input id="email" type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autofocus>

                        @error('email')
                            <div class="invalid-feedback d-block toast-error">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-3">
                        <label for="password" class="form-label text-theme">{{ __('Password') }}</label>
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            name="password" required>

                        @error('password')
                            <div class="invalid-feedback d-block toast-error">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Remember Me --}}
                    <div class="mb-3 form-check">
                        <input class="form-check-input" type="checkbox"
                            name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>

                    {{-- Submit --}}
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-theme px-4">
                            {{ __('Login') }}
                        </button>

                        @if (Route::has('password.request'))
                            <a class="text-decoration-none text-theme" href="{{ route('password.request') }}">
                                {{ __('Forgot Password?') }}
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Clock & Location Script --}}
<script>
    function updateClockLocation() {
        const now = new Date();
        const options = {
            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric',
            hour: '2-digit', minute: '2-digit', second: '2-digit',
            hour12: false,
            timeZone: 'Asia/Manila'
        };
        const formatted = now.toLocaleString('en-PH', options);
        const location = '📍 Quezon City, Philippines';
        document.getElementById('timeLocation').textContent = `${formatted} • ${location}`;
    }

    setInterval(updateClockLocation, 1000);
    updateClockLocation();
</script>
@endsection
