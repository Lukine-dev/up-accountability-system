<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Application;
use Illuminate\Support\Facades\Response;

class EquipmentController extends Controller
{
    public function index(Request $request)
    {
        $applications = Application::with(['equipments', 'staff'])->get();
        $equipmentList = collect();

        foreach ($applications as $app) {
            foreach ($app->equipments as $eq) {
                $equipmentList->push([
                    'equipment' => $eq,
                    'staff' => $app->staff,
                    'issued_at' => $app->created_at,
                ]);
            }
        }

        $grouped = $equipmentList->groupBy(fn($item) => $item['equipment']->name . ' - ' . $item['equipment']->model_brand);

        // Paginate initial load
        $groupKeys = $grouped->keys();
        $perPage = 10;
        $currentPage = $request->input('page', 1);
        $pagedKeys = $groupKeys->slice(($currentPage - 1) * $perPage, $perPage);

        $pagedGroups = collect();
        foreach ($pagedKeys as $key) {
            $pagedGroups[$key] = $grouped[$key];
        }

        $paginator = new LengthAwarePaginator(
            $pagedGroups,
            $groupKeys->count(),
            $perPage,
            $currentPage,
            ['path' => url()->current(), 'pageName' => 'page']
        );

        return view('equipment.index', compact('paginator'));
    }
        public function liveSearch(Request $request)
    {
        $search = $request->input('search');
        $department = $request->input('department');
        $office = $request->input('office');

        $applications = Application::with(['equipments', 'staff'])->get();

        $equipmentList = collect();

        foreach ($applications as $app) {
            foreach ($app->equipments as $eq) {
                $matchesSearch = !$search || str_contains(strtolower($eq->name . ' ' . $eq->model_brand), strtolower($search));
                $matchesDepartment = !$department || str_contains(strtolower($app->staff->department), strtolower($department));
                $matchesOffice = !$office || str_contains(strtolower($app->staff->system_office), strtolower($office));

                if ($matchesSearch && $matchesDepartment && $matchesOffice) {
                    $equipmentList->push([
                        'equipment' => $eq,
                        'staff' => $app->staff,
                        'issued_at' => $app->created_at,
                    ]);
                }
            }
        }

        $grouped = $equipmentList->groupBy(fn($item) => $item['equipment']->name . ' - ' . $item['equipment']->model_brand);

        // Paginate the groups
        $groupKeys = $grouped->keys();
        $perPage = 10;
        $currentPage = $request->input('page', 1);
        $pagedKeys = $groupKeys->slice(($currentPage - 1) * $perPage, $perPage);

        $pagedGroups = collect();
        foreach ($pagedKeys as $key) {
            $pagedGroups[$key] = $grouped[$key];
        }

        $paginator = new LengthAwarePaginator(
            $pagedGroups,
            $groupKeys->count(),
            $perPage,
            $currentPage,
            ['path' => url()->current(), 'pageName' => 'page']
        );

        return view('equipment.partials.accordion', compact('paginator'))->render();
    }

        
        public function downloadCSV()
    {
        $applications = Application::with(['equipments', 'staff'])->get();
        $equipmentList = collect();

        foreach ($applications as $app) {
            foreach ($app->equipments as $eq) {
                $equipmentList->push([
                    'Reference Number' => $app->reference_number,
                    'Date Issued' => $app->created_at->format('Y-m-d'),
                    'Staff Name' => $app->staff->name,
                    'Designation' => $app->staff->designation,
                    'Department' => $app->staff->department,
                    'System Office' => $app->staff->system_office,
                    'Equipment Name' => $eq->name,
                    'Description' => $eq->description ?? '-',
                    'Model/Brand' => $eq->model_brand ?? '-',
                    'Serial Number' => $eq->serial_number ?? '-',
                    'Quantity' => $eq->quantity,
                ]);
            }
        }

        $filename = 'Issued_Equipment_List.csv';
        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate",
            "Expires" => "0",
        ];

        $callback = function () use ($equipmentList) {
            $file = fopen('php://output', 'w');

            // Write CSV headers
            fputcsv($file, array_keys($equipmentList->first()));

            // Write rows
            foreach ($equipmentList as $row) {
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
