<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AuthAndPatientTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_renders(): void
    {
        $this->get('/login')
            ->assertOk()
            ->assertSee('Sign in');
    }

    public function test_register_page_renders(): void
    {
        $this->get('/register')
            ->assertOk()
            ->assertSee('Create account');
    }

    public function test_forgot_password_page_renders(): void
    {
        $this->get('/forgot-password')
            ->assertOk()
            ->assertSee('Forgot your password', false);
    }

    public function test_reset_password_page_renders(): void
    {
        $this->get('/reset-password/test-token')
            ->assertOk()
            ->assertSee('Reset password');
    }

    public function test_two_factor_challenge_page_renders(): void
    {
        $this->get('/two-factor-challenge')
            // Fortify only shows the 2FA challenge during an in-progress 2FA login flow.
            ->assertRedirect('/login');
    }

    public function test_register_creates_patient_profile_and_assigns_patient_role(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test Patient',
            'username' => 'testpatient',
            'email' => 'testpatient@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertRedirect('/dashboard');

        $user = User::query()->where('email', 'testpatient@example.com')->firstOrFail();
        $this->assertNotNull($user->patient);
        $this->assertTrue($user->hasRole('patient'));
    }

    public function test_web_login_accepts_username_or_email(): void
    {
        Role::firstOrCreate(['name' => 'patient']);

        $user = User::create([
            'name' => 'Login User',
            'username' => 'loginuser',
            'email' => 'loginuser@example.com',
            'password' => Hash::make('Password123!'),
        ]);
        $user->assignRole('patient');
        $user->patient()->create([]);

        $this->post('/login', [
            'login' => 'loginuser',
            'password' => 'Password123!',
        ])->assertRedirect('/dashboard');

        $this->post('/logout')->assertRedirect('/');

        $this->post('/login', [
            'login' => 'loginuser@example.com',
            'password' => 'Password123!',
        ])->assertRedirect('/dashboard');
    }

    public function test_api_login_accepts_username_or_email(): void
    {
        $user = User::create([
            'name' => 'API User',
            'username' => 'apiuser',
            'email' => 'apiuser@example.com',
            'password' => Hash::make('Password123!'),
        ]);

        $response = $this->postJson('/api/login', [
            'login' => 'apiuser@example.com',
            'password' => 'Password123!',
        ]);

        $response->assertOk();
        $response->assertJsonStructure(['token', 'user']);
    }
}
