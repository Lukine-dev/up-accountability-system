@extends('layouts.app')

@section('title', 'Action Logs')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold text-maroon">
            <i class="bi bi-clock-history me-2"></i> User Action Logs
        </h3>
    </div>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-striped table-hover align-middle border">
            <thead class="table-maroon text-white">
                <tr>
                    <th>User</th>
                    <th>Action</th>
                    <th>Model</th>
                    <th>Model ID</th>
                    <th>Description</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($logs as $log)
                    <tr>
                        <td class="fw-semibold">{{ $log->user?->name ?? 'System' }}</td>
                        <td>
                            <span class="badge
                                @if($log->action === 'Created') bg-success
                                @elseif($log->action === 'Updated') bg-warning text-dark
                                @elseif($log->action === 'Deleted') bg-danger
                                @else bg-secondary
                                @endif
                            ">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td>{{ $log->model }}</td>
                        <td>{{ $log->model_id ?? '-' }}</td>
                        <td>{{ $log->description }}</td>
                        <td>{{ $log->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No logs found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end mt-3">
        {{ $logs->links() }}
    </div>
</div>

{{-- Optional: Add custom CSS --}}
@push('styles')
<style>
    .text-maroon {
        color: #90143c;
    }
    .table-maroon {
        background-color: #90143c;
    }
</style>
@endpush
@endsection
