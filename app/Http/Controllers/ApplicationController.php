<?php
namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Staff;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ApplicationController extends Controller
{
   public function index(Request $request)
{
    $query = Application::with('staff');

    // Search Filters
    if ($request->filled('search')) {
        $query->where('reference_number', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('staff')) {
        $query->whereHas('staff', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->staff . '%');
        });
    }

    if ($request->filled('designation')) {
        $query->whereHas('staff', function ($q) use ($request) {
            $q->where('designation', $request->designation);
        });
    }

    if ($request->filled('department')) {
        $query->whereHas('staff', function ($q) use ($request) {
            $q->where('department', $request->department);
        });
    }

    if ($request->filled('date')) {
        $query->whereDate('created_at', $request->date);
    }

    // Sorting
    $sortBy = $request->get('sort_by', 'created_at');
    $sortOrder = $request->get('sort_order', 'desc');

    if (in_array($sortBy, ['reference_number', 'created_at'])) {
        $query->orderBy($sortBy, $sortOrder);
    } elseif ($sortBy === 'staff_name') {
        $query->join('staff', 'applications.staff_id', '=', 'staff.id')
              ->orderBy('staff.name', $sortOrder)
              ->select('applications.*'); // Avoid ambiguous column errors
    } else {
        $query->latest(); // Default
    }

    // Paginate
    $applications = $query->paginate(10)->withQueryString();

    // For filter dropdowns
    $designations = \App\Models\Staff::select('designation')->distinct()->pluck('designation');
    $departments = \App\Models\Staff::select('department')->distinct()->pluck('department');

    return view('applications.index', compact('applications', 'designations', 'departments'));
}


    public function create()
    {
        $staffs = Staff::all();
        return view('applications.create', compact('staffs'));
    }

        public function store(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'equipments.*.name' => 'required|string|max:255',
            'equipments.*.quantity' => 'required|integer|min:1',
        ]);

        $reference = Application::generateReferenceNumber();

        $application = Application::create([
            'staff_id' => $request->staff_id,
            'reference_number' => $reference,
            'application_date' => now(),
        ]);

        foreach ($request->equipments as $equipmentData) {
            $application->equipments()->create([
                'name' => $equipmentData['name'],
                'description' => $equipmentData['description'] ?? null,
                'model_brand' => $equipmentData['model_brand'] ?? null,
                'serial_number' => $equipmentData['serial_number'] ?? null,
                'quantity' => $equipmentData['quantity'],
            ]);
        }

        return redirect()->route('applications.index')
            ->with('success', 'Application submitted successfully!');
    }

    // public function show($id)
    // {
    //     $applications = Application::with('equipments', 'staff')->findOrFail($id);
    //     $equipments = $applications->equipments;
    //     return view('applications.show', compact('applications', 'equipments'));
    // }

        public function show($id)
    {
        $application = Application::with(['staff', 'equipments'])->findOrFail($id);
        return view('applications.show', compact('application'));
    }
    public function edit($id)
    {
        $application = Application::with('equipments')->findOrFail($id);
        $staffs = Staff::all();
        return view('applications.edit', compact('application', 'staffs'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'staff_id' => 'required|exists:staff,id',
        'equipments.*.name' => 'required|string|max:255',
        'equipments.*.quantity' => 'required|integer|min:1',
    ]);

    $application = Application::findOrFail($id);

    // Update the application’s staff assignment
    $application->update([
        'staff_id' => $request->staff_id,
    ]);

    // Track existing equipment IDs to keep
    $existingIds = [];

    foreach ($request->equipments as $equipmentData) {
        if (isset($equipmentData['id'])) {
            // Update existing equipment
            $equipment = $application->equipments()->where('id', $equipmentData['id'])->first();
            if ($equipment) {
                $equipment->update([
                    'name' => $equipmentData['name'],
                    'description' => $equipmentData['description'] ?? null,
                    'model_brand' => $equipmentData['model_brand'] ?? null,
                    'serial_number' => $equipmentData['serial_number'] ?? null,
                    'quantity' => $equipmentData['quantity'],
                ]);
                $existingIds[] = $equipment->id;
            }
        } else {
            // Create new equipment
            $newEquipment = $application->equipments()->create([
                'name' => $equipmentData['name'],
                'description' => $equipmentData['description'] ?? null,
                'model_brand' => $equipmentData['model_brand'] ?? null,
                'serial_number' => $equipmentData['serial_number'] ?? null,
                'quantity' => $equipmentData['quantity'],
            ]);
            $existingIds[] = $newEquipment->id;
        }
    }

    // Delete equipments not in the current form
    $application->equipments()->whereNotIn('id', $existingIds)->delete();

    return redirect()->route('applications.index')->with('success', 'Application updated successfully.');
}
  


    public function destroy($id)
    {
        $application = Application::findOrFail($id);
        $application->equipments()->delete(); // changed from detach to delete for one-to-many
        $application->delete();

        return redirect()->route('applications.index')->with('success', 'Application deleted.');
    }

    public function downloadPDF($id)
    {
        $form = Application::with(['staff', 'equipments'])->findOrFail($id);
        $user = $form->staff;

        $items = $form->equipments->map(function ($equipment) {
            return (object) [
                'quantity' => $equipment->quantity,
                'name' => $equipment->name,
                'description' => $equipment->description ?? '-',
                'model_brand' => $equipment->model_brand ?? '-',
                'serial_number' => $equipment->serial_number ?? '-',
            ];
        });

        return Pdf::loadView('pdf.accountability_form', compact('form', 'user', 'items'))
            ->download('Accountability_Form_' . $form->reference_number . '.pdf');
    }
}
