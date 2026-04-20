<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Facility;
use Illuminate\Database\Seeder;

class FacilitiesSeeder extends Seeder
{
    
    public function run(): void
    {
        $facility = Facility::firstOrCreate(
            ['facility_code' => 'HOSP-001'],
            [
                'name' => 'One Health General Hospital',
                'facility_type' => 'hospital',
                'phone' => '000-000-000',
                'email' => 'info@onehealth.test',
                'address' => 'Main Street',
                'city_province' => 'Phnom Penh',
                'status' => 'active',
            ]
        );

        Department::firstOrCreate(
            ['facility_id' => $facility->id, 'department_code' => 'GEN'],
            ['name' => 'General', 'description' => 'General department', 'status' => 'active']
        );

        Department::firstOrCreate(
            ['facility_id' => $facility->id, 'department_code' => 'LAB'],
            ['name' => 'Laboratory', 'description' => 'Laboratory department', 'status' => 'active']
        );
    }
}
