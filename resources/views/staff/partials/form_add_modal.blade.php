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
              <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
              <label for="name">Full Name</label>
            </div>
            <div class="col-md-6 form-floating">
              <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
              <label for="email">Email Address</label>
            </div>
            <div class="col-md-6 form-floating">
              <input type="text" class="form-control" id="system_office" name="system_office" placeholder="System Office">
              <label for="system_office">System Office</label>
            </div>
            <div class="col-md-6 form-floating">
              <input type="text" class="form-control" id="designation" name="designation" placeholder="Designation">
              <label for="designation">Designation</label>
            </div>
            <div class="col-md-12 form-floating">
              <input type="text" class="form-control" id="department" name="department" placeholder="Department">
              <label for="department">Department / Unit</label>
            </div>
            <div class="col-md-6 form-floating">
              <select class="form-select" id="status" name="status" required>
                <option value="" disabled selected>Choose...</option>
                <option value="active">Active</option>
                <option value="resigned">Resigned</option>
              </select>
              <label for="status">Employment Status</label>
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
