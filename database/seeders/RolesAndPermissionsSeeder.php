<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Department;
use App\Models\Facility;
use App\Models\HealthStaff;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {

        $permissions = [
            'patients.view',
            'patients.create',
            'patients.update',
            'patients.delete',
            'appointments.view',
            'appointments.create',
            'appointments.update',
            'appointments.delete',
            'encounters.view',
            'encounters.create',
            'encounters.update',
            'encounters.delete',
            'staff.manage',
            'consents.view',
            'consents.manage',
            'lab_orders.view',
            'lab_orders.create',
            'lab_orders.update',
            'lab_orders.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $doctor = Role::firstOrCreate(['name' => 'doctor']);
        $nurse = Role::firstOrCreate(['name' => 'nurse']);
        $receptionist = Role::firstOrCreate(['name' => 'receptionist']);
        $patient = Role::firstOrCreate(['name' => 'patient']);

        $admin->givePermissionTo(Permission::all());

        $doctor->givePermissionTo([
            'patients.view',
            'patients.update',
            'appointments.view',
            'appointments.create',
            'appointments.update',
            'encounters.view',
            'encounters.create',
            'encounters.update',
            'lab_orders.view',
            'lab_orders.create',
            'lab_orders.update',
        ]);

        $nurse->givePermissionTo([
            'patients.view',
            'appointments.view',
            'encounters.view',
            'lab_orders.view',
        ]);

        $receptionist->givePermissionTo([
            'patients.view',
            'patients.create',
            'appointments.view',
            'appointments.create',
            'appointments.update',
            'consents.view',
        ]);
        $patient->givePermissionTo([
            'consents.manage',
        ]);
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            ['name' => 'Admin', 'username' => 'admin', 'password' => bcrypt('password'), 'role' => 'admin']
        );
        $admin->update(['role' => 'admin']);
        $admin->assignRole('admin');

        $doctor = User::firstOrCreate(
            ['email' => 'doctor@gmail.com'],
            ['name' => 'Doctor', 'username' => 'doctor', 'password' => bcrypt('password'), 'role' => 'doctor']
        );
        $doctor->update(['role' => 'doctor']);
        $doctor->assignRole('doctor');

        $defaultFacility = Facility::query()->first();
        $defaultDepartment = Department::query()->where('facility_id', $defaultFacility?->id)->first();

        if ($defaultFacility && $defaultDepartment) {
            HealthStaff::firstOrCreate(
                ['user_id' => $doctor->id],
                [
                    'staff_code' => 'DOC-001',
                    'facility_id' => $defaultFacility->id,
                    'department_id' => $defaultDepartment->id,
                    'first_name' => 'Doctor',
                    'last_name' => 'User',
                    'gender' => null,
                    'date_of_birth' => null,
                    'phone' => null,
                    'email' => 'doctor@gmail.com',
                    'role' => 'doctor',
                    'license_number' => null,
                    'hire_date' => null,
                    'status' => 'active',
                ]
            );
        }

        $patientUser = User::firstOrCreate(
            ['email' => 'patient@gmail.com'],
            ['name' => 'Patient', 'username' => 'patient', 'password' => bcrypt('password'), 'role' => 'patient']
        );
        $patientUser->update(['role' => 'patient']);
        $patientUser->assignRole('patient');
        $patientUser->patient()->firstOrCreate([]);
    }
}
