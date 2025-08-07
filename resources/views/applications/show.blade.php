@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold mb-0" style="color: #90143c;">📄 Form Details</h2>
        <div>
            <a href="{{ route('applications.index') }}" class="btn btn-outline-secondary me-2">
                <i class="bi bi-arrow-left-circle"></i> Back to List
            </a>
            <a href="{{ route('applications.edit', $application->id) }}" class="btn btn-outline-warning me-2">
                <i class="bi bi-pencil-square"></i> Edit
            </a>
            <a href="{{ route('applications.pdf', $application->id) }}" class="btn text-white" style="background-color: #90143c;">
                <i class="bi bi-file-earmark-pdf"></i> Download PDF
            </a>
          <a href="{{ route('applications.downloadCSV', $application->id) }}" class="btn btn-success d-inline-flex align-items-center">
                <i class="bi bi-file-earmark-spreadsheet me-1"></i> Download CSV
            </a>

        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="col-md-6 mb-2">
                <span class="fw-semibold">📌 Status:</span>
                @if($application->status === 'returned')
                    <span class="badge bg-danger">Returned</span>
                @elseif($application->status === 'issued')
                    <span class="badge bg-warning text-dark">Issued</span>
                @else
                    <span class="badge bg-success">{{ ucfirst($application->status) }}</span>
                @endif
            </div>
                @if($application->status === 'returned' && $application->returned_at)
                    <div class="col-md-6 mb-2">
                        <span class="fw-semibold">📅 Returned At:</span> {{ \Carbon\Carbon::parse($application->returned_at)->format('F d, Y h:i A') }}
                    </div>
                @endif

            <div class="row mb-3">
                <div class="col-md-6 mb-2">
                    <span class="fw-semibold">📎 Reference #:</span> {{ $application->reference_number }}
                </div>
                <div class="col-md-6 mb-2">
                    <span class="fw-semibold">🧑 Staff Name:</span> {{ $application->staff->name }}
                </div>
                <div class="col-md-6 mb-2">
                    <span class="fw-semibold">🏢 System Office:</span> {{ $application->staff->system_office }}
                </div>
                <div class="col-md-6 mb-2">
                    <span class="fw-semibold">💼 Designation:</span> {{ $application->staff->designation }}
                </div>
                <div class="col-md-6 mb-2">
                    <span class="fw-semibold">📌 Department:</span> {{ $application->staff->department }}
                </div>
                <div class="col-md-6 mb-2">
                    <span class="fw-semibold">🗓️ Application Date:</span> {{ \Carbon\Carbon::parse($application->application_date)->format('F d, Y') }}
                </div>
            </div>

            <hr>

            <h5 class="fw-bold mt-3 mb-3" style="color: #90143c;">🖥️ Equipment List</h5>

        @if($application->equipments->count())
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th style="width: 10%;">Qty</th>
                    <th style="width: 40%;">Description</th>
                    <th style="width: 25%;">Model/Brand</th>
                    <th style="width: 25%;">Serial Number</th>
                </tr>
            </thead>
            <tbody>
                @foreach($application->equipments as $index => $equipment)
                                <tr class="text-center">
                                    <td>{{ $equipment->quantity }}</td>

                                    {{-- Description --}}
                                    <td>
                                        @if(strlen($equipment->name) > 40)
                                            {{ Str::limit($equipment->name, 40) }}
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#descModal{{ $index }}">See more</a>
                                        @else
                                            {{ $equipment->name }}
                                        @endif
                                    </td>

                                    {{-- Model/Brand --}}
                                    <td>
                                        @if(strlen($equipment->model_brand) > 30)
                                            {{ Str::limit($equipment->model_brand, 30) }}
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#modelModal{{ $index }}">See more</a>
                                        @else
                                            {{ $equipment->model_brand ?? '-' }}
                                        @endif
                                    </td>

                                    {{-- Serial Number --}}
                                    <td>
                                        @if(strlen($equipment->serial_number) > 30)
                                            {{ Str::limit($equipment->serial_number, 30) }}
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#serialModal{{ $index }}">See more</a>
                                        @else
                                            {{ $equipment->serial_number ?? '-' }}
                                        @endif
                                    </td>
                                </tr>

                                {{-- Modals --}}
                                <div class="modal fade" id="descModal{{ $index }}" tabindex="-1" aria-labelledby="descModalLabel{{ $index }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title" id="descModalLabel{{ $index }}">Full Description</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">{{ $equipment->name }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="modelModal{{ $index }}" tabindex="-1" aria-labelledby="modelModalLabel{{ $index }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title" id="modelModalLabel{{ $index }}">Full Model/Brand</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">{{ $equipment->model_brand }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="serialModal{{ $index }}" tabindex="-1" aria-labelledby="serialModalLabel{{ $index }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title" id="serialModalLabel{{ $index }}">Full Serial Number</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">{{ $equipment->serial_number }}</div>
                                        </div>
                                    </div>
                                </div>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted fst-italic">No equipment listed for this application.</p>
            @endif

        </div>
    </div>

</div>
<style>
    /* Table styling */
    .table thead th {
        background-color: #f8f9fa;
        color: #90143c;
        font-weight: bold;
        border-bottom: 2px solid #dee2e6;
    }

    .table tbody tr:hover {
        background-color: #f3f3f3;
    }

    /* Modal header with custom theme */
    .modal-header.bg-primary {
        background-color: #90143c !important;
        border-bottom: 1px solid #891336;
    }

    .modal-title {
        font-weight: bold;
    }

    /* Add spacing between modals */
    .modal + .modal {
        margin-top: 10px;
    }

    /* Responsive modal body text */
    .modal-body {
        word-wrap: break-word;
        font-size: 1rem;
    }

    /* Optional: Add padding to modal content */
    .modal-content {
        padding: 0.5rem;
    }

    /* Highlight quantity cell */
    td:first-child {
        font-weight: bold;
        background-color: #fdf0f2;
    }

    /* Responsive tweaks */
    @media (max-width: 576px) {
        .table th, .table td {
            font-size: 0.875rem;
        }

        .modal-body {
            font-size: 0.9rem;
        }
    }
</style>
@endsection
