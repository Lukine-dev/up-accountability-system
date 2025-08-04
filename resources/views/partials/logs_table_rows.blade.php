@forelse ($logs as $log)
    <tr>
        <td class="fw-semibold">{{ $log->user?->name ?? 'System' }}</td>
        <td>
            <span class="badge
                @if($log->action === 'Created') bg-success
                @elseif($log->action === 'Updated') bg-warning text-dark
                @elseif($log->action === 'Deleted') bg-danger
                @else bg-secondary
                @endif">
                {{ $log->action }}
            </span>
        </td>
        <td>{{ $log->model }}</td>
        <td>{{ $log->model_id ?? '-' }}</td>
        <td>{{ $log->description }}</td>
        <td>{{ $log->created_at->format('Y-m-d H:i') }}</td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="text-center text-muted">No logs found.</td>
    </tr>
@endforelse
