<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEncounterRequest;
use App\Http\Requests\UpdateEncounterRequest;
use App\Http\Resources\EncounterResource;
use App\Models\Encounter;
use App\Models\Patient;
use App\Services\ConsentService;
use App\Services\StaffScopeService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EncounterController extends Controller
{
    public function __construct(
        private readonly ConsentService $consentService,
        private readonly StaffScopeService $staffScopeService,
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $query = Encounter::query()->with(['patient.user', 'vitalSigns']);

        if ($user->hasRole('patient')) {
            $query->where('patient_id', $user->patient?->id);
        } else {
            abort_unless($user->can('encounters.view'), 403);
        }

        return EncounterResource::collection($query->latest()->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEncounterRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

        if ($user->hasRole('patient')) {
            $patientId = $user->patient?->id;
            if (! $patientId) {
                throw ValidationException::withMessages([
                    'patient' => ['Patient profile not found for this account.'],
                ]);
            }
            $data['patient_id'] = $patientId;
        } else {
            abort_unless($user->can('encounters.create'), 403);

            $this->staffScopeService->enforceFacilityScope($user, $data['facility_id'] ?? null);

            if (! empty($data['facility_id'])) {
                $patient = Patient::findOrFail($data['patient_id']);
                if (! $this->consentService->hasActiveFacilityConsent($patient, (int) $data['facility_id'])) {
                    throw ValidationException::withMessages([
                        'facility_id' => ['Patient consent is not granted for this facility.'],
                    ]);
                }
            }
        }

        $encounter = Encounter::create($data);

        return (new EncounterResource($encounter->load(['patient.user', 'vitalSigns'])))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Encounter $encounter)
    {
        $user = $request->user();
        if ($user->hasRole('patient')) {
            if ($encounter->patient_id !== $user->patient?->id) {
                abort(403);
            }
        } else {
            abort_unless($user->can('encounters.view'), 403);
        }

        return new EncounterResource($encounter->load(['patient.user', 'vitalSigns']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEncounterRequest $request, Encounter $encounter)
    {
        $user = $request->user();
        if ($user->hasRole('patient')) {
            if ($encounter->patient_id !== $user->patient?->id) {
                abort(403);
            }
        } else {
            abort_unless($user->can('encounters.update'), 403);
        }

        $encounter->update($request->validated());

        return new EncounterResource($encounter->load(['patient.user', 'vitalSigns']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Encounter $encounter)
    {
        $user = $request->user();
        if ($user->hasRole('patient')) {
            if ($encounter->patient_id !== $user->patient?->id) {
                abort(403);
            }
        } else {
            abort_unless($user->can('encounters.delete'), 403);
        }

        $encounter->delete();

        return response()->json(['message' => 'Encounter deleted']);
    }
}
