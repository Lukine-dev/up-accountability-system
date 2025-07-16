<div class="modal fade" id="{{ isset($staff) ? 'editStaffModal'.$staff->id : 'addStaffModal' }}" tabindex="-1" aria-labelledby="staffModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow-lg">
      <form action="{{ isset($staff) ? route('staff.update', $staff->id) : route('staff.store') }}" method="POST">
        @csrf
        @if(isset($staff)) @method('PUT') @endif

        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="staffModalLabel">
            <i class="bi bi-person-badge-fill me-2"></i>{{ isset($staff) ? 'Edit Staff' : 'Add New Staff' }}
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6 form-floating">
              <input type="text" class="form-control" id="name" name="name" value="{{ $staff->name ?? '' }}" placeholder="Name" required>
              <label for="name">Full Name</label>
            </div>
            <div class="col-md-6 form-floating">
              <input type="email" class="form-control" id="email" name="email" value="{{ $staff->email ?? '' }}" placeholder="Email" required>
              <label for="email">Email Address</label>
            </div>
            <div class="col-md-6 form-floating">
              <input type="text" class="form-control" id="system_office" name="system_office" value="{{ $staff->system_office ?? '' }}" placeholder="System Office">
              <label for="system_office">System Office</label>
            </div>
            <div class="col-md-6 form-floating">
              <input type="text" class="form-control" id="designation" name="designation" value="{{ $staff->designation ?? '' }}" placeholder="Designation">
              <label for="designation">Designation</label>
            </div>
            <div class="col-md-12 form-floating">
              <input type="text" class="form-control" id="department" name="department" value="{{ $staff->department ?? '' }}" placeholder="Department">
              <label for="department">Department / Unit</label>
            </div>
            @if(!isset($staff))
            <div class="col-md-6 form-floating">
              <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
              <label for="password">Password</label>
            </div>
            @endif
            <div class="col-md-6 form-floating">
              <select class="form-select" id="status" name="status" required>
                  <option value="" disabled {{ !isset($staff) ? 'selected' : '' }}>Choose...</option>
                  <option value="active" {{ (isset($staff) && $staff->status == 'active') ? 'selected' : '' }}>Active</option>
                  <option value="resigned" {{ (isset($staff) && $staff->status == 'resigned') ? 'selected' : '' }}>Resigned</option>
              </select>
              <label for="status">Employment Status</label>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">
            <i class="bi bi-check-circle me-1"></i>{{ isset($staff) ? 'Update' : 'Submit' }}
          </button>
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            <i class="bi bi-x-circle me-1"></i>Cancel
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
