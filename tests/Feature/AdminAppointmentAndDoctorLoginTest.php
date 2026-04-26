<?php

namespace Tests\Feature;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminAppointmentAndDoctorLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_appointment_from_admin_form(): void
    {
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'patient']);

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('Password123!'),
        ]);
        $admin->assignRole('admin');

        $patientUser = User::create([
            'name' => 'Test Patient',
            'email' => 'patient@example.com',
            'password' => Hash::make('Password123!'),
            'role' => 'patient',
        ]);
        $patientUser->assignRole('patient');

        $patient = Patient::create([
            'user_id' => $patientUser->id,
            'phone' => '0123456789',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.appointments.store', absolute: false), [
            'patient_id' => $patient->id,
            'appointment_date' => now()->toDateString(),
            'appointment_time' => '09:00',
            'status' => 'scheduled',
            'reason' => 'Routine checkup',
            'notes' => 'Test notes',
        ]);

        $response->assertRedirect(route('admin.appointments.index', absolute: false));
        $response->assertSessionHas('success', 'Appointment created successfully.');

        $this->assertDatabaseHas('appointments', [
            'patient_id' => $patient->id,
            'status' => 'scheduled',
        ]);
    }

    public function test_doctor_login_redirects_to_doctor_dashboard(): void
    {
        Role::firstOrCreate(['name' => 'doctor']);

        $doctor = User::create([
            'name' => 'Doctor User',
            'email' => 'doctor@example.com',
            'password' => Hash::make('Password123!'),
        ]);
        $doctor->assignRole('doctor');

        $this->post('/login', [
            'email' => 'doctor@example.com',
            'password' => 'Password123!',
        ])->assertRedirect('/dashboard');

        $this->get('/dashboard')->assertRedirect(route('doctor.dashboard', absolute: false));
        $this->get(route('doctor.dashboard', absolute: false))->assertOk();
    }
}
