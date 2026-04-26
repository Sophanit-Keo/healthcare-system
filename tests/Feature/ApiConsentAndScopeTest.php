<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Facility;
use App\Models\HealthStaff;
use App\Models\Patient;
use App\Models\PatientFacilityConsent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ApiConsentAndScopeTest extends TestCase
{
    use RefreshDatabase;

    public function test_staff_cannot_create_appointment_without_patient_consent(): void
    {
        $facility = Facility::create([
            'facility_code' => 'F-1',
            'name' => 'Facility 1',
            'facility_type' => 'hospital',
        ]);
        $dept = Department::create([
            'facility_id' => $facility->id,
            'department_code' => 'GEN',
            'name' => 'General',
        ]);

        Permission::firstOrCreate(['name' => 'appointments.create']);
        $doctorRole = Role::firstOrCreate(['name' => 'doctor']);
        $doctorRole->givePermissionTo('appointments.create');

        $doctor = User::create([
            'name' => 'Doctor',
            'username' => 'doc',
            'email' => 'doc@example.com',
            'password' => Hash::make('Password123!'),
        ]);
        $doctor->assignRole('doctor');

        HealthStaff::create([
            'user_id' => $doctor->id,
            'staff_code' => 'DOC-001',
            'facility_id' => $facility->id,
            'department_id' => $dept->id,
            'first_name' => 'Doc',
            'last_name' => 'Tor',
            'role' => 'doctor',
            'status' => 'active',
        ]);

        $patientUser = User::create([
            'name' => 'Patient',
            'email' => 'p@example.com',
            'password' => Hash::make('Password123!'),
        ]);
        $patient = Patient::create(['user_id' => $patientUser->id]);

        Sanctum::actingAs($doctor);

        $this->postJson('/api/appointments', [
            'patient_id' => $patient->id,
            'facility_id' => $facility->id,
            'department_id' => $dept->id,
            'appointment_date' => '2026-04-19',
            'appointment_time' => '09:00',
        ])->assertStatus(422);
    }

    public function test_staff_cannot_create_appointment_outside_facility_scope(): void
    {
        $facilityA = Facility::create([
            'facility_code' => 'F-A',
            'name' => 'Facility A',
            'facility_type' => 'hospital',
        ]);
        $deptA = Department::create([
            'facility_id' => $facilityA->id,
            'department_code' => 'GEN',
            'name' => 'General A',
        ]);

        $facilityB = Facility::create([
            'facility_code' => 'F-B',
            'name' => 'Facility B',
            'facility_type' => 'hospital',
        ]);
        $deptB = Department::create([
            'facility_id' => $facilityB->id,
            'department_code' => 'GEN',
            'name' => 'General B',
        ]);

        Permission::firstOrCreate(['name' => 'appointments.create']);
        $doctorRole = Role::firstOrCreate(['name' => 'doctor']);
        $doctorRole->givePermissionTo('appointments.create');

        $doctor = User::create([
            'name' => 'Doctor',
            'email' => 'doc2@example.com',
            'password' => Hash::make('Password123!'),
        ]);
        $doctor->assignRole('doctor');

        HealthStaff::create([
            'user_id' => $doctor->id,
            'staff_code' => 'DOC-002',
            'facility_id' => $facilityA->id,
            'department_id' => $deptA->id,
            'first_name' => 'Doc',
            'last_name' => 'A',
            'role' => 'doctor',
            'status' => 'active',
        ]);

        $patientUser = User::create([
            'name' => 'Patient',
            'email' => 'p2@example.com',
            'password' => Hash::make('Password123!'),
        ]);
        $patient = Patient::create(['user_id' => $patientUser->id]);

        // Consent exists but for facility B; scope still should block because staff is scoped to A.
        PatientFacilityConsent::create([
            'patient_id' => $patient->id,
            'facility_id' => $facilityB->id,
            'status' => 'granted',
            'granted_at' => now(),
        ]);

        Sanctum::actingAs($doctor);

        $this->postJson('/api/appointments', [
            'patient_id' => $patient->id,
            'facility_id' => $facilityB->id,
            'department_id' => $deptB->id,
            'appointment_date' => '2026-04-19',
            'appointment_time' => '09:00',
        ])->assertStatus(422);
    }
}
