<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Encounter;
use App\Models\LabOrder;
use App\Models\LabOrderItem;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminClinicalWorkflowTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private Patient $patient;

    protected function setUp(): void
    {
        parent::setUp();

        $permissions = [
            'encounters.view', 'encounters.create', 'encounters.update', 'encounters.delete',
            'lab_orders.view', 'lab_orders.create', 'lab_orders.update', 'lab_orders.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions($permissions);

        $this->admin = User::create([
            'name' => 'Clinical Admin',
            'email' => 'clinical-admin@example.com',
            'password' => Hash::make('Password123!'),
            'role' => 'admin',
        ]);
        $this->admin->assignRole($adminRole);

        $patientUser = User::create([
            'name' => 'Clinical Patient',
            'email' => 'clinical-patient@example.com',
            'password' => Hash::make('Password123!'),
            'role' => 'patient',
        ]);
        $this->patient = Patient::create([
            'user_id' => $patientUser->id,
            'phone' => '0123456789',
        ]);
    }

    public function test_admin_can_complete_appointment_and_encounter_workflow(): void
    {
        $appointment = Appointment::create([
            'patient_id' => $this->patient->id,
            'user_id' => $this->patient->user_id,
            'patient_name' => 'Clinical Patient',
            'email' => 'clinical-patient@example.com',
            'phone' => '0123456789',
            'department' => 'General',
            'appointment_date' => now()->toDateString(),
            'appointment_time' => '09:00',
            'date' => now()->toDateString(),
            'time' => '09:00',
            'status' => 'scheduled',
        ]);

        $this->actingAs($this->admin)
            ->put(route('admin.appointments.update', $appointment, absolute: false), [
                'patient_id' => $this->patient->id,
                'appointment_date' => now()->addDay()->toDateString(),
                'appointment_time' => '10:30',
                'status' => 'completed',
                'reason' => 'Follow-up',
                'notes' => 'Visit completed.',
            ])
            ->assertRedirect(route('admin.appointments.show', $appointment, absolute: false));

        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'status' => 'completed',
            'reason' => 'Follow-up',
        ]);

        $this->actingAs($this->admin)
            ->post(route('admin.encounters.store', absolute: false), [
                'appointment_id' => $appointment->id,
                'patient_id' => $this->patient->id,
                'encounter_type' => 'outpatient',
                'started_at' => now()->subHour()->format('Y-m-d H:i:s'),
                'diagnosis' => 'Initial diagnosis',
            ])
            ->assertRedirect(route('admin.encounters.index', absolute: false));

        $encounter = Encounter::query()->firstOrFail();

        $this->actingAs($this->admin)
            ->put(route('admin.encounters.update', $encounter, absolute: false), [
                'appointment_id' => $appointment->id,
                'patient_id' => $this->patient->id,
                'encounter_type' => 'follow_up',
                'started_at' => now()->subHour()->format('Y-m-d H:i:s'),
                'ended_at' => now()->format('Y-m-d H:i:s'),
                'diagnosis' => 'Confirmed diagnosis',
                'treatment_plan' => 'Continue treatment.',
            ])
            ->assertRedirect(route('admin.encounters.show', $encounter, absolute: false));

        $this->assertDatabaseHas('encounters', [
            'id' => $encounter->id,
            'encounter_type' => 'follow_up',
            'diagnosis' => 'Confirmed diagnosis',
        ]);
    }

    public function test_admin_can_create_lab_order_and_record_results(): void
    {
        $this->actingAs($this->admin)
            ->post(route('admin.lab-orders.store', absolute: false), [
                'patient_id' => $this->patient->id,
                'notes' => 'Fasting sample',
                'items' => [
                    ['test_name' => 'Blood Glucose', 'test_code' => 'GLU', 'specimen' => 'Blood'],
                    ['test_name' => '', 'test_code' => '', 'specimen' => ''],
                ],
            ])
            ->assertRedirect(route('admin.lab-orders.index', absolute: false));

        $order = LabOrder::query()->firstOrFail();
        $item = $order->items()->firstOrFail();

        $this->assertSame(1, $order->items()->count());

        $this->actingAs($this->admin)
            ->put(route('admin.lab-orders.update', $order, absolute: false), [
                'status' => 'completed',
                'notes' => 'Verified result',
                'items' => [[
                    'id' => $item->id,
                    'status' => 'resulted',
                    'result' => '95',
                    'unit' => 'mg/dL',
                    'reference_range' => '70-99',
                ]],
            ])
            ->assertRedirect(route('admin.lab-orders.show', $order, absolute: false));

        $this->assertDatabaseHas('lab_orders', ['id' => $order->id, 'status' => 'completed']);
        $this->assertDatabaseHas('lab_order_items', [
            'id' => $item->id,
            'status' => 'resulted',
            'result' => '95',
            'unit' => 'mg/dL',
        ]);
        $this->assertNotNull(LabOrderItem::findOrFail($item->id)->resulted_at);
    }
}