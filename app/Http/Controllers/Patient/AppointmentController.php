<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AppointmentController extends Controller
{
    
    public function index(Request $request): View
    {
        $patientId = $request->user()->patient?->id;

        $appointments = Appointment::query()
            ->with(['facility', 'department', 'staff'])
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
        $patientId = $request->user()->patient?->id;

        $data = $request->validate([
            'facility_id' => ['nullable', 'integer', 'exists:facilities,id'],
            'department_id' => ['nullable', 'integer', 'exists:departments,id'],
            'appointment_date' => ['required', 'date'],
            'appointment_time' => ['required', 'date_format:H:i'],
            'reason' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        Appointment::create([
            ...$data,
            'patient_id' => $patientId,
            'status' => 'scheduled',
        ]);

        return redirect()
            ->route('patient.appointments.index')
            ->with('status', 'appointment-created');
    }

    
    public function show(Request $request, Appointment $appointment): View
    {
        abort_unless($appointment->patient_id === $request->user()->patient?->id, 403);

        return view('patient.appointments.show', [
            'appointment' => $appointment->load(['facility', 'department', 'staff']),
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
        abort_unless($appointment->patient_id === $request->user()->patient?->id, 403);

        $appointment->delete();

        return redirect()
            ->route('patient.appointments.index')
            ->with('status', 'appointment-deleted');
    }
}
