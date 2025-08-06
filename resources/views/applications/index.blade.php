@extends('layouts.app')

@section('content')
@php
    $hasFilters = request()->filled('search') || request()->filled('staff') || request()->filled('date') || request()->filled('designation') || request()->filled('department');
@endphp

<div class="container py-4">
    {{-- Header with Actions --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 fw-normal text-muted">ICT Accountability Forms</h2>
        
        <div class="btn-group">
            <a href="{{ route('applications.create') }}" class="btn btn-sm btn-dark">
                <i class="bi bi-plus"></i> New
            </a>
            <a href="{{ route('applications.downloadAllCSV') }}" class="btn btn-sm btn-outline-dark">
                <i class="bi bi-download"></i> Export
            </a>
        </div>
    </div>

    {{-- Filters --}}
    <div class="mb-4">
        <button class="btn btn-sm btn-outline-secondary mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="{{ $hasFilters ? 'true' : 'false' }}">
            <i class="bi bi-funnel"></i> Filters
        </button>

        <div class="collapse {{ $hasFilters ? 'show' : '' }}" id="filterCollapse">
            <div class="card card-body bg-light p-3">
                <form method="GET" action="{{ route('applications.index') }}" class="row g-2">
                    <div class="col-md-3">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               class="form-control form-control-sm" placeholder="Reference #">
                    </div>
                    
                    <div class="col-md-3">
                        <input type="text" name="staff" value="{{ request('staff') }}" 
                               class="form-control form-control-sm" placeholder="Staff name">
                    </div>
                    
                    <div class="col-md-3">
                        <input type="date" name="date" value="{{ request('date') }}" 
                               class="form-control form-control-sm">
                    </div>
                    
                    <div class="col-md-3">
                        <select name="designation" class="form-select form-select-sm">
                            <option value="">All Designations</option>
                            @foreach($designations as $designation)
                                <option value="{{ $designation }}" {{ request('designation') == $designation ? 'selected' : '' }}>
                                    {{ $designation }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <select name="department" class="form-select form-select-sm">
                            <option value="">All Departments</option>
                            @foreach($departments as $department)
                                <option value="{{ $department }}" {{ request('department') == $department ? 'selected' : '' }}>
                                    {{ $department }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select name="status" class="form-select form-select-sm">
                            <option value="">All Statuses</option>
                            @foreach(['active', 'returned'] as $status)
                                <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-sm btn-dark flex-grow-1">
                            Apply
                        </button>
                        <a href="{{ route('applications.index') }}" class="btn btn-sm btn-outline-secondary">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Alerts --}}
    {{-- @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 py-2" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif --}}

    {{-- Table --}}
    <div class="card border-0 shadow-sm">
        <div class="table-responsive text-center">
            <table class="table table-hover mb-0">
                <thead class="small bg-dark text-white">
                    <tr>
                        <th class="ps-3">Reference</th>
                        <th>Staff</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($applications as $application)
                        @include('partials.confirm_modal', ['deleteRoute' => route('applications.destroy', $application->id)])
                        <tr>
                            <td class="ps-3 text-muted">{{ $application->reference_number }}</td>
                            <td>{{ $application->staff->name }}</td>
                            <td class="text-muted">{{ $application->created_at->format('Y-m-d') }}</td>
                            <td>
                                <span class="badge bg-{{ $application->status === 'active' ? 'success' : 'danger' }}">
                                    {{ ucfirst($application->status) }}
                                </span>

                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('applications.show', $application->id) }}" 
                                       class="btn btn-sm btn-outline-secondary" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('applications.edit', $application->id) }}" 
                                       class="btn btn-sm btn-outline-secondary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="{{ route('applications.pdf', $application->id) }}" 
                                       class="btn btn-sm btn-outline-secondary" title="PDF" target="_blank">
                                        <i class="bi bi-file-pdf"></i>
                                    </a>
                                    <a href="{{ route('applications.downloadCSV', $application->id) }}" 
                                       class="btn btn-sm btn-outline-secondary" title="CSV">
                                        <i class="bi bi-file-earmark-spreadsheet"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger" 
                                            data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">No forms found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $applications->withQueryString()->links('vendor.pagination.bootstrap-5') }}
    </div>
</div>
@endsection