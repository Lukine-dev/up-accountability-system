<div class="modal fade" id="editStaffModal{{ $staff->id }}" tabindex="-1" aria-labelledby="editStaffModalLabel{{ $staff->id }}" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow border-0 rounded-4">
      <form action="{{ route('staff.update', $staff->id) }}" method="POST">
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
              <input type="text" class="form-control" id="name{{ $staff->id }}" name="name" value="{{ $staff->name }}" placeholder="Name" required>
              <label for="name{{ $staff->id }}">Full Name</label>
            </div>
            <div class="col-md-6 form-floating">
              <input type="email" class="form-control" id="email{{ $staff->id }}" name="email" value="{{ $staff->email }}" placeholder="Email" required>
              <label for="email{{ $staff->id }}">Email Address</label>
            </div>
            <div class="col-md-6 form-floating">
              <input type="text" class="form-control" id="system_office{{ $staff->id }}" name="system_office" value="{{ $staff->system_office }}" placeholder="System Office">
              <label for="system_office{{ $staff->id }}">System Office</label>
            </div>
            <div class="col-md-6 form-floating">
              <input type="text" class="form-control" id="designation{{ $staff->id }}" name="designation" value="{{ $staff->designation }}" placeholder="Designation">
              <label for="designation{{ $staff->id }}">Designation</label>
            </div>
            <div class="col-md-12 form-floating">
              <input type="text" class="form-control" id="department{{ $staff->id }}" name="department" value="{{ $staff->department }}" placeholder="Department">
              <label for="department{{ $staff->id }}">Department / Unit</label>
            </div>
            <div class="col-md-6 form-floating">
              <select class="form-select" id="status{{ $staff->id }}" name="status" required>
                <option value="active" {{ $staff->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="resigned" {{ $staff->status == 'resigned' ? 'selected' : '' }}>Resigned</option>
              </select>
              <label for="status{{ $staff->id }}">Employment Status</label>
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
