@extends('layouts.app')

@section('content')
<style>
    :root {
        --theme-color: #90143c;
        --theme-light: #fce6ec;
    }

    .text-theme {
        color: var(--theme-color);
    }

    .bg-theme {
        background-color: var(--theme-color);
        color: white;
    }

    .card-theme {
        border-left: 5px solid var(--theme-color);
        border-radius: 12px;
        background: white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.07);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        animation: fadeInUp 0.5s ease;
    }

    .card-theme:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
    }

    .icon-circle {
        background-color: #f9dfe6;
        color: var(--theme-color);
        border-radius: 50%;
        padding: 0.7rem;
        font-size: 1.5rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
    }

    .quick-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        background: var(--theme-light);
        border: 1px solid #eee;
        padding: 0.9rem 1.2rem;
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.2s ease-in-out;
        animation: fadeIn 0.6s ease;
    }

    .quick-link:hover {
        background: #f5d1db;
        text-decoration: none;
        transform: scale(1.02);
    }

    .section-title {
        color: var(--theme-color);
        border-bottom: 2px solid var(--theme-color);
        padding-bottom: 0.4rem;
        margin-bottom: 1.5rem;
        font-weight: 600;
        animation: fadeInDown 0.5s ease;
    }

    @keyframes fadeInUp {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="container py-4">
    <h1 class="mb-4 text-theme">🏠 ICT Home Dashboard</h1>

    {{-- Info Cards --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card card-theme p-4 d-flex flex-row align-items-center">
                <div class="icon-circle me-3">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <h6 class="mb-1">Total Staff</h6>
                    <h4 class="mb-0">{{ $totalStaff }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-theme p-4 d-flex flex-row align-items-center">
                <div class="icon-circle me-3">
                    <i class="bi bi-person-check-fill"></i>
                </div>
                <div>
                    <h6 class="mb-1">Active Staff</h6>
                    <h4 class="mb-0">{{ $activeStaff }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-theme p-4 d-flex flex-row align-items-center">
                <div class="icon-circle me-3">
                    <i class="bi bi-person-dash-fill"></i>
                </div>
                <div>
                    <h6 class="mb-1">Resigned Staff</h6>
                    <h4 class="mb-0">{{ $resignedStaff }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card card-theme p-4 d-flex flex-row align-items-center">
                <div class="icon-circle me-3">
                    <i class="bi bi-file-earmark-text-fill"></i>
                </div>
                <div>
                    <h6 class="mb-1">Total Applications</h6>
                    <h4 class="mb-0">{{ $totalApplications }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-theme p-4 d-flex flex-row align-items-center">
                <div class="icon-circle me-3">
                    <i class="bi bi-box-arrow-up-right"></i>
                </div>
                <div>
                    <h6 class="mb-1">Equipment Released</h6>
                    <h4 class="mb-0">{{ $totalEquipmentReleased }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Search --}}
    <h5 class="section-title">🔍 Quick Search</h5>
    <div class="row g-3 mb-5">
        <div class="col-md-6">
            <form method="GET" action="{{ route('staff.index') }}">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search Staff by name/email...">
                    <button class="btn btn-theme" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <form method="GET" action="{{ route('applications.index') }}">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search Application ref/user...">
                    <button class="btn btn-theme" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Quick Navigation --}}
    <h5 class="section-title">🔗 Quick Navigation</h5>
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <a href="{{ route('staff.index') }}" class="quick-link">
                <i class="bi bi-people-fill"></i> View Staff List
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('applications.index') }}" class="quick-link">
                <i class="bi bi-journal-text"></i> View Applications
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('monitor.issued_equipment') }}" class="quick-link">
                <i class="bi bi-box-seam"></i> View Released Equipment
            </a>
        </div>
    </div>
</div>

{{-- Include Bootstrap Icons --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection
