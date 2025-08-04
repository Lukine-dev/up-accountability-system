@extends('layouts.app')

@section('content')
<div class="container mt-5">
   <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <h2 class="fw-bold mb-0 text-maroon">📋 ICT Accountability Forms</h2>

        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('applications.create') }}" class="btn text-white" style="background-color: #90143c;">
                <i class="bi bi-plus-circle me-1"></i> New Form
            </a>
            <a href="{{ route('applications.downloadAllCSV') }}" class="btn btn-success d-inline-flex align-items-center">
                <i class="bi bi-file-earmark-csv me-2"></i> Export All Applications CSV
            </a>
        </div>
    </div>

    {{-- Filter Toggle --}}
    @php
        $hasFilters = request()->filled('search') || request()->filled('staff') || request()->filled('date');
    @endphp

    <div class="mb-3">
        <button class="btn btn-outline-dark btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
            <i class="bi bi-funnel"></i> Filters
        </button>
    </div>

    {{-- Filter Form --}}
    <div class="collapse {{ $hasFilters ? 'show' : '' }}" id="filterCollapse">
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('applications.index') }}">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="search" class="form-label">Search Reference #</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" class="form-control" placeholder="Enter reference number">
                        </div>

                        <div class="col-md-4">
                            <label for="staff" class="form-label">Staff</label>
                            <input type="text" name="staff" id="staff" value="{{ request('staff') }}" class="form-control" placeholder="Enter staff name">
                        </div>

                        <div class="col-md-4">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" name="date" id="date" value="{{ request('date') }}" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="designation" class="form-label">Designation</label>
                            <select name="designation" id="designation" class="form-select">
                                <option value="">-- Select Designation --</option>
                                @foreach($designations as $designation)
                                    <option value="{{ $designation }}" {{ request('designation') == $designation ? 'selected' : '' }}>
                                        {{ $designation }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="department" class="form-label">Department / Office</label>
                            <select name="department" id="department" class="form-select">
                                <option value="">-- Select Department --</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department }}" {{ request('department') == $department ? 'selected' : '' }}>
                                        {{ $department }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label d-block invisible">.</label>
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label d-block invisible">.</label>
                            <a href="{{ route('applications.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead class="text-white" style="background-color: #90143c;">
                        <tr>
                            <th scope="col">📎 Ref. No.</th>
                            <th scope="col">👤 Staff</th>
                            <th scope="col">🗓️ Date</th>
                            <th scope="col" class="text-center">⚙️ Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($applications as $application)
                               @include('partials.confirm_modal', ['deleteRoute' => route('applications.destroy', $application->id)])
                            <tr onclick="window.location='{{ route('applications.show', $application->id) }}'" style="cursor: pointer;">
                                <td class="fw-medium">{{ $application->reference_number }}</td>
                                <td>{{ $application->staff->name }}</td>
                                <td>{{ $application->created_at->format('Y-m-d') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('applications.show', $application->id) }}" class="btn btn-sm btn-outline-info me-1">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    <a href="{{ route('applications.edit', $application->id) }}" class="btn btn-sm btn-outline-warning me-1">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <a href="{{ route('applications.pdf', $application->id) }}" class="btn btn-sm btn-outline-danger" target="_blank">
                                        <i class="bi bi-printer"></i> PDF
                                    </a>
                                    <a href="{{ route('applications.downloadCSV', $application->id) }}" class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-file-earmark-spreadsheet me-1"></i> Download CSV
                                    </a>
                                   <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">Delete</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No forms found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
         {{ $applications->withQueryString()->links('vendor.pagination.bootstrap-5') }}
    </div>
</div>
@endsection
