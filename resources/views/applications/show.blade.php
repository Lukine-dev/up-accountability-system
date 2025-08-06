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
                                <th>Quantity</th>
                                <th>Description</th>
                                <th>Model/Brand</th>
                                <th>Serial Number</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($application->equipments as $equipment)
                                <tr class="text-center">
                                    <td>{{ $equipment->quantity }}</td>
                                    <td>{{ $equipment->name }}</td>
                                    <td>{{ $equipment->model_brand ?? '-' }}</td>
                                    <td>{{ $equipment->serial_number ?? '-' }}</td>
                                </tr>
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
@endsection
