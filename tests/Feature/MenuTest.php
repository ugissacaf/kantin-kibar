<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_perform_crud_on_menus()
    {
        $admin = User::factory()->admin()->create();
        $this->actingAs($admin);

        // create
        $response = $this->post(route('menus.store'), [
            'name' => 'Nasi Goreng',
            'description' => 'Delicious',
            'price' => 15000,
            'category' => 'makanan',
            'daily_quota' => 10,
            'is_available' => true,
        ]);
        $response->assertRedirect(route('menus.index'));
        $this->assertDatabaseHas('menus', ['name' => 'Nasi Goreng']);

        $menu = Menu::first();

        // update
        $response = $this->put(route('menus.update', $menu), [
            'name' => 'Nasi Goreng Spesial',
            'price' => 20000,
            'category' => 'makanan',
            'daily_quota' => 5,
            'is_available' => false,
        ]);
        $response->assertRedirect(route('menus.index'));
        $this->assertDatabaseHas('menus', ['name' => 'Nasi Goreng Spesial', 'is_available' => false]);

        // delete
        $response = $this->delete(route('menus.destroy', $menu));
        $response->assertRedirect(route('menus.index'));
        $this->assertDatabaseMissing('menus', ['id' => $menu->id]);
    }

    public function test_non_admin_cannot_access_menu_creation()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('menus.create'));
        $response->assertStatus(403);
    }
}
