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

    
    public function create()
    {
        abort(404);
    }

    
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

    
    public function show(string $id)
    {
        abort(404);
    }

    
    public function edit(string $id)
    {
        abort(404);
    }

    
    public function update(Request $request, string $id)
    {
        abort(404);
    }

    
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
