<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_is_available(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Masuk ke akun Anda');
    }

    public function test_registration_creates_and_authenticates_a_buyer(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'Sari Belanja',
            'email' => 'sari@example.com',
            'role' => 'pembeli',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'sari@example.com',
            'role' => 'pembeli',
            'status' => 'aktif',
        ]);
    }

    public function test_user_can_login_with_active_account(): void
    {
        $user = User::factory()->create([
            'email' => 'buyer@example.com',
            'password' => 'password123',
            'status' => 'aktif',
        ]);

        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password123',
        ])->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_inactive_user_cannot_login(): void
    {
        $user = User::factory()->create([
            'email' => 'inactive@example.com',
            'password' => 'password123',
            'status' => 'tidak aktif',
        ]);

        $this->from(route('login'))->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password123',
        ])->assertRedirect(route('login'));

        $this->assertGuest();
    }
}
