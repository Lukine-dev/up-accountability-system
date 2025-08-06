@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3 fw-bold text-dark" style="color: #90143c;">
        <i class="bi bi-clock-history me-1"></i> Equipment Release History - <strong>{{ $staff->name }}</strong>
    </h2>

    <div class="mb-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <a href="{{ route('staff.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
        <div class="d-flex gap-2">
            <a href="{{ route('staff.equipment.summary', $staff->id) }}" class="btn btn-warning btn-sm" target="_blank">
                <i class="bi bi-printer"></i> Equipment Summary
            </a>
            <a href="{{ route('staff.downloadEquipmentCSV', $staff->id) }}" class="btn btn-success btn-sm">
                <i class="bi bi-file-earmark-spreadsheet"></i> Export CSV
            </a>
        </div>
    </div>

    {{-- Staff Information --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header text-white" style="background-color: #90143c;">
            <strong>Staff Information</strong>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <p><strong>Name:</strong> {{ $staff->name }}</p>
                    <p><strong>Email:</strong> {{ $staff->email }}</p>
                    <p><strong>System Office:</strong> {{ $staff->system_office }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Designation:</strong> {{ $staff->designation }}</p>
                    <p><strong>Department:</strong> {{ $staff->department }}</p>
                    <p><strong>Status:</strong>
                        <span class="badge bg-{{ $staff->status === 'active' ? 'success' : 'danger' }}">
                            {{ ucfirst($staff->status) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Released Equipment --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header text-white" style="background-color: #90143c;">
            <strong>Released Equipment</strong>
        </div>
        <div class="card-body">
            @forelse ($staff->applications as $application)
                <div class="border rounded p-3 mb-4 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap">
                        <div>
                            <strong>Ref #:</strong> {{ $application->reference_number }} |
                            <strong>Date:</strong> {{ \Carbon\Carbon::parse($application->application_date)->format('F d, Y') }}
                            <span class="mx-3 p-1 badge bg-{{ $application->status === 'active' ? 'success' : 'danger' }}">
                                    {{ ucfirst($application->status) }}
                            </span>
                        </div>
                        <div>
                             <a href="{{ route('applications.show', $application->id) }}" class="btn btn-sm btn-outline-info">
                                 <i class="bi bi-eye"></i> View
                             </a>
                              <a href="{{ route('applications.pdf', $application->id) }}" 
                                       class="btn btn-sm btn-outline-danger" title="PDF" target="_blank">
                            <i class="bi bi-file-pdf"></i> Download PDF
                        </a>
                        </div>
                       
                    </div>

                    <ul class="list-group list-group-flush">
                        @foreach ($application->equipments as $equipment)
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div>
                                    <strong>{{ $equipment->name }}</strong><br>
                                    <small>{{ $equipment->model_brand ?? '-' }} — SN: {{ $equipment->serial_number ?? '-' }}</small>
                                </div>
                                <span class="badge bg-dark-subtle text-dark-emphasis border border-dark-subtle rounded-pill">
                                    {{ $equipment->quantity }}x
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @empty
                <p class="text-muted">No released equipment found for this staff.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
