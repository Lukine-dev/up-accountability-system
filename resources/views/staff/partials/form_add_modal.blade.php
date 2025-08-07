<div class="modal fade" id="addStaffModal" tabindex="-1" aria-labelledby="addStaffModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow border-0 rounded-4">
      <form action="{{ route('staff.store') }}" method="POST">
        @csrf

        <!-- Modal Header -->
        <div class="modal-header text-white" style="background-color: #90143c;">
          <h5 class="modal-title" id="addStaffModalLabel">
            <i class="bi bi-person-plus-fill me-2"></i>Add New Staff
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!-- Modal Body -->
        <div class="modal-body bg-light">
          <div class="row g-3">

            <div class="col-md-6 form-floating">
              <input type="text" class="form-control @error('name') is-invalid @enderror"
                     id="name" name="name" placeholder="Full Name"
                     value="{{ old('name') }}" required>
              <label for="name">Full Name</label>
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6 form-floating">
              <input type="email" class="form-control @error('email') is-invalid @enderror"
                     id="email" name="email" placeholder="Email Address"
                     value="{{ old('email') }}" required>
              <label for="email">Email Address</label>
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6 form-floating">
              <input type="text" class="form-control @error('system_office') is-invalid @enderror"
                     id="system_office" name="system_office" placeholder="System Office"
                     value="{{ old('system_office') }}">
              <label for="system_office">System Office</label>
              @error('system_office')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6 form-floating">
              <input type="text" class="form-control @error('designation') is-invalid @enderror"
                     id="designation" name="designation" placeholder="Designation"
                     value="{{ old('designation') }}">
              <label for="designation">Designation</label>
              @error('designation')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-12 form-floating">
              <input type="text" class="form-control @error('department') is-invalid @enderror"
                     id="department" name="department" placeholder="Department"
                     value="{{ old('department') }}">
              <label for="department">Department / Unit</label>
              @error('department')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6 form-floating">
              <select class="form-select @error('status') is-invalid @enderror"
                      id="status" name="status" required>
                <option value="" disabled {{ old('status') ? '' : 'selected' }}>Choose...</option>
                <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="resigned" {{ old('status') === 'resigned' ? 'selected' : '' }}>Resigned</option>
              </select>
              <label for="status">Employment Status</label>
              @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

          </div>
        </div>

        <!-- Modal Footer -->
        <div class="modal-footer bg-white">
          <button type="submit" class="btn text-white" style="background-color: #90143c;">
            <i class="bi bi-check-circle me-1"></i>Submit
          </button>
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            <i class="bi bi-x-circle me-1"></i>Cancel
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
