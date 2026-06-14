<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_login_screen_is_removed(): void
    {
        $this->get('/login')->assertNotFound();
    }

    public function test_admin_login_screen_can_be_rendered(): void
    {
        $this->get('/sudut-panel/admin/login')
            ->assertOk()
            ->assertSee('AKSES ADMIN');
    }

    public function test_admin_can_authenticate_using_admin_login_screen(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->post('/sudut-panel/admin/login', [
            'email' => $admin->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($admin);
        $response->assertRedirect(route('admin.dashboard', absolute: false));
    }

    public function test_non_admin_user_can_not_authenticate(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->from('/sudut-panel/admin/login')->post('/sudut-panel/admin/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertGuest();
        $response
            ->assertRedirect('/sudut-panel/admin/login')
            ->assertSessionHasErrors('email');
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->post('/sudut-panel/admin/login', [
            'email' => $admin->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_admin_can_logout(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
