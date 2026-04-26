<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\HealthStaff;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        $staffId = HealthStaff::query()
            ->where('user_id', $user->id)
            ->orWhere('email', $user->email)
            ->value('id');

        $appointmentsQuery = Appointment::query();

        if (! empty($staffId)) {
            $appointmentsQuery->where('health_staff_id', $staffId);
        } else {
            $appointmentsQuery->whereRaw('1 = 0');
        }

        $appointmentsTodayCount = (clone $appointmentsQuery)
            ->whereDate('appointment_date', now()->toDateString())
            ->count();

        $patientsCount = (clone $appointmentsQuery)
            ->whereNotNull('patient_id')
            ->distinct('patient_id')
            ->count('patient_id');

        return view('Doctor.dashboard_v2', [
            'patientsCount' => $patientsCount,
            'appointmentsTodayCount' => $appointmentsTodayCount,
        ]);
    }
}
