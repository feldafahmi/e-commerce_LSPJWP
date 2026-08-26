<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileNavigationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_sees_login_and_register_buttons(): void
    {
        $this->get(route('home'))->assertSee('Masuk')->assertSee('Daftar');
    }

    public function test_authenticated_buyer_sees_profile_menu_instead_of_auth_buttons(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'pembeli']))
            ->get(route('home'))
            ->assertSee('Profil saya')
            ->assertSee('Keluar')
            ->assertDontSee('href="http://localhost:8000/login"')
            ->assertDontSee('href="http://localhost:8000/register"');
    }

    public function test_user_can_view_profile_and_logout(): void
    {
        $user = User::factory()->create(['role' => 'pembeli']);

        $this->actingAs($user)->get(route('profile'))->assertOk()->assertSee($user->email);
        $this->actingAs($user)->post(route('logout'))->assertRedirect(route('home'));
    }
}
