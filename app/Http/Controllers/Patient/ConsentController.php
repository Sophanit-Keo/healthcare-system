<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\PatientFacilityConsent;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ConsentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $patientId = $request->user()->patient?->id;

        $consents = PatientFacilityConsent::query()
            ->with('facility')
            ->where('patient_id', $patientId)
            ->latest()
            ->paginate(10);

        return view('patient.consents.index', [
            'consents' => $consents,
            'facilities' => Facility::query()->orderBy('name')->get(),
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
    public function store(Request $request): RedirectResponse
    {
        $patientId = $request->user()->patient?->id;

        $data = $request->validate([
            'facility_id' => ['required', 'integer', 'exists:facilities,id'],
            'expires_at' => ['nullable', 'date'],
        ]);

        PatientFacilityConsent::query()->updateOrCreate(
            ['patient_id' => $patientId, 'facility_id' => $data['facility_id']],
            [
                'status' => 'granted',
                'expires_at' => $data['expires_at'] ?? null,
                'granted_at' => now(),
                'revoked_at' => null,
                'updated_by_user_id' => $request->user()->id,
            ]
        );

        return redirect()
            ->route('patient.consents.index')
            ->with('status', 'consent-granted');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort(404);
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
    public function destroy(Request $request, PatientFacilityConsent $consent): RedirectResponse
    {
        abort_unless($consent->patient_id === $request->user()->patient?->id, 403);

        $consent->update([
            'status' => 'revoked',
            'revoked_at' => now(),
            'updated_by_user_id' => $request->user()->id,
        ]);

        return redirect()
            ->route('patient.consents.index')
            ->with('status', 'consent-revoked');
    }
}
