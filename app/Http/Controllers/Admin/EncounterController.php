<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Encounter;
use App\Models\Facility;
use App\Models\Patient;
use App\Services\ConsentService;
use App\Services\StaffScopeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class EncounterController extends Controller
{
    public function __construct(
        private readonly ConsentService $consentService,
        private readonly StaffScopeService $staffScopeService,
    ) {}

    public function index(Request $request): View
    {
        abort_unless($request->user()->can('encounters.view'), 403);

        $encounters = Encounter::query()
            ->with(['patient.user'])
            ->latest()
            ->paginate(10);

        return view('admin.encounters.index', [
            'encounters' => $encounters,
        ]);
    }

    public function create(Request $request): View
    {
        abort_unless($request->user()->can('encounters.create'), 403);

        return view('admin.encounters.create', [
            'patients' => Patient::query()->with('user')->latest()->limit(200)->get(),
            'appointments' => Appointment::query()->latest()->limit(200)->get(),
            'facilities' => Facility::query()->orderBy('name')->get(),
            'departments' => Department::query()->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless($request->user()->can('encounters.create'), 403);

        $data = $request->validate([
            'appointment_id' => ['nullable', 'integer', 'exists:appointments,id'],
            'patient_id' => ['required', 'integer', 'exists:patients,id'],
            'facility_id' => ['nullable', 'integer', 'exists:facilities,id'],
            'department_id' => ['nullable', 'integer', 'exists:departments,id'],
            'encounter_type' => ['required', 'in:outpatient,inpatient,emergency,follow_up'],
            'started_at' => ['nullable', 'date'],
            'ended_at' => ['nullable', 'date', 'after_or_equal:started_at'],
            'chief_complaint' => ['nullable', 'string'],
            'diagnosis' => ['nullable', 'string'],
            'treatment_plan' => ['nullable', 'string'],
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

        Encounter::create($data);

        return redirect()
            ->route('admin.encounters.index')
            ->with('status', 'encounter-created');
    }

    public function show(Request $request, Encounter $encounter): View
    {
        abort_unless($request->user()->can('encounters.view'), 403);

        return view('admin.encounters.show', [
            'encounter' => $encounter->load(['patient.user', 'vitalSigns', 'labOrders.items']),
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
