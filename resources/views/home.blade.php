@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary: #90143c;
        --primary-light: #fce6ec;
        --gray-100: #f8f9fa;
        --gray-200: #e9ecef;
        --gray-500: #adb5bd;
        --gray-800: #343a40;
    }

    /* Base Typography */
    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        color: var(--gray-800);
        line-height: 1.5;
    }

    /* Card Styles */
    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        overflow: hidden;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background: white;
        border-bottom: 1px solid var(--gray-200);
        padding: 1.25rem 1.5rem;
    }

    /* Metric Cards */
    .metric-card {
        padding: 1rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .metric-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .metric-value {
        font-size: 1.75rem;
        font-weight: 600;
        line-height: 1.2;
    }

    .metric-label {
        color: var(--gray-500);
        font-size: 0.875rem;
    }

    /* Navigation */
    .nav-card {
        padding: 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        background: white;
        border-radius: 12px;
        transition: all 0.2s ease;
    }

    .nav-card:hover {
        background: var(--primary-light);
        transform: translateY(-2px);
    }

    .nav-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: var(--primary-light);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    /* Tables */
    .data-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .data-table th {
        background: var(--gray-100);
        padding: 0.75rem 1rem;
        text-align: left;
        font-weight: 600;
        font-size: 0.875rem;
        color: var(--gray-800);
    }

    .data-table td {
        padding: 1rem;
        border-bottom: 1px solid var(--gray-200);
        vertical-align: middle;
    }

    .data-table tr:last-child td {
        border-bottom: none;
    }

    /* Utility Classes */
    .text-primary {
        color: var(--primary);
    }

    .bg-primary {
        background-color: var(--primary);
    }

    .bg-primary-light {
        background-color: var(--primary-light);
    }

    .rounded-lg {
        border-radius: 12px;
    }

    .shadow-xs {
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .transition {
        transition: all 0.2s ease;
    }
</style>

<div class="container mt-3 ">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 fw-bold text-maroon">ICT Dashboard</h1>
        <div class="text-muted small">Last updated: {{ now()->format('M j, Y H:i') }}</div>
    </div>


    <!-- Search Section - Retained and Enhanced -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="search-card">
                <form method="GET" action="{{ route('staff.index') }}">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control search-input" 
                               placeholder="Search staff..." aria-label="Search staff">
                        <button class="btn search-btn" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <div class="search-card">
                <form method="GET" action="{{ route('applications.index') }}">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control search-input" 
                               placeholder="Search forms..." aria-label="Search forms">
                        <button class="btn search-btn" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <div class="search-card">
                <form method="GET" action="{{ route('equipment.index') }}">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control search-input" 
                               placeholder="Search equipment..." aria-label="Search equipment">
                        <button class="btn search-btn" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>


    <!-- Metrics Grid -->
    <div class="row g-4 mb-4">
        <!-- Staff Metrics -->
        <div class="col-md-6">
            <div class="card h-auto ">
                <div class="card-header d-flex justify-content-between align-items-center " >
                    <h5 class="mb-0">Metrics</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="metric-card">
                                <div class="metric-icon bg-primary-light text-primary">
                                    <i class="bi bi-people-fill"></i>
                                </div>
                                <div>
                                    <div class="metric-value">{{ $totalStaff }}</div>
                                    <div class="metric-label">Total Staff</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="metric-card">
                                <div class="metric-icon bg-success bg-opacity-10 text-success">
                                    <i class="bi bi-person-check-fill"></i>
                                </div>
                                <div>
                                    <div class="metric-value">{{ $activeStaff }}</div>
                                    <div class="metric-label">Active</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="metric-card">
                                <div class="metric-icon bg-danger bg-opacity-10 text-danger">
                                    <i class="bi bi-person-dash-fill"></i>
                                </div>
                                <div>
                                    <div class="metric-value">{{ $resignedStaff }}</div>
                                    <div class="metric-label">Resigned</div>
                                </div>
                            </div>
                        </div>
                    </div>

                <div class="row mt-1">
                     <div class="col-md-12">
                        <div class="card h-auto " onclick="location.href='{{ route('applications.index') }}'" style="cursor: pointer;">
                            <div class="metric-card" style="border-top: 4px solid var(--primary);">
                                <div class="metric-icon bg-primary-light text-primary">
                                    <i class="bi bi-file-earmark-text"></i>
                                </div>
                                <div>
                                    <div class="metric-value">{{ $totalApplications }}</div>
                                    <div class="metric-label">Accountability Forms</div>
                                </div>
                            </div>
                        </div>
                    </div>
           
                    {{-- <div class="col-md-6">
                        <div class="card h-auto" onclick="location.href='{{ route('equipment.index') }}'" style="cursor: pointer;">
                                <div class="metric-card" style="border-top: 4px solid var(--primary);">
                                    <div class="metric-icon bg-primary-light text-primary">
                                        <i class="bi bi-box-seam"></i>
                                    </div>
                                    <div>
                                        <div class="metric-value">{{ $totalEquipmentReleased }}</div>
                                        <div class="metric-label">Equipment Released</div>
                                    </div>
                                </div>   
                               </div>
                    </div> --}}
                </div>
                   
                             

                </div>
            </div>
        </div>

        <!-- Other Metrics -->
        <div class="col-md-6">
                <div class="">
    
                    <a href="{{ route('staff.index') }}" class="nav-card text-decoration-none mb-3">
                        <div class="nav-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div>
                            <div class="fw-medium">Staff List</div>
                            <div class="text-muted small">Manage all staff members</div>
                        </div>
                    </a>
     
                    <a href="{{ route('applications.index') }}" class="nav-card text-decoration-none mb-3">
                        <div class="nav-icon">
                            <i class="bi bi-journal-text"></i>
                        </div>
                        <div>
                            <div class="fw-medium">Accountability Forms</div>
                            <div class="text-muted small">View all forms</div>
                        </div>
                    </a>
      
                    <a href="{{ route('equipment.index') }}" class="nav-card text-decoration-none ">
                        <div class="nav-icon">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <div>
                            <div class="fw-medium">Equipment</div>
                            <div class="text-muted small">Track released items</div>
                        </div>
                    </a>

            </div>
        </div>

   

             {{-- <div class="col-md-6">
                 
    <!-- System Users -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">System Users</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Registered</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->created_at->format('Y-m-d H:i') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        {{ $users->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div> --}}
    </div>
    

</div>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<!-- Inter Font -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filter = document.getElementById('departmentFilter');
        filter.addEventListener('change', function () {
            const department = this.value;
            fetch(`/resigned-employees?department=${department}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.text())
            .then(html => {
                document.getElementById('resignedEmployeesTable').innerHTML = html;
            })
            .catch(err => console.error('Error:', err));
        });
    });
      document.addEventListener('DOMContentLoaded', function () {
        const filter = document.getElementById('departmentFilter2');
        filter.addEventListener('change', function () {
            const department = this.value;
            fetch(`/latest-employees?department=${department}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.text())
            .then(html => {
                document.getElementById('latestEmployeesTable').innerHTML = html;
            })
            .catch(err => console.error('Error:', err));
        });
    });
</script>

@endsection
