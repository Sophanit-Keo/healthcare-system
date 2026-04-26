<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class PrescriptionController extends Controller
{
    public function index(Request $request): View
    {
        $doctorName = 'Dr. '.$request->user()->name;

        $prescriptions = Prescription::query()
            ->with('user')
            ->where('doctor_name', $doctorName)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('Doctor.prescriptions.index', [
            'prescriptions' => $prescriptions,
        ]);
    }

    public function create(Request $request): View
    {
        Role::firstOrCreate(['name' => 'patient']);

        $patients = User::query()
            ->where(function ($q) {
                $q->where('role', 'patient')->orWhereHas('roles', function ($rq) {
                    $rq->where('name', 'patient');
                });
            })
            ->orderBy('name')
            ->limit(300)
            ->get();

        return view('Doctor.prescriptions.create', [
            'patients' => $patients,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $doctorName = 'Dr. '.$request->user()->name;

        $data = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'medication' => ['required', 'string', 'max:255'],
            'dosage' => ['nullable', 'string', 'max:255'],
            'frequency' => ['nullable', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'status' => ['nullable', 'in:active,inactive,completed'],
            'notes' => ['nullable', 'string'],
        ]);

        Prescription::create([
            ...$data,
            'doctor_name' => $doctorName,
            'status' => $data['status'] ?? 'active',
        ]);

        return redirect()
            ->route('doctor.prescriptions.index')
            ->with('success', 'Prescription created successfully.');
    }
}
