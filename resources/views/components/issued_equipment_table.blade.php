{{-- <div class="accordion" id="equipmentAccordion">
    @php
        $equipmentList = collect();

        foreach ($applications as $app) {
            foreach ($app->equipments as $eq) {
                $equipmentList->push([
                    'equipment' => $eq,
                    'staff' => $app->staff,
                    'issued_at' => $app->created_at,
                ]);
            }
        }

        $groupedByEquipment = $equipmentList->groupBy(fn($item) => $item['equipment']->name . ' - ' . $item['equipment']->model_brand);
    @endphp

    @forelse($groupedByEquipment as $equipmentKey => $entries)
        @php
            $accordionId = Str::slug($equipmentKey) . '-panel';
        @endphp

        <div class="accordion-item mb-3 border border-secondary shadow-sm">
            <h2 class="accordion-header" id="heading-{{ $accordionId }}">
                <button class="accordion-button collapsed fw-semibold bg-white text-maroon" type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapse-{{ $accordionId }}"
                        aria-expanded="false" aria-controls="collapse-{{ $accordionId }}">
                    {{ $equipmentKey }}
                </button>
            </h2>

            <div id="collapse-{{ $accordionId }}" class="accordion-collapse collapse"
                 aria-labelledby="heading-{{ $accordionId }}"
                 data-bs-parent="#equipmentAccordion">
                <div class="accordion-body p-3">

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered align-middle small">
                            <thead class="table-light">
                                <tr>
                                    <th>Serial No.</th>
                                    <th>Office</th>
                                    <th>Department</th>
                                    <th>Staff</th>
                                    <th>Date Issued</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($entries as $entry)
                                    <tr>
                                        <td>{{ $entry['equipment']->serial_number }}</td>
                                        <td>{{ $entry['staff']->system_office }}</td>
                                        <td>{{ $entry['staff']->department }}</td>
                                        <td>{{ $entry['staff']->name }}</td>
                                        <td>{{ $entry['issued_at']->format('Y-m-d') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info text-center">No issued equipment records found.</div>
    @endforelse
</div> --}}



<div class="accordion" id="equipmentAccordion">
    @forelse($grouped as $equipmentKey => $entries)
        @php
            $accordionId = Str::slug($equipmentKey) . '-panel';
        @endphp

        <div class="accordion-item mb-3 border border-secondary shadow-sm">
            <h2 class="accordion-header" id="heading-{{ $accordionId }}">
                <button class="accordion-button collapsed fw-semibold bg-white text-maroon" type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapse-{{ $accordionId }}"
                        aria-expanded="false" aria-controls="collapse-{{ $accordionId }}">
                    {{ $equipmentKey }}
                </button>
            </h2>

            <div id="collapse-{{ $accordionId }}" class="accordion-collapse collapse"
                 aria-labelledby="heading-{{ $accordionId }}"
                 data-bs-parent="#equipmentAccordion">
                <div class="accordion-body p-3">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered align-middle small">
                            <thead class="table-light">
                                <tr>
                                    <th>Serial No.</th>
                                    <th>Office</th>
                                    <th>Department</th>
                                    <th>Staff</th>
                                    <th>Date Issued</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($entries as $entry)
                                    <tr>
                                        <td>{{ $entry['equipment']->serial_number }}</td>
                                        <td>{{ $entry['staff']->system_office }}</td>
                                        <td>{{ $entry['staff']->department }}</td>
                                        <td>{{ $entry['staff']->name }}</td>
                                        <td>{{ $entry['issued_at']->format('Y-m-d') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info text-center">No issued equipment records found.</div>
    @endforelse
</div>
