<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_preorder_and_quota_enforced()
    {
        $user = User::factory()->create();
        $menu = Menu::factory()->create(['daily_quota' => 2, 'price' => 10000]);

        $this->actingAs($user);

        $date = now()->toDateString();
        $response = $this->post(route('orders.pre-order'), [
            'order_date' => $date,
            'items' => [
                ['menu_id' => $menu->id, 'quantity' => 1]
            ],
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', ['user_id' => $user->id, 'order_date' => $date]);

        // second order should still be allowed until quota used
        $response = $this->post(route('orders.pre-order'), [
            'order_date' => $date,
            'items' => [
                ['menu_id' => $menu->id, 'quantity' => 1]
            ],
        ]);
        $response->assertRedirect();

        // third order should be blocked by quota
        $response = $this->post(route('orders.pre-order'), [
            'order_date' => $date,
            'items' => [
                ['menu_id' => $menu->id, 'quantity' => 1]
            ],
        ]);
        $response->assertSessionHas('error');
    }

    public function test_admin_can_see_all_orders_and_update_status()
    {
        $admin = User::factory()->admin()->create();
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id]);

        $this->actingAs($admin);
        $response = $this->get(route('orders.index'));
        $response->assertStatus(200);
        $response->assertSee($user->name);

        $response = $this->put(route('orders.update', $order), ['status' => 'confirmed']);
        $response->assertRedirect(route('orders.show', $order));
        $this->assertDatabaseHas('orders', ['id' => $order->id, 'status' => 'confirmed']);

        // can also mark completed
        $response = $this->put(route('orders.update', $order), ['status' => 'completed']);
        $this->assertDatabaseHas('orders', ['id' => $order->id, 'status' => 'completed']);
    }

    public function test_user_cannot_cancel_other_people_order()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user2->id]);

        $this->actingAs($user1);
        $response = $this->delete(route('orders.destroy', $order));
        $response->assertStatus(403);
    }

    public function test_user_can_mark_confirmed_order_completed()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id, 'status' => 'confirmed']);

        $this->actingAs($user);
        $response = $this->put(route('orders.update', $order), ['status' => 'completed']);
        $response->assertRedirect(route('orders.show', $order));
        $this->assertDatabaseHas('orders', ['id' => $order->id, 'status' => 'completed']);
    }
}
