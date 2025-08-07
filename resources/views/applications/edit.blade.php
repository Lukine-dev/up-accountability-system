@extends('layouts.app')

@section('content')
<div class="container mt-4 p-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
        <h2 class="fw-bold mb-0 me-3" style="color: #90143c;">✏️ Edit ICT Device Accountability Form</h2>

        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('applications.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left-circle"></i> Back to List
            </a>

            @if($application->status !== 'returned')
                <form id="return-form-{{ $application->id }}" method="POST" action="{{ route('applications.markReturned', $application->id) }}">
                    @csrf
                    <button type="button" class="btn btn-warning"
                        onclick="confirmMarkReturned({{ $application->id }})">
                        Mark as Returned
                    </button>
                </form>
            @else
                <button class="btn btn-success" disabled>Returned</button>
            @endif
        </div>
    </div>

    {{-- Error Display --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>There were some problems with your input:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('applications.update', $application->id) }}" class="card shadow-sm border-0 p-4">
        @csrf
        @method('PUT')

        {{-- Staff Selector --}}
        <div class="mb-4">
            <label for="staff_id" class="form-label fw-semibold">👤 Staff</label>
            <select name="staff_id" class="form-select @error('staff_id') is-invalid @enderror" required>
                @foreach($staffs as $staff)
                    <option value="{{ $staff->id }}" {{ old('staff_id', $application->staff_id) == $staff->id ? 'selected' : '' }}>
                        {{ $staff->name }} - {{ $staff->designation }}
                    </option>
                @endforeach
            </select>
            @error('staff_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Equipment List --}}
        <div class="mb-4">
            <h5 class="d-flex justify-content-between align-items-center">
                🖥️ Equipment List
                <button type="button" class="btn btn-sm btn-outline-dark" onclick="addEditRow()">
                    <i class="bi bi-plus-circle"></i> Add Equipment
                </button>
            </h5>

            <div id="edit-equipments">
                @foreach(old('equipments', $application->equipments->toArray()) as $index => $equipment)
                    <div class="row mb-2 align-items-start">
                        <div class="col-md-3">
                            <textarea name="equipments[{{ $index }}][name]" class="form-control auto-resize @error("equipments.$index.name") is-invalid @enderror" placeholder="Description" oninput="autoResize(this)">{{ old("equipments.$index.name", $equipment['name']) }}</textarea>
                            @error("equipments.$index.name")
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <textarea name="equipments[{{ $index }}][model_brand]" class="form-control auto-resize @error("equipments.$index.model_brand") is-invalid @enderror" placeholder="Model/Brand" oninput="autoResize(this)">{{ old("equipments.$index.model_brand", $equipment['model_brand']) }}</textarea>
                            @error("equipments.$index.model_brand")
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <textarea name="equipments[{{ $index }}][serial_number]" class="form-control auto-resize @error("equipments.$index.serial_number") is-invalid @enderror" placeholder="Serial Number" oninput="autoResize(this)">{{ old("equipments.$index.serial_number", $equipment['serial_number']) }}</textarea>
                            @error("equipments.$index.serial_number")
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="equipments[{{ $index }}][quantity]" class="form-control @error("equipments.$index.quantity") is-invalid @enderror" value="{{ old("equipments.$index.quantity", $equipment['quantity']) }}" min="1" placeholder="Qty">
                            @error("equipments.$index.quantity")
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-1 text-center">
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)">&times;</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Submit Buttons --}}
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
    let editRowCount = {{ count(old('equipments', $application->equipments)) }};

    function addEditRow() {
        const container = document.getElementById('edit-equipments');
        const row = document.createElement('div');
        row.classList.add('row', 'mb-2', 'align-items-center');

        row.innerHTML = `
            <div class="col-md-3">
                <textarea name="equipments[${editRowCount}][name]" class="form-control auto-resize" placeholder="Description" oninput="autoResize(this)"></textarea>
            </div>
            <div class="col-md-3">
                <textarea name="equipments[${editRowCount}][model_brand]" class="form-control auto-resize" placeholder="Model/Brand" oninput="autoResize(this)"></textarea>
            </div>
            <div class="col-md-3">
                <textarea name="equipments[${editRowCount}][serial_number]" class="form-control auto-resize" placeholder="Serial Number" oninput="autoResize(this)"></textarea>
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

    function confirmMarkReturned(applicationId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This will mark the application as returned.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, mark as returned',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('return-form-' + applicationId).submit();
            }
        });
    }

    function autoResize(textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.auto-resize').forEach(el => {
            autoResize(el);
            el.addEventListener('input', () => autoResize(el));
        });
    });
</script>

{{-- CSS --}}
<style>
    .auto-resize {
        overflow: hidden;
        resize: none;
        min-height: 38px;
        transition: height 0.2s ease;
    }
</style>
@endsection
