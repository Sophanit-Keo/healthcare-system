<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Encounter;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EncounterController extends Controller
{
    
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

    
    public function create()
    {
        abort(404);
    }

    
    public function store(Request $request)
    {
        abort(404);
    }

    
    public function show(Request $request, Encounter $encounter): View
    {
        abort_unless($encounter->patient_id === $request->user()->patient?->id, 403);

        return view('patient.encounters.show', [
            'encounter' => $encounter->load(['vitalSigns', 'labOrders.items']),
        ]);
    }

    
    public function edit(string $id)
    {
        abort(404);
    }

    
    public function update(Request $request, string $id)
    {
        abort(404);
    }

    
    public function destroy(string $id)
    {
        abort(404);
    }
}
