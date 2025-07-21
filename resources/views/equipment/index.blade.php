@extends('layouts.app')

@section('title', 'Issued Equipment Records')

@section('content')
<div class="container py-4">

   <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-maroon fw-bold mb-0">Issued Equipment Records</h1>

        <a href="{{ route('equipment.downloadCSV') }}" class="btn btn-success d-inline-flex align-items-center">
            <i class="bi bi-file-earmark-csv me-2"></i> Export Issued Equipment CSV
        </a>
    </div>

    {{-- Filter Inputs --}}
    <div class="row g-2 mb-4">
        <div class="col-md-4">
            <input type="text" id="searchInput" class="form-control" placeholder="Search name or model...">
        </div>
        <div class="col-md-4">
            <input type="text" id="departmentInput" class="form-control" placeholder="Filter by department...">
        </div>
        <div class="col-md-4">
            <input type="text" id="officeInput" class="form-control" placeholder="Filter by office...">
        </div>
    </div>


    <!-- Loader Spinner -->
    <div id="loader" class="text-center my-3" style="display: none;">
        <div class="spinner-border text-maroon" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    {{-- Accordion Container --}}
    <div id="accordionResults">
        @include('equipment.partials.accordion', ['paginator' => $paginator])
    </div>
</div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('searchInput');
        const departmentInput = document.getElementById('departmentInput');
        const officeInput = document.getElementById('officeInput');
        const loader = document.getElementById('loader');
        const accordionResults = document.getElementById('accordionResults');

        let debounceTimer;

        const fetchFilteredResults = (url = null) => {
            loader.style.display = 'block'; // Show loader

            const params = new URLSearchParams({
                search: searchInput.value,
                department: departmentInput.value,
                office: officeInput.value
            });

            const requestUrl = url ?? `{{ route('equipment.live-search') }}?${params.toString()}`;

            fetch(requestUrl)
                .then(response => response.text())
                .then(html => {
                    accordionResults.innerHTML = html;
                })
                .finally(() => {
                    loader.style.display = 'none'; // Hide loader after content loads
                });
        };

        const debounceFetch = () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => fetchFilteredResults(), 300);
        };

        searchInput.addEventListener('input', debounceFetch);
        departmentInput.addEventListener('input', debounceFetch);
        officeInput.addEventListener('input', debounceFetch);

        // Listen to pagination clicks
        document.addEventListener('click', function (e) {
            if (e.target.matches('.pagination a')) {
                e.preventDefault();
                fetchFilteredResults(e.target.href);
            }
        });
    });
</script>


<style>
    .text-maroon { color: #90143c; }

    .btn-theme {
        background-color: #90143c;
        color: white;
    }

    .btn-theme:hover {
        background-color: #6f0f2e;
        color: white;
    }
    .spinner-border.text-maroon {
        border-color: #90143c;
        border-right-color: transparent;
    }
</style>

