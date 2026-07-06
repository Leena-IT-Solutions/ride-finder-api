<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;

class ManagerTest extends TestCase
{
    use RefreshDatabase;

    public function test_manager_can_access_dashboard(): void
    {
        // 1. Create a user with manager role
        $manager = User::factory()->create([
            'roles' => ['manager'],
        ]);

        // 2. Perform request acting as manager
        $response = $this->actingAs($manager)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Managers');
    }

    public function test_regular_user_cannot_access_dashboard(): void
    {
        // 1. Create a regular user
        $user = User::factory()->create([
            'roles' => ['user'],
        ]);

        // 2. Attempt to access dashboard
        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        // 3. Assert redirected to login with error
        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error');
    }

    public function test_dashboard_shows_manager_statistics(): void
    {
        $admin = User::factory()->create([
            'roles' => ['admin'],
        ]);

        // Create 3 manager users
        User::factory()->count(3)->create([
            'roles' => ['manager'],
        ]);

        // Access the Dashboard Livewire component acting as admin
        Livewire::actingAs($admin)
            ->test(\App\Livewire\Admin\Dashboard::class)
            ->assertSee('Managers')
            ->assertSee('3');
    }

    public function test_admin_can_toggle_user_roles(): void
    {
        $admin = User::factory()->create([
            'roles' => ['admin'],
        ]);

        $targetUser = User::factory()->create([
            'roles' => ['user'],
        ]);

        // 1. Assign 'manager' role
        Livewire::actingAs($admin)
            ->test(\App\Livewire\Admin\Users::class)
            ->call('toggleRole', $targetUser->id, 'manager');

        $targetUser->refresh();
        $this->assertContains('manager', $targetUser->roles);
        $this->assertContains('user', $targetUser->roles);

        // 2. Revoke 'user' role
        Livewire::actingAs($admin)
            ->test(\App\Livewire\Admin\Users::class)
            ->call('toggleRole', $targetUser->id, 'user');

        $targetUser->refresh();
        $this->assertNotContains('user', $targetUser->roles);
        $this->assertContains('manager', $targetUser->roles);
    }

    public function test_admin_cannot_self_revoke_admin_role(): void
    {
        $admin = User::factory()->create([
            'roles' => ['admin'],
        ]);

        Livewire::actingAs($admin)
            ->test(\App\Livewire\Admin\Users::class)
            ->call('toggleRole', $admin->id, 'admin');

        $admin->refresh();
        $this->assertContains('admin', $admin->roles);
    }
}
