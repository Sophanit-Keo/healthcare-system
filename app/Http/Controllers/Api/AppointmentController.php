<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\HealthStaff;
use App\Models\Patient;
use App\Services\ConsentService;
use App\Services\StaffScopeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

class AppointmentController extends Controller
{
    private function isPatient($user): bool
    {
        if (! $user) {
            return false;
        }

        $isPatientByColumn = ($user->role ?? null) === 'patient';
        $isPatientBySpatie = method_exists($user, 'hasRole') && $user->hasRole('patient');

        return $isPatientByColumn || $isPatientBySpatie;
    }

    public function __construct(
        private readonly ConsentService $consentService,
        private readonly StaffScopeService $staffScopeService,
    ) {}

    public function index(Request $request)
    {
        $user = $request->user();

        $query = Appointment::query()->with(['patient.user', 'staff', 'facility', 'departmentRef']);
        if ($this->isPatient($user)) {
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
        if ($this->isPatient($user)) {
            $patientId = $user->patient?->id;
            if (! $patientId) {
                throw ValidationException::withMessages([
                    'patient' => ['Patient profile not found for this account.'],
                ]);
            }
            $data['patient_id'] = $patientId;
            $data['status'] = 'scheduled';
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

        $payload = $data;

        if (
            Schema::hasColumn('appointments', 'patient_name')
            || Schema::hasColumn('appointments', 'department')
            || Schema::hasColumn('appointments', 'date')
        ) {
            $patient = null;
            if (! empty($payload['patient_id'])) {
                $patient = Patient::query()->with('user')->find($payload['patient_id']);
            }

            $departmentName = null;
            if (! empty($payload['department_id'])) {
                $departmentName = Department::query()->whereKey($payload['department_id'])->value('name');
            }

            $doctorName = null;
            if (! empty($payload['health_staff_id'])) {
                $staff = HealthStaff::query()->whereKey($payload['health_staff_id'])->first();
                if ($staff) {
                    $doctorName = 'Dr. '.trim(($staff->first_name ?? '').' '.($staff->last_name ?? ''));
                }
            }

            if (Schema::hasColumn('appointments', 'user_id')) {
                $payload['user_id'] = $patient?->user_id;
            }
            if (Schema::hasColumn('appointments', 'patient_name')) {
                $payload['patient_name'] = $patient?->user?->name ?? (! empty($payload['patient_id']) ? ('Patient #'.$payload['patient_id']) : 'Patient');
            }
            if (Schema::hasColumn('appointments', 'email')) {
                $payload['email'] = $patient?->user?->email;
            }
            if (Schema::hasColumn('appointments', 'phone')) {
                $payload['phone'] = $patient?->phone ?? $patient?->user?->phone;
            }
            if (Schema::hasColumn('appointments', 'doctor')) {
                $payload['doctor'] = $doctorName;
            }
            if (Schema::hasColumn('appointments', 'department')) {
                $payload['department'] = $departmentName ?? 'General';
            }
            if (Schema::hasColumn('appointments', 'date')) {
                $payload['date'] = $payload['appointment_date'] ?? null;
            }
            if (Schema::hasColumn('appointments', 'time')) {
                $payload['time'] = $payload['appointment_time'] ?? null;
            }
            if (Schema::hasColumn('appointments', 'message')) {
                $payload['message'] = $payload['notes'] ?? $payload['reason'] ?? null;
            }
        }

        $appointment = Appointment::create($payload);

        return (new AppointmentResource($appointment->load(['patient.user', 'staff', 'facility', 'departmentRef'])))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Request $request, Appointment $appointment)
    {
        $user = $request->user();
        if ($this->isPatient($user)) {
            if ($appointment->patient_id !== $user->patient?->id) {
                abort(403);
            }
        } else {
            abort_unless($user->can('appointments.view'), 403);
        }

        return new AppointmentResource($appointment->load(['patient.user', 'staff', 'facility', 'departmentRef']));
    }

    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        $user = $request->user();
        if ($this->isPatient($user)) {
            if ($appointment->patient_id !== $user->patient?->id) {
                abort(403);
            }
        } else {
            abort_unless($user->can('appointments.update'), 403);
        }

        $appointment->update($request->validated());

        return new AppointmentResource($appointment->load(['patient.user', 'staff', 'facility', 'departmentRef']));
    }

    public function destroy(Request $request, Appointment $appointment)
    {
        $user = $request->user();
        if ($this->isPatient($user)) {
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
