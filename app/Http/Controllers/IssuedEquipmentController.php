<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class IssuedEquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $applications = Application::with(['equipments', 'staff'])->get();

        $equipmentList = collect();

        foreach ($applications as $app) {
            foreach ($app->equipments as $eq) {
                if (!$search || str_contains(strtolower($eq->name . ' ' . $eq->model_brand), strtolower($search))) {
                    $equipmentList->push([
                        'equipment' => $eq,
                        'staff' => $app->staff,
                        'issued_at' => $app->created_at,
                    ]);
                }
            }
        }

        $groupedByEquipment = $equipmentList->groupBy(fn($item) => $item['equipment']->name . ' - ' . $item['equipment']->model_brand);

        // Convert to paginated format (10 per page)
        $perPage = 10;
        $page = $request->input('page', 1);
        $groupedKeys = $groupedByEquipment->keys();
        $pagedKeys = $groupedKeys->slice(($page - 1) * $perPage, $perPage);

        $pagedGroups = collect();
        foreach ($pagedKeys as $key) {
            $pagedGroups[$key] = $groupedByEquipment[$key];
        }

        $paginator = new LengthAwarePaginator(
            $pagedGroups,
            $groupedKeys->count(),
            $perPage,
            $page,
            ['path' => url()->current()]
        );

        return view('monitor.issued_equipment', compact('paginator', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
