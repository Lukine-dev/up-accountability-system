<div class="accordion" id="deviceAccordion">
    @forelse($paginator as $deviceType => $serials)
        @php
            $deviceId = Str::slug($deviceType) . '-panel';
        @endphp

        <div class="accordion-item mb-3 border border-dark-subtle shadow-sm rounded-2">
            <h2 class="accordion-header" id="heading-{{ $deviceId }}">
                <button class="accordion-button collapsed fw-semibold bg-white text-maroon" type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapse-{{ $deviceId }}"
                        aria-expanded="false" aria-controls="collapse-{{ $deviceId }}">
                    {{ $deviceType }}
                </button>
            </h2>

            <div id="collapse-{{ $deviceId }}" class="accordion-collapse collapse"
                 aria-labelledby="heading-{{ $deviceId }}"
                 data-bs-parent="#deviceAccordion">
                <div class="accordion-body">

                    {{-- Serial Number Accordion --}}
                    <div class="accordion" id="serialAccordion-{{ $deviceId }}">
                        @foreach($serials as $serialNumber => $history)
                            @php
                                $serialId = Str::slug($deviceType . '-' . $serialNumber);
                            @endphp

                            <div class="accordion-item mb-2 border border-secondary rounded-2">
                                <h2 class="accordion-header" id="heading-{{ $serialId }}">
                                    <button class="accordion-button collapsed bg-light" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapse-{{ $serialId }}"
                                            aria-expanded="false" aria-controls="collapse-{{ $serialId }}">
                                        Serial #: {{ $serialNumber }}
                                    </button>
                                </h2>

                                <div id="collapse-{{ $serialId }}" class="accordion-collapse collapse"
                                     aria-labelledby="heading-{{ $serialId }}"
                                     data-bs-parent="#serialAccordion-{{ $deviceId }}">
                                    <div class="accordion-body p-2">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered align-middle small mb-0">
                                                <thead class="table-light text-center">
                                                    <tr>
                                                        <th>Staff</th>
                                                        <th>Office</th>
                                                        <th>Department</th>
                                                        <th>Date Issued</th>
                                                        <th>Date Returned</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($history as $record)
                                                        <tr class="text-center">
                                                            <td>{{ $record['staff']->name ?? 'N/A' }}</td>
                                                            <td>{{ $record['staff']->system_office ?? 'N/A' }}</td>
                                                            <td>{{ $record['staff']->department ?? 'N/A' }}</td>
                                                            <td>{{ $record['issued_at'] ? $record['issued_at']->format('Y-m-d') : '-' }}</td>
                                                            <td>{{ $record['returned_at'] ? $record['returned_at']->format('Y-m-d') : '-' }}</td>
                                                            <td>
                                                                @if($record['status'] === 'returned')
                                                                    <span class="badge bg-danger">Returned</span>
                                                                @elseif($record['status'] === 'issued')
                                                                    <span class="badge bg-warning text-dark">Issued</span>
                                                                @else
                                                                    <span class="badge bg-success">{{ ucfirst($record['status']) }}</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-warning text-center">No issued equipment records found.</div>
    @endforelse
</div>

{{-- Pagination --}}
<div class="mt-4">
    {{ $paginator->withQueryString()->links('vendor.pagination.bootstrap-5') }}
</div>

{{-- Pagination --}}
<div class="mt-4">
    {{-- {!! $paginator->withQueryString()->('vendor.pagination.bootstrap-5') !!} --}}
    {{ $paginator->withQueryString()->links('vendor.pagination.bootstrap-5') }}
</div>