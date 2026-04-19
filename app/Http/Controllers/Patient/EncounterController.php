<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Encounter;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EncounterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $patientId = $request->user()->patient?->id;

        $encounters = Encounter::query()
            ->with(['vitalSigns'])
            ->where('patient_id', $patientId)
            ->latest()
            ->paginate(10);

        return view('patient.encounters.index', [
            'encounters' => $encounters,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort(404);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Encounter $encounter): View
    {
        abort_unless($encounter->patient_id === $request->user()->patient?->id, 403);

        return view('patient.encounters.show', [
            'encounter' => $encounter->load(['vitalSigns', 'labOrders.items']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort(404);
    }
}
