<?php

namespace Database\Factories;

use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition(): array
    {
        $menu = Menu::factory()->create();
        $quantity = $this->faker->numberBetween(1, 5);
        return [
            'order_id' => Order::factory(),
            'menu_id' => $menu->id,
            'quantity' => $quantity,
            'price' => $menu->price,
            'subtotal' => $menu->price * $quantity,
        ];
    }
}
