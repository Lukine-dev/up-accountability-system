@extends('layouts.app')

@section('title', 'Issued Equipment Records')

@section('content')
<div class="container py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 fw-normal text-muted">Issued Equipment</h2>
        <a href="{{ route('equipment.downloadCSV') }}" class="btn btn-sm btn-outline-dark">
            <i class="bi bi-download me-1"></i> Export CSV
        </a>
    </div>

    {{-- Filters --}}
    <div class="row g-2 mb-4">
        <div class="col-md-4">
            <input type="text" id="searchInput" class="form-control form-control-sm" 
                   placeholder="Search name/model">
        </div>
        <div class="col-md-4">
            <input type="text" id="departmentInput" class="form-control form-control-sm" 
                   placeholder="Department">
        </div>
        <div class="col-md-4">
            <input type="text" id="officeInput" class="form-control form-control-sm" 
                   placeholder="Office">
        </div>
    </div>

    {{-- Loader --}}
    <div id="loader" class="text-center my-3" style="display: none;">
        <div class="spinner-border spinner-border-sm text-dark" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    {{-- Results --}}
    <div id="accordionResults" class="border-top">
        @include('equipment.partials.accordion', ['paginator' => $paginator])
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('searchInput');
        const departmentInput = document.getElementById('departmentInput');
        const officeInput = document.getElementById('officeInput');
        const loader = document.getElementById('loader');
        const accordionResults = document.getElementById('accordionResults');

        let debounceTimer;

        const fetchFilteredResults = (url = null) => {
            loader.style.display = 'block';

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
                    loader.style.display = 'none';
                });
        };

        const debounceFetch = () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => fetchFilteredResults(), 300);
        };

        searchInput.addEventListener('input', debounceFetch);
        departmentInput.addEventListener('input', debounceFetch);
        officeInput.addEventListener('input', debounceFetch);

        document.addEventListener('click', function (e) {
            if (e.target.matches('.pagination a')) {
                e.preventDefault();
                fetchFilteredResults(e.target.href);
            }
        });
    });
</script>
@endsection