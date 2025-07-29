@extends('layouts.app')

@section('content')
<style>
    :root {
        --theme-color: #90143c;
        --theme-light: #fce6ec;
    }

    .text-theme {
        color: var(--theme-color);
    }

    .bg-theme {
        background-color: var(--theme-color);
        color: white;
    }

    .card-theme {
        border-left: 5px solid var(--theme-color);
        border-radius: 12px;
        background: white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.07);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        animation: fadeInUp 0.5s ease;
    }

    .card-theme:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
    }

    .icon-circle {
        background-color: #f9dfe6;
        color: var(--theme-color);
        border-radius: 50%;
        padding: 0.7rem;
        font-size: 1.5rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
    }

    .quick-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        background: var(--theme-light);
        border: 1px solid #eee;
        padding: 0.9rem 1.2rem;
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.2s ease-in-out;
        animation: fadeIn 0.6s ease;
    }

    .quick-link:hover {
        background: #f5d1db;
        text-decoration: none;
        transform: scale(1.02);
    }

    .section-title {
        color: var(--theme-color);
        border-bottom: 2px solid var(--theme-color);
        padding-bottom: 0.4rem;
        margin-bottom: 1.5rem;
        font-weight: 600;
        animation: fadeInDown 0.5s ease;
    }

    @keyframes fadeInUp {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="container py-4">
    <h1 class="mb-4 text-theme">🏠 ICT Home Dashboard</h1>

    {{-- Info Cards --}}
    <div class="row g-4 mb-4">
                <!-- Total Staff Card -->
                <div class="col-md-6">
                    <div class="card card-theme p-4 d-flex flex-row align-items-center shadow-sm gap-3">
                        <div class="icon-circle bg-maroon text-white  me-3">
                            <i class="bi bi-people-fill fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Total Staff</h6>
                            <h4 class="mb-0">{{ $totalStaff }}</h4>
                        </div>

                         <div class="icon-circle bg-success text-white me-3">
                            <i class="bi bi-person-check-fill fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Active Staff</h6>
                            <h4 class="mb-0">{{ $activeStaff }}</h4>
                        </div>
                        <div class="icon-circle bg-danger text-white me-3">
                            <i class="bi bi-person-dash-fill fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Resigned Staff</h6>
                            <h4 class="mb-0">{{ $resignedStaff }}</h4>
                        </div>

                    </div>
                </div>
            
          <div class="col-md-3">
            <div class="card card-theme p-4 d-flex flex-row align-items-center">
                <div class="icon-circle me-3">
                    <i class="bi bi-file-earmark-text-fill"></i>
                </div>
                <div>
                    <h6 class="mb-1">Total Accountability Forms</h6>
                    <h4 class="mb-0">{{ $totalApplications }}</h4>
                </div>
            </div>
        </div>
         
        <div class="col-md-3">
            <div class="card card-theme p-4 d-flex flex-row align-items-center">
                <div class="icon-circle me-3">
                    <i class="bi bi-box-arrow-up-right"></i>
                </div>
                <div>
                    <h6 class="mb-1">Equipment Released</h6>
                    <h4 class="mb-0">{{ $totalEquipmentReleased }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Search --}}
    <h5 class="section-title">🔍 Quick Search</h5>
    <div class="row g-3 mb-5">
        <div class="col-md-4">
            <form method="GET" action="{{ route('staff.index') }}">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search Staff by name/email...">
                    <button class="btn btn-theme" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>
        <div class="col-md-4">
            <form method="GET" action="{{ route('applications.index') }}">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search Form reference number">
                    <button class="btn btn-theme" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>
         <div class="col-md-4">
            <form method="GET" action="{{ route('equipment.index') }}">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search Equipment">
                    <button class="btn btn-theme" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Quick Navigation --}}
    <h5 class="section-title">🔗 Quick Navigation</h5>
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <a href="{{ route('staff.index') }}" class="quick-link">
                <i class="bi bi-people-fill"></i> View Staff List
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('applications.index') }}" class="quick-link">
                <i class="bi bi-journal-text"></i> View Accountability Forms
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('equipment.index') }}" class="quick-link">
                <i class="bi bi-box-seam"></i> View Released Equipment
            </a>
        </div>
    </div>


            {{-- Department Filter --}}
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                  <div class="card card-theme mb-3">
                    <div class="card-header bg-theme d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">🧾 Recently Resigned Staff</h5>
                        <select id="departmentFilter" class="form-select w-auto">
                            <option value="">All Departments</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept }}">{{ $dept }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="resignedEmployeesTable">
                        @include('partials.resigned-employees', ['employees' => $resignedEmployees])
                    </div>
                </div>     
            </div>
            
             <div class="col-md-6">
                  <div class="card card-theme mb-3">
                    <div class="card-header bg-theme d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"> <i class="bi bi-person-check-fill fs-4 me-1"></i> Recently Added Staff</h5>
                        <select id="departmentFilter2" class="form-select w-auto">
                            <option value="">All Departments</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept }}">{{ $dept }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="latestEmployeesTable">
                        @include('partials.latest-employees', ['employees' => $latestEmployees])
                    </div>
                </div>     
            </div>
              
        </div>

                <div class="mt-5">
            <h4>System Users</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-sm table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Registered At</th>
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
             <!-- Pagination Links -->
            <div class="d-flex justify-content-center mt-3">
                {{ $users->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>

          
    </div>
</div>



{{-- Include Bootstrap Icons --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


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
