<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Burger;

class KioskOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_order()
    {
        $burger = Burger::create([
            'name' => 'Test Burger',
            'price' => 5000,
            'stock_quantity' => 10,
            'description' => 'Test',
        ]);

        $response = $this->postJson(route('kiosk.order.store'), [
            'client_name' => 'John Doe',
            'client_phone' => '1234567890',
            'items' => [
                ['id' => $burger->id, 'quantity' => 2]
            ]
        ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('orders', [
            'client_name' => 'John Doe',
            'total_amount' => 10000,
        ]);

        $this->assertDatabaseHas('order_items', [
            'burger_id' => $burger->id,
            'quantity' => 2,
        ]);

        $this->assertDatabaseHas('burgers', [
            'id' => $burger->id,
            'stock_quantity' => 8,
        ]);
    }
}
