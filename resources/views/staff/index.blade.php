@extends('layouts.app')

{{-- Include Add Modal --}}
@include('staff.partials.form_add_modal')

@section('content')
@php
    $hasFilters = request()->filled('search') || request()->filled('system_office') || 
                  request()->filled('designation') || request()->filled('status') ||
                  request()->filled('sort_by') || request()->filled('sort_order');
@endphp

<div class="container py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 fw-normal text-muted">Staff List</h2>
        <button class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#addStaffModal">
            <i class="bi bi-person-plus me-1"></i> Add Staff
        </button>
    </div>

    {{-- Filters --}}
    <div class="mb-4">
        <button class="btn btn-sm btn-outline-secondary mb-2" type="button" 
                data-bs-toggle="collapse" data-bs-target="#filterCollapse" 
                aria-expanded="{{ $hasFilters ? 'true' : 'false' }}">
            <i class="bi bi-funnel"></i> Filters
        </button>

        <div class="collapse {{ $hasFilters ? 'show' : '' }}" id="filterCollapse">
            <div class="card card-body bg-light p-3">
                <form method="GET" action="{{ route('staff.index') }}" id="filterForm" class="row g-2">
                    <div class="col-md-3">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               class="form-control form-control-sm" placeholder="Search name">
                    </div>
                    
                    <div class="col-md-3">
                        <select name="system_office" class="form-select form-select-sm">
                            <option value="">All Offices</option>
                            @foreach($offices as $office)
                                <option value="{{ $office }}" {{ request('system_office') == $office ? 'selected' : '' }}>
                                    {{ $office }}
                                </option>
                            @endforeach
                        </select>
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
                        <select name="status" class="form-select form-select-sm">
                            <option value="">All Statuses</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="resigned" {{ request('status') == 'resigned' ? 'selected' : '' }}>Resigned</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <select name="sort_by" class="form-select form-select-sm">
                            <option value="">Sort By</option>
                            <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                            <option value="email" {{ request('sort_by') == 'email' ? 'selected' : '' }}>Email</option>
                            <option value="system_office" {{ request('sort_by') == 'system_office' ? 'selected' : '' }}>Office</option>
                            <option value="designation" {{ request('sort_by') == 'designation' ? 'selected' : '' }}>Designation</option>
                            <option value="status" {{ request('sort_by') == 'status' ? 'selected' : '' }}>Status</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <select name="sort_order" class="form-select form-select-sm">
                            <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                            <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Descending</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-sm btn-dark flex-grow-1">
                            Apply
                        </button>
                        <a href="{{ route('staff.index') }}" class="btn btn-sm btn-outline-secondary">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="card border-0 shadow-sm">
        <div class="table-responsive ">
            <table class="table table-hover mb-0 text-center">
                <thead class="small bg-dark text-white">
                    <tr>
                        <th class="ps-3">Name</th>
                        <th>Email</th>
                        <th>Office</th>
                        <th>Designation</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($staffs as $staff)
                        @include('partials.confirm_modal', ['deleteRoute' => route('staff.destroy', $staff->id)])
                        @include('staff.partials.equipments_modal', ['staff' => $staff])
                        @include('staff.partials.form_edit_modal', ['staff' => $staff])
                        <tr>
                            <td class="ps-3">{{ $staff->name }}</td>
                            <td class="text-muted">{{ $staff->email }}</td>
                            <td>{{ $staff->system_office }}</td>
                            <td>{{ $staff->designation }}</td>
                            <td>
                                <span class="badge bg-{{ $staff->status === 'active' ? 'success' : 'danger' }}">
                                    {{ ucfirst($staff->status) }}
                                </span>
                            </td>
                            <td >
                                <div class="btn-group btn-group-sm" role="group">
                                    <button class="btn btn-outline-secondary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editStaffModal{{ $staff->id }}"
                                            title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    
                                    <a href="{{ route('staff.show', $staff->id) }}" 
                                       class="btn btn-outline-secondary"
                                       title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    
                                    <button class="btn btn-outline-secondary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#equipmentsModal{{ $staff->id }}"
                                            title="Equipments">
                                        <i class="bi bi-laptop"></i>
                                    </button>
                                    
                                    <button class="btn btn-outline-danger" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#confirmDeleteModal"
                                            title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                          @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No staff found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $staffs->withQueryString()->links('vendor.pagination.bootstrap-5') }}
    </div>
</div>

<script>
    document.getElementById('filterForm')?.addEventListener('submit', function (e) {
        const inputs = this.querySelectorAll('input, select');
        inputs.forEach(input => {
            if (!input.value.trim()) input.disabled = true;
        });
    });
</script>
@if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            Swal.fire({
                title: 'Validation Error',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                icon: 'error',
                confirmButtonColor: '#90143c',
                customClass: {
                    popup: 'rounded-4 shadow'
                }
            });
        });
    </script>
@endif
@endsection