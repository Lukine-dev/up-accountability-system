@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold" style="color: #90143c;">📝 Create Accountability Form</h2>
        <a href="{{ route('applications.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left-circle"></i> Back to List
        </a>
    </div>

    <form method="POST" action="{{ route('applications.store') }}">
        @csrf

        {{-- Staff Selection --}}
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header text-white" style="background-color: #90143c;">
                👤 Select Staff
            </div>
            <div class="card-body">
                <select name="staff_id" id="staff_id" class="form-select mb-3" required onchange="fillStaffInfo()">
                    <option value="" disabled selected>-- Choose a Staff Member --</option>
                    @foreach ($staffs as $staff)
                        <option value="{{ $staff->id }}"
                            data-name="{{ $staff->name }}"
                            data-system_office="{{ $staff->system_office }}"
                            data-designation="{{ $staff->designation }}"
                            data-department="{{ $staff->department }}">
                            {{ $staff->name }} - {{ $staff->designation }} ({{ $staff->department }})
                        </option>
                    @endforeach
                </select>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Full Name:</label>
                        <input type="text" id="staff_name" class="form-control" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">System Office:</label>
                        <input type="text" id="staff_system_office" class="form-control" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Designation:</label>
                        <input type="text" id="staff_designation" class="form-control" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Department / Office Unit:</label>
                        <input type="text" id="staff_department" class="form-control" readonly>
                    </div>
                </div>
            </div>
        </div>

        {{-- Equipments --}}
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header d-flex justify-content-between align-items-center text-white" style="background-color: #90143c;">
                <span>🧰 Register Equipments</span>
                <button type="button" class="btn btn-sm text-white border-light" onclick="addRow()" style="background-color: #90143c;">
                    <i class="bi bi-plus-circle"></i> Add Equipment
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered m-0" id="equipments-table">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Model/Brand</th>
                                <th>Serial Number</th>
                                <th>Quantity</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" class="form-control" name="equipments[0][name]" required></td>
                                <td><input type="text" class="form-control" name="equipments[0][description]"></td>
                                <td><input type="text" class="form-control" name="equipments[0][model_brand]"></td>
                                <td><input type="text" class="form-control" name="equipments[0][serial_number]"></td>
                                <td><input type="number" class="form-control" name="equipments[0][quantity]" required min="1"></td>
                                <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)">
                                    <i class="bi bi-x-lg"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="d-flex justify-content-between">
            <a href="{{ route('applications.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-x-circle"></i> Cancel
            </a>
            <button type="submit" class="btn text-white" style="background-color: #90143c;">
                <i class="bi bi-check-circle-fill"></i> Submit Form
            </button>
        </div>
    </form>
</div>

{{-- Scripts --}}
<script>
    function fillStaffInfo() {
        const selected = document.querySelector('#staff_id').selectedOptions[0];
        document.getElementById('staff_name').value = selected.getAttribute('data-name') || '';
        document.getElementById('staff_system_office').value = selected.getAttribute('data-system_office') || '';
        document.getElementById('staff_designation').value = selected.getAttribute('data-designation') || '';
        document.getElementById('staff_department').value = selected.getAttribute('data-department') || '';
    }

    let rowCount = 1;
    function addRow() {
        const tbody = document.querySelector('#equipments-table tbody');
        const row = document.createElement('tr');

        row.innerHTML = `
            <td><input type="text" class="form-control" name="equipments[${rowCount}][name]" required></td>
            <td><input type="text" class="form-control" name="equipments[${rowCount}][description]"></td>
            <td><input type="text" class="form-control" name="equipments[${rowCount}][model_brand]"></td>
            <td><input type="text" class="form-control" name="equipments[${rowCount}][serial_number]"></td>
            <td><input type="number" class="form-control" name="equipments[${rowCount}][quantity]" required min="1"></td>
            <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)">
                <i class="bi bi-x-lg"></i></button>
            </td>
        `;

        tbody.appendChild(row);
        rowCount++;
    }

    function removeRow(button) {
        button.closest('tr').remove();
    }
</script>
@endsection
