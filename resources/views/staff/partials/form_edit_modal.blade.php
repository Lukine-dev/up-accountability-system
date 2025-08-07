<div class="modal fade" id="editStaffModal{{ $staff->id }}" tabindex="-1" aria-labelledby="editStaffModalLabel{{ $staff->id }}" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow border-0 rounded-4">
      <form action="{{ route('staff.update', $staff->id) }}" method="POST" novalidate>
        @csrf
        @method('PUT')

        <!-- Modal Header -->
        <div class="modal-header text-white" style="background-color: #90143c;">
          <h5 class="modal-title" id="editStaffModalLabel{{ $staff->id }}">
            <i class="bi bi-pencil-square me-2"></i>Edit Staff
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!-- Modal Body -->
        <div class="modal-body bg-light">
          <div class="row g-3">
            <div class="col-md-6 form-floating">
              <input type="text" 
                     class="form-control @error('name') is-invalid @enderror"
                     id="name{{ $staff->id }}" 
                     name="name" 
                     value="{{ old('name', $staff->name) }}"
                     placeholder="Name" required>
              <label for="name{{ $staff->id }}">Full Name</label>
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6 form-floating">
              <input type="email" 
                     class="form-control @error('email') is-invalid @enderror" 
                     id="email{{ $staff->id }}" 
                     name="email" 
                     value="{{ old('email', $staff->email) }}" 
                     placeholder="Email" required>
              <label for="email{{ $staff->id }}">Email Address</label>
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6 form-floating">
              <input type="text" 
                     class="form-control @error('system_office') is-invalid @enderror"
                     id="system_office{{ $staff->id }}" 
                     name="system_office" 
                     value="{{ old('system_office', $staff->system_office) }}" 
                     placeholder="System Office">
              <label for="system_office{{ $staff->id }}">System Office</label>
              @error('system_office')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6 form-floating">
              <input type="text" 
                     class="form-control @error('designation') is-invalid @enderror"
                     id="designation{{ $staff->id }}" 
                     name="designation" 
                     value="{{ old('designation', $staff->designation) }}" 
                     placeholder="Designation">
              <label for="designation{{ $staff->id }}">Designation</label>
              @error('designation')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-12 form-floating">
              <input type="text" 
                     class="form-control @error('department') is-invalid @enderror"
                     id="department{{ $staff->id }}" 
                     name="department" 
                     value="{{ old('department', $staff->department) }}" 
                     placeholder="Department">
              <label for="department{{ $staff->id }}">Department / Unit</label>
              @error('department')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6 form-floating">
              <select class="form-select @error('status') is-invalid @enderror" 
                      id="status{{ $staff->id }}" 
                      name="status" required>
                <option value="" disabled {{ old('status', $staff->status) ? '' : 'selected' }}>Choose...</option>
                <option value="active" {{ old('status', $staff->status) == 'active' ? 'selected' : '' }}>Active</option>
                <option value="resigned" {{ old('status', $staff->status) == 'resigned' ? 'selected' : '' }}>Resigned</option>
              </select>
              <label for="status{{ $staff->id }}">Employment Status</label>
              @error('status')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>

        <!-- Modal Footer -->
        <div class="modal-footer bg-white">
          <button type="submit" class="btn text-white" style="background-color: #90143c;">
            <i class="bi bi-check-circle me-1"></i>Update
          </button>
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            <i class="bi bi-x-circle me-1"></i>Cancel
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
