<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AppointmentController extends Controller
{
    
    public function index(Request $request): View
    {
        $patientId = $request->user()->patient?->id;

        $appointments = Appointment::query()
            ->with(['facility', 'departmentRef', 'staff'])
            ->where('patient_id', $patientId)
            ->latest()
            ->paginate(10);

        return view('patient.appointments.index', [
            'appointments' => $appointments,
        ]);
    }

    
    public function create(): View
    {
        return view('patient.appointments.create', [
            'facilities' => Facility::query()->orderBy('name')->get(),
            'departments' => Department::query()->orderBy('name')->get(),
        ]);
    }

    
    public function store(Request $request): RedirectResponse
    {
        $patient = $request->user()->patient;
        $patientId = $patient?->id;

        abort_unless($patientId, 403);

        $data = $request->validate([
            'facility_id' => ['nullable', 'integer', 'exists:facilities,id'],
            'department_id' => ['nullable', 'integer', 'exists:departments,id'],
            'appointment_date' => ['required', 'date'],
            'appointment_time' => ['required', 'date_format:H:i'],
            'reason' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $payload = [
            ...$data,
            'patient_id' => $patientId,
            'status' => 'scheduled',
        ];

        if (
            Schema::hasColumn('appointments', 'patient_name')
            || Schema::hasColumn('appointments', 'department')
            || Schema::hasColumn('appointments', 'date')
        ) {
            $departmentName = null;
            if (! empty($data['department_id'])) {
                $departmentName = Department::query()->whereKey($data['department_id'])->value('name');
            }

            if (Schema::hasColumn('appointments', 'user_id')) {
                $payload['user_id'] = $request->user()->id;
            }
            if (Schema::hasColumn('appointments', 'patient_name')) {
                $payload['patient_name'] = $request->user()->name;
            }
            if (Schema::hasColumn('appointments', 'email')) {
                $payload['email'] = $request->user()->email;
            }
            if (Schema::hasColumn('appointments', 'phone')) {
                $payload['phone'] = $patient?->phone ?? $request->user()->phone;
            }
            if (Schema::hasColumn('appointments', 'department')) {
                $payload['department'] = $departmentName ?? 'General';
            }
            if (Schema::hasColumn('appointments', 'date')) {
                $payload['date'] = $data['appointment_date'];
            }
            if (Schema::hasColumn('appointments', 'time')) {
                $payload['time'] = $data['appointment_time'];
            }
            if (Schema::hasColumn('appointments', 'message')) {
                $payload['message'] = $data['notes'] ?? $data['reason'] ?? null;
            }
        }

        Appointment::create($payload);

        return redirect()
            ->route('patient.appointments.index')
            ->with('status', 'appointment-created');
    }

    
    public function show(Request $request, Appointment $appointment): View
    {
        $patientId = $request->user()->patient?->id;

        abort_unless($appointment->patient_id === $patientId, 403);

        return view('patient.appointments.show', [
            'appointment' => $appointment->load(['facility', 'departmentRef', 'staff']),
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

    
    public function destroy(Request $request, Appointment $appointment): RedirectResponse
    {
        $patientId = $request->user()->patient?->id;

        abort_unless($appointment->patient_id === $patientId, 403);

        $appointment->delete();

        return redirect()
            ->route('patient.appointments.index')
            ->with('status', 'appointment-deleted');
    }
}
