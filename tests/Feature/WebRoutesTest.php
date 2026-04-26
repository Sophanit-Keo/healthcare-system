<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class WebRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_from_dashboard(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
    }

    public function test_profile_page_renders_for_authenticated_user(): void
    {
        Role::firstOrCreate(['name' => 'patient']);

        $user = User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => Hash::make('Password123!'),
        ]);
        $user->assignRole('patient');
        $user->patient()->create([]);

        $this->actingAs($user)->get('/profile')->assertOk()->assertSee('Profile');
    }

    public function test_patient_can_access_patient_routes_but_not_admin_dashboard(): void
    {
        Role::firstOrCreate(['name' => 'patient']);

        $user = User::create([
            'name' => 'Patient',
            'email' => 'patient2@example.com',
            'password' => Hash::make('Password123!'),
        ]);
        $user->assignRole('patient');
        $user->patient()->create([]);

        $this->actingAs($user)->get(route('patient.appointments.index'))->assertOk();
        $this->actingAs($user)->get(route('admin.dashboard'))->assertStatus(403);
    }

    public function test_doctor_can_access_admin_dashboard_but_not_patient_routes(): void
    {
        Role::firstOrCreate(['name' => 'doctor']);

        $user = User::create([
            'name' => 'Doctor',
            'email' => 'doctor2@example.com',
            'password' => Hash::make('Password123!'),
        ]);
        $user->assignRole('doctor');

        $this->actingAs($user)->get(route('admin.dashboard'))->assertOk();
        $this->actingAs($user)->get(route('patient.appointments.index'))->assertStatus(403);
    }
}
