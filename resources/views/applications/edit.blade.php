@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0" style="color: #90143c;">✏️ Edit ICT Device Accountability Form</h2>
        <a href="{{ route('applications.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left-circle"></i> Back to List
        </a>
    </div>

    <form method="POST" action="{{ route('applications.update', $application->id) }}" class="card shadow-sm border-0 p-4">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="staff_id" class="form-label fw-semibold">👤 Staff</label>
            <select name="staff_id" class="form-select" required>
                @foreach($staffs as $staff)
                    <option value="{{ $staff->id }}" {{ $application->staff_id == $staff->id ? 'selected' : '' }}>
                        {{ $staff->name }} - {{ $staff->designation }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <h5 class="d-flex justify-content-between align-items-center">
                🖥️ Equipment List
                <button type="button" class="btn btn-sm btn-outline-dark" onclick="addEditRow()">
                    <i class="bi bi-plus-circle"></i> Add Equipment
                </button>
            </h5>

            <div id="edit-equipments">
                @foreach($application->equipments as $index => $equipment)
                    <div class="row mb-2 align-items-center">
                        <div class="col-md-3">
                            <input type="text" name="equipments[{{ $index }}][name]" class="form-control" value="{{ $equipment->name }}" placeholder="Description">
                        </div>
        
                        <div class="col-md-2">
                            <input type="text" name="equipments[{{ $index }}][model_brand]" class="form-control" value="{{ $equipment->model_brand }}" placeholder="Model/Brand">
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="equipments[{{ $index }}][serial_number]" class="form-control" value="{{ $equipment->serial_number }}" placeholder="Serial Number">
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="equipments[{{ $index }}][quantity]" class="form-control" value="{{ $equipment->quantity }}" min="1" placeholder="Qty">
                        </div>
                        <div class="col-md-1 text-center">
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)">&times;</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <button type="submit" class="btn text-white" style="background-color: #90143c;">
                <i class="bi bi-save"></i> Update
            </button>
            <a href="{{ route('applications.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-x-circle"></i> Cancel
            </a>
        </div>
    </form>
</div>

{{-- JS for dynamic row handling --}}
<script>
    let editRowCount = {{ $application->equipments->count() }};

    function addEditRow() {
        const container = document.getElementById('edit-equipments');
        const row = document.createElement('div');
        row.classList.add('row', 'mb-2', 'align-items-center');

        row.innerHTML = `
            <div class="col-md-3">
                <input type="text" name="equipments[${editRowCount}][name]" class="form-control" placeholder="Description">
            </div>
            <div class="col-md-2">
                <input type="text" name="equipments[${editRowCount}][model_brand]" class="form-control" placeholder="Model/Brand">
            </div>
            <div class="col-md-2">
                <input type="text" name="equipments[${editRowCount}][serial_number]" class="form-control" placeholder="Serial Number">
            </div>
            <div class="col-md-2">
                <input type="number" name="equipments[${editRowCount}][quantity]" class="form-control" placeholder="Qty" min="1">
            </div>
            <div class="col-md-1 text-center">
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)">&times;</button>
            </div>
        `;

        container.appendChild(row);
        editRowCount++;
    }

    function removeRow(button) {
        button.closest('.row').remove();
    }
</script>
@endsection
