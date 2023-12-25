<?php

namespace Domain\Order\Actions\Validation;

use App\BaseApp\Enums\UnitEnums;
use Domain\Models\Ingredient\Ingredient;
use Domain\Order\Actions\PlaceOrder\GetProductWithIngredientsAction;
use Domain\Order\DataTransferObject\OrderDto;
use Domain\Order\Resources\OrderResourceInterface;
use Domain\Order\Resources\Validations\ValidateMakeOrderSuccessResource;
use Domain\Order\Resources\Validations\ValidateProductIngredientInStockFailedResource;

class ValidateProductIngredientInStockAction
{
    public function __invoke(OrderDto $orderDto): OrderResourceInterface
    {
        foreach ($orderDto->products as $product) {
            $productId = $product['product_id'];
            $productQuantity = $product['quantity'];

            $product = (new GetProductWithIngredientsAction())($productId);

            foreach ($product->ingredients as $ingredient) {
                $validationResult = $this->validateIngredientStock($ingredient, $productQuantity);
                if (!$validationResult->status()) {
                    return $validationResult;
                }
            }
        }
        return new ValidateMakeOrderSuccessResource();
    }

    private function validateIngredientStock(Ingredient $ingredient, $quantity): OrderResourceInterface
    {
        $gramsConsumed = $ingredient->pivot->quantity * $quantity;

        if ($ingredient->unit === UnitEnums::KILO_GRAM) {
            $gramsConsumed /=  1000;
        }

        if ($gramsConsumed > $ingredient->stock_quantity) {
            return new ValidateProductIngredientInStockFailedResource();
        }
        return new ValidateMakeOrderSuccessResource();
    }
}
