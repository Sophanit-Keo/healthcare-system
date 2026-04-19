<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Facility;
use App\Models\Patient;
use App\Services\ConsentService;
use App\Services\StaffScopeService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class AppointmentController extends Controller
{
    public function __construct(
        private readonly ConsentService $consentService,
        private readonly StaffScopeService $staffScopeService,
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        abort_unless($request->user()->can('appointments.view'), 403);

        $appointments = Appointment::query()
            ->with(['patient.user', 'facility', 'department', 'staff'])
            ->latest()
            ->paginate(10);

        return view('admin.appointments.index', [
            'appointments' => $appointments,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        abort_unless($request->user()->can('appointments.create'), 403);

        return view('admin.appointments.create', [
            'patients' => Patient::query()->with('user')->latest()->limit(200)->get(),
            'facilities' => Facility::query()->orderBy('name')->get(),
            'departments' => Department::query()->orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        abort_unless($request->user()->can('appointments.create'), 403);

        $data = $request->validate([
            'patient_id' => ['required', 'integer', 'exists:patients,id'],
            'facility_id' => ['nullable', 'integer', 'exists:facilities,id'],
            'department_id' => ['nullable', 'integer', 'exists:departments,id'],
            'appointment_date' => ['required', 'date'],
            'appointment_time' => ['required', 'date_format:H:i'],
            'reason' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $this->staffScopeService->enforceFacilityScope($request->user(), $data['facility_id'] ?? null);

        if (! empty($data['facility_id'])) {
            $patient = Patient::findOrFail($data['patient_id']);
            if (! $this->consentService->hasActiveFacilityConsent($patient, (int) $data['facility_id'])) {
                throw ValidationException::withMessages([
                    'facility_id' => ['Patient consent is not granted for this facility.'],
                ]);
            }
        }

        Appointment::create([
            ...$data,
            'status' => 'scheduled',
        ]);

        return redirect()
            ->route('admin.appointments.index')
            ->with('status', 'appointment-created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Appointment $appointment): View
    {
        abort_unless($request->user()->can('appointments.view'), 403);

        return view('admin.appointments.show', [
            'appointment' => $appointment->load(['patient.user', 'facility', 'department', 'staff', 'encounter']),
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
