@extends('layouts.app')

@section('title', 'Issued Equipment Records')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-maroon fw-bold">Issued Equipment Records</h1>

    {{-- Search Form --}}
    <form method="GET" action="{{ url()->current() }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search equipment name or model...">
            <button type="submit" class="btn btn-theme">Search</button>
        </div>
    </form>

    {{-- Accordion --}}
    <div class="accordion" id="equipmentAccordion">
        @forelse($paginator as $equipmentKey => $entries)
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

    {{-- Pagination --}}
    <div class="mt-4">
           {{ $paginator->withQueryString()->links('vendor.pagination.bootstrap-5') }}
    </div>
</div>
@endsection

@push('styles')
<style>
    .text-maroon {
        color: #90143c;
    }

    .btn-theme {
        background-color: #90143c;
        color: white;
    }

    .btn-theme:hover {
        background-color: #6f0f2e;
        color: white;
    }
</style>
@endpush
