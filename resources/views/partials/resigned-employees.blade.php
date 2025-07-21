<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Last Updated</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $employee)
                    <tr>
                        <td>{{ $employee->name }}</td>
                        {{-- <td>{{ $employee->designation }}</td> --}}
                        <td>{{ $employee->department }}</td>
                        <td>{{ $employee->updated_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">No resigned employees found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>