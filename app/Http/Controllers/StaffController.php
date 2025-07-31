<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;
use App\Models\UserAction;


class StaffController extends Controller
{
    // public function index()
    // {
    //     $staffs = Staff::all();
    //     return view('staff.index', compact('staffs'));
    // }
 public function index(Request $request)
{
    $query = Staff::query();

    // Filtering
    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('email', 'like', '%' . $request->search . '%');
        });
    }

    if ($request->filled('system_office')) {
        $query->where('system_office', $request->system_office);
    }

    if ($request->filled('designation')) {
        $query->where('designation', $request->designation);
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Sorting
    $allowedSorts = ['name', 'email', 'system_office', 'designation', 'status'];
    $sortBy = in_array($request->get('sort_by'), $allowedSorts) ? $request->get('sort_by') : 'name';
    $sortOrder = $request->get('sort_order') === 'desc' ? 'desc' : 'asc';

    $query->orderBy($sortBy, $sortOrder);

    // Pagination with query persistence
    $staffs = $query->paginate(10)->withQueryString();

    // Dropdown filters
    $offices = Staff::select('system_office')->distinct()->pluck('system_office');
    $designations = Staff::select('designation')->distinct()->pluck('designation');

    return view('staff.index', compact('staffs', 'offices', 'designations'));
}



    public function create()
    {
        return view('staff.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:staff',
            'system_office' => 'required',
            'designation' => 'required',
            'department' => 'required',
            'status' => 'required|in:active,resigned'
        ]);

        Staff::create([
            'name' => $request->name,
            'email' => $request->email,
            'system_office' => $request->system_office,
            'designation' => $request->designation,
            'department' => $request->department,
            'status' => $request->status
        ]);

        // Log action
                UserAction::log(
            'Created',
            'Created a new staff record: ' . $request->name,
            'Staff',
            null // No specific ID for creation, can be null or omitted
        );

        return redirect()->route('staff.index')->with('success', 'Staff added successfully');
    }

        public function show(Staff $staff)
    {
        $staff->load(['applications.equipments']); // Load applications and their equipment
        return view('staff.show', [
            'staff' => $staff,
            'applications' => $staff->applications, // Explicitly pass applications if needed
        ]);
    }

    public function edit(Staff $staff)
    {
        return view('staff.edit', compact('staff'));
    }

    public function update(Request $request, Staff $staff)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:staff,email,' . $staff->id,
            'system_office' => 'required',
            'designation' => 'required',
            'department' => 'required',
            'status' => 'required|in:active,resigned'
        ]);

        $staff->update($request->only(['name', 'email', 'system_office', 'designation', 'department', 'status']));

        // Log action
        UserAction::log(
            'Updated',
            'Updated staff record: ' . $staff->name,
            'Staff',
            $staff->id
        );


        return redirect()->route('staff.index')->with('success', 'Staff updated successfully');
    }

        public function destroy(Staff $staff)
        {
            $staff->delete();

  

            return redirect()->route('staff.index')->with('success', 'Staff deleted successfully');
        }

            public function downloadStaffEquipmentSummary($id)
        {
            $staff = Staff::with('applications.equipments')->findOrFail($id);

            $pdf = Pdf::loadView('pdf.staff_all_equipments', compact('staff'));

              // Log action
            UserAction::log(
                'Deleted',
                'Deleted staff record: ' . $staff->name,
                'Staff',
                $staff->id
            );
            return $pdf->download('Staff_Equipment_Summary_' . $staff->name . '.pdf');
        }

        public function downloadStaffEquipmentCSV($id)
    {
        $staff = Staff::with('applications.equipments')->findOrFail($id);
        $filename = 'Staff_Equipment_Summary_' . preg_replace('/\s+/', '_', $staff->name) . '.csv';

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate",
            "Expires" => "0",
        ];

        $columns = ['Reference Number', 'Date Issued', 'Quantity', 'Description', 'Model/Brand', 'Serial Number'];

        $callback = function () use ($staff, $columns) {
            $file = fopen('php://output', 'w');

            // Header Info
            fputcsv($file, ['Staff Name:', $staff->name]);
            fputcsv($file, ['Email:', $staff->email]);
            fputcsv($file, ['Designation:', $staff->designation]);
            fputcsv($file, ['Department:', $staff->department]);
            fputcsv($file, ['System Office:', $staff->system_office]);
            fputcsv($file, []); // blank line

            fputcsv($file, $columns);

            foreach ($staff->applications as $application) {
                foreach ($application->equipments as $equipment) {
                    fputcsv($file, [
                        $application->reference_number,
                        $application->created_at->format('Y-m-d'),
                        $equipment->quantity,
                        $equipment->name,
                        $equipment->model_brand ?? '-',
                        $equipment->serial_number ?? '-',
                    ]);
                }
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
