<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\Encounter;
use App\Models\LabOrder;
use App\Models\Patient;
use App\Models\PatientFacilityConsent;
use App\Models\HealthStaff;
use App\Models\Department;

class HomeController extends Controller
{
    public function adminDashboard()
    {
        $today = now()->toDateString();
        $monthlyAppointments = collect(range(5, 0))->map(function (int $monthsAgo) {
            $date = now()->subMonths($monthsAgo);
            return [
                'label' => $date->format('M'),
                'count' => Appointment::query()->whereYear('appointment_date', $date->year)->whereMonth('appointment_date', $date->month)->count(),
            ];
        });
        $departmentAppointments = Department::query()
            ->withCount(['appointments' => fn ($query) => $query->whereYear('appointment_date', now()->year)->whereMonth('appointment_date', now()->month)])
            ->orderByDesc('appointments_count')->limit(5)->get();

        return view('admin.dashboard', [
            'patientsCount' => Patient::query()->count(),
            'appointmentsThisMonth' => Appointment::query()
                ->whereYear('appointment_date', now()->year)
                ->whereMonth('appointment_date', now()->month)
                ->count(),
            'encountersThisMonth' => Encounter::query()
                ->whereYear('started_at', now()->year)
                ->whereMonth('started_at', now()->month)
                ->count(),
            'activeDoctorsCount' => HealthStaff::query()->where('role', 'doctor')->where('status', 'active')->count(),
            'todayAppointments' => Appointment::query()
                ->with(['patient.user', 'departmentRef', 'staff'])
                ->whereDate('appointment_date', $today)
                ->orderBy('appointment_time')
                ->limit(8)
                ->get(),
            'recentLabOrders' => LabOrder::query()->with('patient.user')->latest('ordered_at')->limit(6)->get(),
            'monthlyAppointments' => $monthlyAppointments,
            'departmentAppointments' => $departmentAppointments,
        ]);
    }

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
            return redirect()->route('admin.dashboard');
        }

        if ($role == 'doctor') {
            return redirect()->route('doctor.dashboard');
        }

        return redirect('/');
    }
}
