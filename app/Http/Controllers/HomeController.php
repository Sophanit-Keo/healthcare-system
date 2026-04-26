<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Encounter;
use App\Models\LabOrder;
use App\Models\Patient;
use App\Models\PatientFacilityConsent;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function redirect()
    {
        $user = Auth::user();
        $role = $user->role;

        if (method_exists($user, 'hasAnyRole') && $user->hasAnyRole(['admin', 'doctor', 'patient'])) {
            if ($user->hasRole('admin')) {
                $role = 'admin';
            } elseif ($user->hasRole('doctor')) {
                $role = 'doctor';
            } elseif ($user->hasRole('patient')) {
                $role = 'patient';
            }
        }

        if ($role == 'patient') {
            $patient = $user->patient;
            if (! $patient) {
                $patient = Patient::firstOrCreate(['user_id' => $user->id]);
            }

            $patientId = $patient->id;

            return view('dashboards.patient', [
                'appointmentsCount' => Appointment::query()->where('patient_id', $patientId)->count(),
                'encountersCount' => Encounter::query()->where('patient_id', $patientId)->count(),
                'labOrdersCount' => LabOrder::query()->where('patient_id', $patientId)->count(),
                'consentsCount' => PatientFacilityConsent::query()->where('patient_id', $patientId)->count(),
            ]);
        }

        if ($role == 'admin') {
            return view('admin.dashboard');
        }

        if ($role == 'doctor') {
            return redirect()->route('doctor.dashboard');
        }

        return redirect('/');
    }
}
