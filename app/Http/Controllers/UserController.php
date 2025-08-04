<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAction;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    public function history()
    {
        $logs = UserAction::with('user')->latest()->paginate(15);
        return view('history', compact('logs'));
    }

    public function deleteHistoryByDate(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        UserAction::whereDate('created_at', $request->date)->delete();

        return redirect()->back()->with('success', 'Logs from ' . $request->date . ' deleted successfully.');
    }

    public function export(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        $logs = UserAction::with('user')
            ->whereDate('created_at', $request->date)
            ->latest()
            ->get();

        $filename = 'logs_' . $request->date . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$filename",
        ];

        $callback = function () use ($logs) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['User', 'Action', 'Model', 'Model ID', 'Description', 'Date']);

            foreach ($logs as $log) {
                fputcsv($handle, [
                    $log->user?->name ?? 'System',
                    $log->action,
                    $log->model,
                    $log->model_id ?? '-',
                    $log->description,
                    $log->created_at->format('Y-m-d H:i:s')
                ]);
            }
            fclose($handle);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function previewCount(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        $count = UserAction::whereDate('created_at', $request->date)->count();

        return response()->json(['count' => $count]);
    }

    public function filterByDate(Request $request)
    {
        $date = $request->query('date');

        $logs = UserAction::with('user')
            ->when($date, fn ($query) => $query->whereDate('created_at', $date))
            ->latest()
            ->get();

        return view('partials.logs_table_rows', compact('logs'))->render();
    }
}
