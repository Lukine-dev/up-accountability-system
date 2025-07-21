@extends('layouts.app')

@section('title', 'Page Not Found')

@section('content')
<div class="container text-center py-5">
    <h1 class="display-1 fw-bold text-maroon">404</h1>
    <p class="fs-4 text-muted">Oops! The page you're looking for doesn't exist.</p>

    <a href="{{ url('/') }}" class="btn btn-theme mt-3">
        <i class="bi bi-arrow-left"></i> Back to Home
    </a>
</div>
@endsection

@push('styles')
<style>
    .text-maroon {
        color: #90143c;
    }

    .btn-theme {
        background-color: #90143c;
        color: #fff;
    }

    .btn-theme:hover {
        background-color: #6f0f2e;
        color: #fff;
    }
</style>
@endpush
