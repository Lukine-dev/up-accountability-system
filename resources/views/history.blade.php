@extends('layouts.app')

@section('title', 'Action Logs')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
       <h2 class="h4 fw-normal text-muted">History Logs</h2>  
    </div>

    <div class="row g-3 mb-4">
        <!-- Filter by Date -->
       <div class="row g-3 mb-4">
            <!-- Filter by Date -->
            <div class="col-md-4">
                <div class="input-group">
                    <input type="date" name="filter_date" id="filter_date" class="form-control">
                    <button class="btn btn-outline-dark" onclick="clearFilter()" type="button">
                        <i class="bi bi-x-lg"></i> Clear
                    </button>
                </div>
            </div>

            <!-- Delete by Date -->
            <div class="col-md-4">
                <form method="POST" action="{{ route('history.deleteByDate') }}" class="input-group" id="deleteLogsForm">
                    @csrf
                    <input type="date" name="date" class="form-control" required>
                    <button type="submit" class="btn btn-outline-danger" onclick="confirmDeletion(event)">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </form>
            </div>

            <!-- Export by Date -->
            <div class="col-md-4">
                <form method="GET" action="{{ route('history.export') }}" class="input-group">
                    <input type="date" name="date" class="form-control" required>
                    <button type="submit" class="btn btn-outline-secondary">
                        <i class="bi bi-download"></i> Export
                    </button>
                </form>
            </div>
        </div>

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
            <tbody id="logs-table-body">
                @include('partials.logs_table_rows', ['logs' => $logs])
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end mt-3">
        {{ $logs->links('vendor.pagination.bootstrap-5') }}
    </div>
</div>

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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDeletion(e) {
    e.preventDefault();
    const form = document.getElementById('deleteLogsForm');
    const date = form.querySelector('input[name="date"]').value;

    if (!date) return;

    Swal.fire({
        title: `Delete logs from ${date}?`,
        text: "This action cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#90143c',
        confirmButtonText: 'Yes, delete'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}

function clearFilter() {
    document.getElementById('filter_date').value = '';
    fetchLogs();
}

function fetchLogs() {
    const date = document.getElementById('filter_date').value;
    fetch(`/history/filter?date=${date}`)
        .then(res => res.text())
        .then(html => {
            document.getElementById('logs-table-body').innerHTML = html;
        });
}

document.getElementById('filter_date').addEventListener('change', fetchLogs);

document.querySelector('input[name="date"]').addEventListener('change', function () {
    const date = this.value;

    if (date) {
        fetch(`/history/preview-count?date=${date}`)
            .then(res => res.json())
            .then(data => {
                Swal.fire({
                    title: `${data.count} log(s) will be deleted`,
                    icon: 'info',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2500
                });
            });
    }
});
</script>
@endpush
@endsection
