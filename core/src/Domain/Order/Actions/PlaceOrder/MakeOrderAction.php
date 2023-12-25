<?php

namespace Domain\Order\Actions\PlaceOrder;

use Domain\Models\Order\Order;
use Domain\Order\Actions\Validation\ValidateProductIngredientInStockAction;
use Domain\Order\DataTransferObject\OrderDto;
use Domain\Order\Resources\MakeOrder\MakeOrderSuccessResource;
use Domain\Order\Resources\OrderResourceInterface;

class MakeOrderAction
{
    public function __invoke(OrderDto $orderDto): OrderResourceInterface
    {
        $checkIngredientEnoughInStock = (new ValidateProductIngredientInStockAction())($orderDto);
        if (!$checkIngredientEnoughInStock->status()) {
            return $checkIngredientEnoughInStock;
        }
        $order = Order::create();
        foreach ($orderDto->products as $productData) {
            $productId = $productData['product_id'];
            $productQuantity = $productData['quantity'];

            $product = (new GetProductWithIngredientsAction())($productId);
            (new InitiateOrderAction())($product, $order, $productQuantity);
            (new UpdateStockAction())($product, $productQuantity);
        }
        return new MakeOrderSuccessResource();
    }
}
