@extends('layouts.app')

{{-- Include Add Modal --}}
@include('staff.partials.form_add_modal')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold mb-0" style="color: #90143c;">👥 Staff List</h2>
        <button class="btn text-white" style="background-color: #90143c;" data-bs-toggle="modal" data-bs-target="#addStaffModal">
            <i class="bi bi-person-plus-fill me-1"></i> Add Staff
        </button>
    </div>

    {{-- Filter Toggle --}}
    @php
        $hasFilters = request()->filled('search') || request()->filled('system_office') || request()->filled('designation') || request()->filled('status');
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
                <form method="GET" action="{{ route('staff.index') }}" id="filterForm">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="search" class="form-label">Search Name</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" class="form-control" placeholder="Enter name">
                        </div>
                        <div class="col-md-4">
                            <label for="system_office" class="form-label">Office</label>
                            <select name="system_office" id="system_office" class="form-select">
                                <option value="">-- Select Office --</option>
                                @foreach($offices as $office)
                                    <option value="{{ $office }}" {{ request('system_office') == $office ? 'selected' : '' }}>{{ $office }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="designation" class="form-label">Designation</label>
                            <select name="designation" id="designation" class="form-select">
                                <option value="">-- Select Designation --</option>
                                @foreach($designations as $designation)
                                    <option value="{{ $designation }}" {{ request('designation') == $designation ? 'selected' : '' }}>{{ $designation }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="">-- Select Status --</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="resigned" {{ request('status') == 'resigned' ? 'selected' : '' }}>Resigned</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="sort_by" class="form-label">Sort By</label>
                            <select name="sort_by" id="sort_by" class="form-select">
                                <option value="">-- Select Column --</option>
                                <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                                <option value="email" {{ request('sort_by') == 'email' ? 'selected' : '' }}>Email</option>
                                <option value="system_office" {{ request('sort_by') == 'system_office' ? 'selected' : '' }}>Office</option>
                                <option value="designation" {{ request('sort_by') == 'designation' ? 'selected' : '' }}>Designation</option>
                                <option value="status" {{ request('sort_by') == 'status' ? 'selected' : '' }}>Status</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <select name="sort_order" id="sort_order" class="form-select">
                                <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                                <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Descending</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label d-block invisible">.</label>
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label d-block invisible">.</label>
                            <a href="{{ route('staff.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Table View --}}
    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-striped align-middle mb-0">
                <thead class="text-white" style="background-color: #90143c;">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Office</th>
                        <th>Designation</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($staffs as $staff)
                        @include('partials.confirm_modal', ['deleteRoute' => route('staff.destroy', $staff->id)])
                        @include('staff.partials.equipments_modal', ['staff' => $staff])
                        @include('staff.partials.form_edit_modal', ['staff' => $staff])
                        <tr>
                            <td>{{ $staff->name }}</td>
                            <td>{{ $staff->email }}</td>
                            <td>{{ $staff->system_office }}</td>
                            <td>{{ $staff->designation }}</td>
                            <td>
                                <span class="badge bg-{{ $staff->status === 'active' ? 'success' : 'danger' }}">
                                    {{ ucfirst($staff->status) }}
                                </span>
                            </td>
                          <td class="text-center">
                                <div class="d-flex flex-wrap justify-content-center gap-1">
                                    <!-- Edit Button -->
                                    <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editStaffModal{{ $staff->id }}" title="Edit">
                                        ✏️
                                    </button>

                                    <!-- Show Button -->
                                    <a href="{{ route('staff.show', $staff->id) }}" class="btn btn-sm btn-outline-secondary" title="Show">
                                        👁️
                                    </a>

                                    <!-- Equipments Button -->
                                    <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#equipmentsModal{{ $staff->id }}" title="Equipments">
                                        💻
                                    </button>

                                    <!-- Delete Button -->
                                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" title="Delete">
                                        🗑️
                                    </button>
                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
         <div class="d-flex justify-content-center my-4">
        {{ $staffs->withQueryString()->links('vendor.pagination.bootstrap-5') }}
    </div>
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

@endsection
