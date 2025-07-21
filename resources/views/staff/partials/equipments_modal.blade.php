<!-- Modal -->
<div class="modal fade" id="equipmentsModal{{ $staff->id }}" tabindex="-1" aria-labelledby="equipmentsModalLabel{{ $staff->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content shadow border-0 rounded-4">
            <!-- Modal Header -->
            <div class="modal-header text-white" style="background-color: #90143c;">
                <h5 class="modal-title" id="equipmentsModalLabel{{ $staff->id }}">
                    <i class="bi bi-person-badge-fill me-2"></i>
                    Equipments Released – <strong>{{ $staff->name }}</strong>
                    <span class="badge bg-{{ $staff->status === 'active' ? 'success' : 'danger' }} ms-2">
                        {{ ucfirst($staff->status) }}
                    </span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body bg-light">
                <div class="mb-4">
                    <h6 class="text-muted">System Office:</h6>
                    <p class="fw-semibold text-dark mb-1">{{ $staff->system_office }}</p>
                    <div class="d-flex gap-2">
                        <a href="{{ route('staff.show', $staff->id) }}" class="btn btn-sm" style="background-color: #90143c; color: white;">
                            <i class="bi bi-card-list"></i> View Full Profile
                        </a>
                        <a href="{{ route('staff.equipment.summary', $staff->id) }}" class="btn btn-sm btn-outline-danger" style="border-color: #90143c; color: #90143c;" target="_blank">
                            <i class="bi bi-printer-fill"></i> Print Summary (PDF)
                        </a>
                          <a href="{{ route('staff.downloadEquipmentCSV', $staff->id) }}" class="btn btn-outline-success btn-sm">
                            <i class="bi bi-file-earmark-spreadsheet me-2"></i> Print Summary (CSV)
                        </a>
                    </div>
                </div>

                @forelse ($staff->applications as $application)
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-header bg-white fw-semibold">
                            <i class="bi bi-receipt-cutoff me-2" style="color: #90143c;"></i>
                            Ref #: {{ $application->reference_number }}
                            <span class="float-end text-muted small">
                                {{ \Carbon\Carbon::parse($application->application_date)->format('F d, Y') }}
                            </span>
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach ($application->equipments as $equipment)
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="me-3">
                                        <strong>{{ $equipment->name }}</strong><br>
                                        <small class="text-muted">
                                            {{ $equipment->model_brand ?? '-' }} — SN: {{ $equipment->serial_number ?? '-' }}
                                        </small>
                                    </div>
                                    <span class="badge rounded-pill text-bg-light border" style="color: #90143c; border-color: #90143c;">
                                        {{ $equipment->quantity }}x
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @empty
                    <div class="alert alert-secondary text-center">
                        <i class="bi bi-exclamation-circle me-2"></i>No released equipment found.
                    </div>
                @endforelse
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer bg-white">
                <button type="button" class="btn" style="background-color: #90143c; color: white;" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>
