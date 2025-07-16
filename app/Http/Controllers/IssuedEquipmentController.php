<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class IssuedEquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
        {
            $applications = Application::with(['staff', 'equipments'])
                ->latest()
                ->paginate(10);

            return view('monitor.issued_equipment', compact('applications'));
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
