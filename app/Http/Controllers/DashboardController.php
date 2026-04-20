<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Encounter;
use App\Models\LabOrder;
use App\Models\PatientFacilityConsent;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    
    public function __invoke(Request $request)
    {
        $user = $request->user();

        if ($user->hasRole('patient')) {
            $patientId = $user->patient?->id;

            return view('dashboards.patient', [
                'appointmentsCount' => Appointment::query()->where('patient_id', $patientId)->count(),
                'encountersCount' => Encounter::query()->where('patient_id', $patientId)->count(),
                'labOrdersCount' => LabOrder::query()->where('patient_id', $patientId)->count(),
                'consentsCount' => PatientFacilityConsent::query()->where('patient_id', $patientId)->count(),
            ]);
        }

        return view('dashboards.staff', [
            'appointmentsCount' => Appointment::query()->count(),
            'encountersCount' => Encounter::query()->count(),
            'labOrdersCount' => LabOrder::query()->count(),
        ]);
    }
}
