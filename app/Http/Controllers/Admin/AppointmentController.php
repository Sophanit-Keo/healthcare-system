<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Facility;
use App\Models\HealthStaff;
use App\Models\Patient;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    public function index(Request $request): View
    {
        $appointmentsQuery = Appointment::query()
            ->with(['patient.user', 'facility', 'departmentRef', 'staff']);

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $appointmentsQuery->where(function ($q) use ($search) {
                $q->whereHas('patient.user', function ($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                    ->orWhereHas('staff', function ($sq) use ($search) {
                        $sq->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhere('reason', 'like', "%{$search}%")
                    ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $appointmentsQuery->where('status', $request->input('status'));
        }

        if ($request->filled('date')) {
            $appointmentsQuery->whereDate('appointment_date', $request->input('date'));
        }

        $appointments = $appointmentsQuery
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.appointments.index', [
            'appointments' => $appointments,
        ]);
    }

    
    public function create(Request $request): View
    {
        return view('admin.appointments.create', [
            'patients' => Patient::query()->with('user')->latest()->limit(200)->get(),
            'doctors' => HealthStaff::query()
                ->where('role', 'doctor')
                ->orderBy('first_name')
                ->orderBy('last_name')
                ->limit(200)
                ->get(),
            'facilities' => Facility::query()->orderBy('name')->get(),
            'departments' => Department::query()->orderBy('name')->get(),
        ]);
    }

    
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'patient_id' => ['required', 'integer', 'exists:patients,id'],
            'facility_id' => ['nullable', 'integer', 'exists:facilities,id'],
            'department_id' => ['nullable', 'integer', 'exists:departments,id'],
            'health_staff_id' => ['nullable', 'integer', 'exists:health_staff,id'],
            'appointment_date' => ['required', 'date'],
            'appointment_time' => ['required', 'date_format:H:i'],
            'status' => ['nullable', 'in:scheduled,completed,cancelled,no_show'],
            'reason' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $payload = [
            ...$data,
            'status' => $data['status'] ?? 'scheduled',
        ];

        if (
            Schema::hasColumn('appointments', 'patient_name')
            || Schema::hasColumn('appointments', 'department')
            || Schema::hasColumn('appointments', 'date')
        ) {
            $patient = Patient::query()->with('user')->find($data['patient_id']);

            $departmentName = null;
            if (! empty($data['department_id'])) {
                $departmentName = Department::query()->whereKey($data['department_id'])->value('name');
            }

            $doctorName = null;
            if (! empty($data['health_staff_id'])) {
                $staff = HealthStaff::query()->whereKey($data['health_staff_id'])->first();
                if ($staff) {
                    $doctorName = 'Dr. ' . trim(($staff->first_name ?? '') . ' ' . ($staff->last_name ?? ''));
                }
            }

            if (Schema::hasColumn('appointments', 'user_id')) {
                $payload['user_id'] = $patient?->user_id;
            }
            if (Schema::hasColumn('appointments', 'patient_name')) {
                $payload['patient_name'] = $patient?->user?->name ?? ('Patient #' . $data['patient_id']);
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
            ->route('admin.appointments.index')
            ->with('success', 'Appointment created successfully.');
    }

    
    public function show(Request $request, Appointment $appointment): View
    {
        return view('admin.appointments.show', [
            'appointment' => $appointment->load(['patient.user', 'facility', 'departmentRef', 'staff', 'encounter']),
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
        $appointment->delete();

        return redirect()
            ->route('admin.appointments.index')
            ->with('success', 'Appointment deleted.');
    }
}
