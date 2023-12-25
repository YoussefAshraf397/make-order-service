<?php

namespace App\Order\Visitor\Tests;

use Domain\Models\Product\Product;
use Domain\Order\Jobs\SendLowStockNotification;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class MakeOrderWithMailNotificationTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testMakeOrderAndSendEmailToStock()
    {
        Queue::fake();

        $productId = 1;
        $quantity = 40;
        $data = [
            'products' => [
                [
                    'product_id' => $productId,
                    'quantity' => $quantity
                ]
            ],
        ];

        //assert ingredients and orders before make order
        $this->assertDatabaseCount('ingredients', 3);
        $this->assertDatabaseHas('ingredients', [
            'id' => 1,
            'stock_quantity' => 20,
            'initial_stock' => 20,
        ]);
        $this->assertDatabaseCount('orders', 0);

        $response = $this->postJson(
            uri: route('api.order.visitor.make-order', ["language" => "en"]),
            data: $data
        );

        //assert ingredients after make order
        $response->assertOk();
        $response->assertJsonStructure([
            'meta' => [
                'message',
                'status'
            ]
        ]);

        $product = Product::find($productId);
        foreach ($product->ingredients as $ingredient) {
            $consumedQuantity = $ingredient->pivot->quantity * $quantity;
            if ($ingredient->unit == 'kg') {
                $consumedQuantity /=  1000;
            }
            $stockQuantity = $ingredient->initial_stock - $consumedQuantity;
            $this->assertDatabaseHas('ingredients', [
                'id' => $ingredient->id,
                'stock_quantity' => $stockQuantity,
                'initial_stock' => $ingredient->initial_stock,
                'email_sent' => $ingredient->initial_stock * 0.5 > $stockQuantity
            ]);
        }

        $this->assertDatabaseCount('orders', 1);
        $this->assertDatabaseHas('order_products', [
            'id' => 1,
            'order_id' => 2,
            'product_id' => $productId,
            'quantity' => $quantity,
        ]);
        Queue::assertPushed(SendLowStockNotification::class);
    }
}
