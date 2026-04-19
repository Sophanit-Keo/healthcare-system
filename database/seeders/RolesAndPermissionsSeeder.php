<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $doctor = Role::firstOrCreate(['name' => 'doctor']);
        $nurse = Role::firstOrCreate(['name' => 'nurse']);
        $receptionist = Role::firstOrCreate(['name' => 'receptionist']);

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
        ]);

        $nurse->givePermissionTo([
            'patients.view',
            'appointments.view',
            'encounters.view',
        ]);

        $receptionist->givePermissionTo([
            'patients.view',
            'patients.create',
            'appointments.view',
            'appointments.create',
            'appointments.update',
        ]);
    }
}