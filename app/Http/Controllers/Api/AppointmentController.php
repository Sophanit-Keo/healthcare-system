<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Models\Patient;
use App\Services\ConsentService;
use App\Services\StaffScopeService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AppointmentController extends Controller
{
    public function __construct(
        private readonly ConsentService $consentService,
        private readonly StaffScopeService $staffScopeService,
    )
    {
    }

    
    public function index(Request $request)
    {
        $user = $request->user();

        $query = Appointment::query()->with(['patient.user', 'staff', 'facility', 'department']);
        if ($user->hasRole('patient')) {
            $patientId = $user->patient?->id;
            $query->where('patient_id', $patientId);
        } else {
            abort_unless($user->can('appointments.view'), 403);
        }

        return AppointmentResource::collection($query->latest()->paginate(10));
    }

    
    public function store(StoreAppointmentRequest $request)
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
            abort_unless($user->can('appointments.create'), 403);

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

        $appointment = Appointment::create($data);

        return (new AppointmentResource($appointment->load(['patient.user', 'staff', 'facility', 'department'])))
            ->response()
            ->setStatusCode(201);
    }

    
    public function show(Request $request, Appointment $appointment)
    {
        $user = $request->user();
        if ($user->hasRole('patient')) {
            if ($appointment->patient_id !== $user->patient?->id) {
                abort(403);
            }
        } else {
            abort_unless($user->can('appointments.view'), 403);
        }

        return new AppointmentResource($appointment->load(['patient.user', 'staff', 'facility', 'department']));
    }

    
    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        $user = $request->user();
        if ($user->hasRole('patient')) {
            if ($appointment->patient_id !== $user->patient?->id) {
                abort(403);
            }
        } else {
            abort_unless($user->can('appointments.update'), 403);
        }

        $appointment->update($request->validated());

        return new AppointmentResource($appointment->load(['patient.user', 'staff', 'facility', 'department']));
    }

    
    public function destroy(Request $request, Appointment $appointment)
    {
        $user = $request->user();
        if ($user->hasRole('patient')) {
            if ($appointment->patient_id !== $user->patient?->id) {
                abort(403);
            }
        } else {
            abort_unless($user->can('appointments.delete'), 403);
        }

        $appointment->delete();

        return response()->json(['message' => 'Appointment deleted']);
    }
}
