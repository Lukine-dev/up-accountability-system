@extends('layouts.app')

@section('title', 'Issued Equipment Monitor')

@section('content')
<div class="container mt-4">
    <h2 class="fw-bold text-center mb-4" style="color: #90143c;">📋 Issued Equipment Monitoring Table</h2>

    @include('components.issued_equipment_table', ['applications' => $applications])
</div>
@endsection



{{-- 
To use to other blade
@include('components.issued_equipment_table', ['applications' => $filteredApplications]) 

--}}