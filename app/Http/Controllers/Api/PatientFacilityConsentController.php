<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePatientFacilityConsentRequest;
use App\Http\Requests\UpdatePatientFacilityConsentRequest;
use App\Http\Resources\PatientFacilityConsentResource;
use App\Models\PatientFacilityConsent;
use Illuminate\Http\Request;

class PatientFacilityConsentController extends Controller
{
    
    public function index(Request $request)
    {
        $user = $request->user();

        $query = PatientFacilityConsent::query();

        if ($user->hasRole('patient')) {
            $query->where('patient_id', $user->patient?->id);
        } else {
            abort_unless($user->can('consents.view'), 403);

            if ($request->filled('patient_id')) {
                $query->where('patient_id', $request->integer('patient_id'));
            }
        }

        return PatientFacilityConsentResource::collection($query->latest()->paginate(10));
    }

    
    public function store(StorePatientFacilityConsentRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

        if ($user->hasRole('patient')) {
            $data['patient_id'] = $user->patient?->id;
        } else {
            abort_unless($user->can('consents.manage'), 403);
        }

        $consent = PatientFacilityConsent::query()->updateOrCreate(
            [
                'patient_id' => $data['patient_id'],
                'facility_id' => $data['facility_id'],
            ],
            [
                'status' => $data['status'] ?? 'granted',
                'scopes' => $data['scopes'] ?? null,
                'expires_at' => $data['expires_at'] ?? null,
                'granted_at' => ($data['status'] ?? 'granted') === 'granted' ? now() : null,
                'revoked_at' => ($data['status'] ?? 'granted') === 'revoked' ? now() : null,
                'updated_by_user_id' => $user?->id,
            ]
        );

        return (new PatientFacilityConsentResource($consent))
            ->response()
            ->setStatusCode(201);
    }

    
    public function show(Request $request, PatientFacilityConsent $patientFacilityConsent)
    {
        $user = $request->user();
        if ($user->hasRole('patient') && $patientFacilityConsent->patient_id !== $user->patient?->id) {
            abort(403);
        }

        return new PatientFacilityConsentResource($patientFacilityConsent);
    }

    
    public function update(UpdatePatientFacilityConsentRequest $request, PatientFacilityConsent $patientFacilityConsent)
    {
        $user = $request->user();
        if ($user->hasRole('patient') && $patientFacilityConsent->patient_id !== $user->patient?->id) {
            abort(403);
        }
        if (! $user->hasRole('patient')) {
            abort_unless($user->can('consents.manage'), 403);
        }

        $data = $request->validated();
        if (array_key_exists('status', $data)) {
            $data['granted_at'] = $data['status'] === 'granted' ? now() : null;
            $data['revoked_at'] = $data['status'] === 'revoked' ? now() : null;
        }
        $data['updated_by_user_id'] = $user?->id;

        $patientFacilityConsent->update($data);

        return new PatientFacilityConsentResource($patientFacilityConsent);
    }

    
    public function destroy(Request $request, PatientFacilityConsent $patientFacilityConsent)
    {
        $user = $request->user();
        if ($user->hasRole('patient') && $patientFacilityConsent->patient_id !== $user->patient?->id) {
            abort(403);
        }
        if (! $user->hasRole('patient')) {
            abort_unless($user->can('consents.manage'), 403);
        }
        $patientFacilityConsent->update([
            'status' => 'revoked',
            'revoked_at' => now(),
            'updated_by_user_id' => $user?->id,
        ]);

        return response()->json(['message' => 'Consent revoked']);
    }
}
